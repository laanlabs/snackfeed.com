<?

class Video {


	public static function playlist_add($options = array())
	{
		
		$defaults = array("group_id" => "0", "group_title" => "", "user_id" => User::$user_id, "source_id" => "1", "date_added" => date("Y-m-d G:i:s"), "order_by" => 50);
		
		$options = array_merge($defaults, $options);
		
		$sql = "INSERT INTO playlists  SET
				group_id = '{$options["group_id"]}',
				group_title = '{$options["group_title"]}',
				user_id = '{$options["user_id"]}',				
				video_id = '{$options["video_id"]}',
				source_id = '{$options["source_id"]}',
				date_added = '{$options["date_added"]}',
				order_by = '{$options["order_by"]}'
					;";
			DB::query($sql, false);	
			echo "added";
			die();		
	}


	public static function playlist_remove($_playlist_id)
	{
		

		$sql = " DELETE FROM playlists WHERE playlist_id = '{$_playlist_id}'";
		
		
		DB::query($sql, false);
		
	}

	public static function playlist_clear($req)
	{
		$_group_id = $req['rem_group_id'];
		$_user_id = User::$user_id;
	
		
		$sql = " DELETE FROM playlists WHERE group_id = '{$_group_id}'
		AND user_id = '{$_user_id}'";

		
		DB::query($sql, false);
		
		if ($req['plain'] == '1')
		{
			global $_t; $_t = "empty";
			echo "cleared";
		}
		
	}


	public static function playlist_count()
	{
		$_user_id = User::$user_id;
		$sql = "SELECT count(playlist_id) as vCount FROM playlists WHERE user_id = '{$_user_id}' AND group_id = '0';";
		$q = DB::query($sql);
		return $q[0]['vCount'];
		
	}


	public static function playlist_get($_group_id)
	{
		
	
		$_user_id = User::$user_id;
	
		
		$sql = "SELECT v.*, p.playlist_id, p.group_id, p.group_title
					FROM playlists p
					  JOIN videos v ON p.video_id = v.video_id
					WHERE p.user_id = '{$_user_id}'
					AND p.group_id = '{$_group_id}'";
					
		$data = DB::query($sql);

		return $data;			
		
		
	}


	public static function playlists_get()
	{
		$sql = "SELECT DISTINCT group_id, group_title 
		FROM playlists
		WHERE user_id = '" . User::$user_id . "'
		AND group_id != '0'";
		
		return DB::query($sql);
		
	}

	public static function playlist_save($group_title)
	{
		$_group_id =  DB::UUID();
		$_user_id = User::$user_id;
		

		
		$sql = "UPDATE playlists SET
					group_title = '{$group_title}',
					group_id = '{$_group_id}'
				WHERE user_id = '{$_user_id}'
				AND group_id = '0'";
					
		DB::query($sql, false);
		
		return $_group_id ;
	}



	public static function ext($req)
	{
		
		global $_action, $swf_embed_url, $keywords, $video_data, $channel_data;
		$video_id = $req['id'];
		
		if ( !$video_id ) return;
		
		//look for this video on our system and send to page if it exists
		$sql = "SELECT v.video_id FROM videos v WHERE org_video_id = '{$video_id}'";
		$q = DB::query($sql);
		$_video_id = $q[0]['video_id'];
		
		if (empty($_video_id))
		{
				//only works for youtube
				if ($req['t'] != 'yt') die('only youtube');
				$func = "make_" .$req['t'];
				$nVars = self::$func($req);
				$req = array_merge($nVars, $req);
				$_video_id = self::insert_video($req);	
		} 
		
		if (!array_key_exists('noredir', $req)) {
			header("Location: /videos/detail/{$_video_id}?u=" . User::$username );		
		} else {
			return $_video_id;
		}		
			
	}
	
	
	
	
	public function detail( $req )
	{
		global $req_login; $req_login = false;
		
		
		global $video_data, $channel_data, $related_videos, 
				$related_type, $show_data, $next_video, $playlist_data, $playlist_group_id, $next_video_id , $_video_history, 
				$next_title, $next_params, $following,
				$_s;
				
				
		global $header_block, $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		
		//set defaults
		$_s = isset($req['_s']) ? $req['_s'] : "s";
		$next_params = "?";
		
	
		require_once LIB."/TinyHelper.php";
		
		if ( ! ( $req['u'] || $req['p'] )  ) {
			
			// if you have gotten to this video with no referrer, 
			// set it equal to you, and redirect, this way you will be in the url bar
			// in case you decide to send the video to friends.
			
			//if ( User::$user_id != "0" )
			//	header("Location: /videos/detail/".$req['id']."?u=".User::$username );
			//else if ( PseudoUser::$pseudo_user_id )
			//	header("Location: /videos/detail/".$req['id']."?p=".PseudoUser::$pseudo_user_id);
			
		}
		
		// if the p,u is you, then that means you clicked to watch, got redirected, and so now
		// we still want to note that you watched this, but dont think that its a referall from me.
		/*
		$history = new History();
		$history->url_user_nickname = $req['u'];
		$history->url_pseudo_user_id = $req['p'];
		$history->video_id = $req['id'];
		$history->viewing_user_id = User::$user_id;
		$history->viewing_pseudo_user_id = PseudoUser::$pseudo_user_id;
		
		$history->process();
		
		$_video_history = $history->get_history_from_history_id( $history->history_id , User::$user_id );
		*/
		
		$video_data = self::find(array("video_id" => $req['id']));
		

		
		
		$video_data['escaped_link'] = htmlentities(BASE_URL."/videos/detail/".$req['id']);
		
		include LIB."/external_video_helper.php";
		$video_data['embed_code'] = ExternalVideoHelper::get_embed_code( $video_data[0] , "snackfeed");
		
		
		//set meta info
		$sf_title = htmlspecialchars(stripslashes($video_data[0]['show_title'])) . 
			" - ". htmlspecialchars(stripslashes($video_data[0]['title']));
		$sf_meta_title = $sf_title;
		$sf_meta_desc = htmlspecialchars(stripslashes($video_data[0]['detail']));
		$header_block .= "
		<meta name=\"video_width\" content=\"400\" />
		<meta name=\"video_height\" content=\"320\" />
		<meta name=\"video_type\" content=\"application/x-shockwave-flash\" />
		<link rel=\"videothumbnail\" href=\"{$video_data[0]['thumb']}\" />
		<link rel=\"image_src\" href=\"{$video_data[0]['thumb']}\" />
		<link rel=\"video_src\" href=\"{$video_data[0]['url_source']}\" />";
		
		
		
		if ( User::$user_id != '0')
		{
			$channel_data = Channel::find(array("owner_id" => User::$user_id, "role_ids" => "2,100" ));
			Status::status_update_watched_video( $video_data[0] );
			//echo print_r($video_data);
		}
		
		
		/// Is a user following the show that this video is from... 
		////  *** REDO THIS ***
		$following = false;
		
		if ( User::$user_id != '0' && $video_data[0]['show_id'] ) {
			$user_shows = Show::get_user_shows( $video_data[0]['show_id'] );
			for ($i=0; $i < count($user_shows); $i++) { 
				if ($user_shows[$i]['user_id'] == User::$user_id) $following = true;
			}
		}
		
		
		
		// !!! needs to be redone
		///////////////////
		// START NEXT VIDEO
		///////////////////



		if ( $video_data[0]['show_id'] ) {
			
			
			
			//get some related vids -- NEEDS TO IMPROVED and abstracted -- also get show info
			
			$sql = "SELECT 
					v.title, v.detail, v.video_id, v.org_video_id, v.show_id, v.season, v.episode,
					if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
					v.date_added, v.url_link, v.url_source, v.thumb, v.duration,
					v.use_link,
					shows.title AS show_title, 
					shows.detail AS show_detail,
          			shows.thumb AS show_thumb,
					v.has_children, v.video_type_id,
					shows.show_type_id
					FROM videos AS v
					  JOIN shows ON v.show_id = shows.show_id
					WHERE 1 
						AND v.show_id = '{$video_data[0]['show_id']}'
					  AND v.parent_id = '0' ORDER BY v.date_pub DESC, v.title LIMIT 0, 100";
			
			
			$show_data = DB::query($sql);
	
			//set the next video id
			$next_video_id =  $show_data[0]['video_id'];
			$next_video[0] =  $show_data[0];
			

			
		}
		
		
		
		//SET THE FEED LIST
		if ($_s == 'f')
		{
			$next_title = "public feed";	
			$sql = " SELECT f.*, s.title as show_title
					 FROM feed_publics f
						LEFT OUTER JOIN shows s ON f.show_id = s.show_id
					 WHERE f.status = 1	
					 ORDER BY date_added desc
					 LIMIT 200 ";
			
			$feed_video = DB::query($sql);
			$next_params .= "&_s=f";
		} else if ($_s == 'u') {
			$next_title = "your feed";	
			$feed_video = feed::feed_expanded(array("user_id" => User::$user_id));
			$next_params .= "&_s=u";
			
		} else {
			$next_title = "this show"; 
			$feed_video =  $show_data;
			
						
			
		}		
		
		$found_video = false;
		$next_video = array();
		

			for ($i=0; $i < count($feed_video); $i++) 
			{ 
				
				if ( $found_video == true ) {
					array_push( $next_video , $feed_video[$i] );
					if ( count($next_video) > 5 ) break;
				}
				
				if ( $feed_video[$i]['video_id'] == $video_data[0]['video_id'])
				{
					$found_video = true;
					$next_video_id = $feed_video[$i+1]['video_id'];
					
				}
				
			}
		

			
		///////////////////
		// END NEXT VIDEO
		///////////////////
		
		
		
		
		//GET USERS playlist
		if (array_key_exists("pl", $req))
		{
			
			$next_title = "your playlist";
			$playlist_data = Video::playlist_get($req['group_id']);
			$playlist_group_id = $req['group_id'];
			
			$found_video = false;
			$next_video = array();
			
			for ($i=0; $i < count($playlist_data); $i++) 
			{ 
				if ( $found_video == true ) {
					array_push( $next_video , $playlist_data[$i] );
					if ( count($next_video) > 5 ) break;
				}
				
				if ( $playlist_data[$i]['video_id'] == $video_data[0]['video_id'])
				{
					$found_video = true;
					//$next_video_id = $playlist_data[$i+1]['video_id'];
					if ( $i+1 <  count($playlist_data) ) {
						$next_video_id = $playlist_data[$i+1]['video_id'] . "?pl=" . ($i+1) . "&group_id=".$playlist_data[0]['group_id'];
					}
				}
				
			}
			
			
			
			
			
			/*
			for ($i = 0 ; $i < count($playlist_data) ; $i++) { 
				if ($req['id'] == $playlist_data[$i]['video_id']) $next = $i+1;
			}
			
			if ($next+1 <= count($playlist_data))
			{
				$next_video_id =  $playlist_data[$next]['video_id'] . "?pl=" . $next . "&group_id=" . $playlist_data[0]['group_id'];
			}
			*/
			
			
			
			
			
		}

		
	}
	
	
	
	
	public static function get($req) {
		
		$rows = self::find($req);
		$data = array("videos" => $rows);
		
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		

	
	
	
	}
	
	

	
	public static function find($options = array()) {
		
		$defaults = array("order" => "v.date_added-DESC, v.title ", "limit" => 500, "offset" => 0);
		
		$options = array_merge($defaults, $options);
		
		$options['order'] = str_replace("-", " ", $options['order']);
		
		foreach ($options as $key => $value) {
			$options[$key] = DB::escape($value);
		}
		
		$joins = "";
		$columns = "";
		$conditions = "1";
		if (array_key_exists("show_id", $options)) {
			//$conditions .= " AND v.show_id IN (".quote_csv($options['show_ids']).")";
			$conditions .= " AND v.show_id = ".quote_csv($options['show_id'])."";
			
		}
		if (array_key_exists("video_id", $options)) {
			$conditions .= " AND v.video_id = '{$options['video_id']}'";
		}
		if (array_key_exists("starting_video_id", $options)) {
			//$conditions .= " AND v.video_id > '{$options['starting_video_id']}'";
			$conditions .= " AND v.date_added < (select v2.date_added from videos v2 where v2.video_id = '{$options['starting_video_id']}')";
			
		}
		
		
		if (array_key_exists("include_children", $options)) {
			$joins .= "
				LEFT JOIN videos AS children ON v.video_id = children.parent_id
			";
			$conditions .= " AND v.video_id IN (".quote_csv($options['video_ids']).")";
		}
		
		if (array_key_exists("user_id", $options)) {
			//$conditions .= " AND v.video_id not in (SELECT uv.video_id FROM user_videos uv WHERE uv.user_id = '{$options['user_id']}')";
			$joins = " LEFT OUTER JOIN user_videos uv ON uv.video_id = v.video_id AND uv.user_id = '{$options['user_id']}'";
			$columns = ", IF((uv.user_id IS NULL ), 0, 1) AS watched ";
		}
			
		if (array_key_exists("date", $options)) {	
			$conditions .= " AND v.date_added > '{$options['date']}' ";
			
		}	
		
		if (array_key_exists("filter", $options)) {
			
			$conditions .= " AND ((v.title LIKE '%{$options['filter']}%') OR (v.detail LIKE '%{$options['filter']}%'))";

		}
		
		if (array_key_exists("video_type_id", $options)) {
			
			$conditions .= "AND v.video_type_id IN ({$options['video_type_id']}) ";

		}
		


		
		$sql = "
			SELECT v.title, v.detail, v.video_id, v.org_video_id, v.show_id,
			v.season, v.episode, v.video_iid,
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
			v.date_added,
		
			v.url_link, v.url_source, v.thumb, v.duration,
			sources.client_lib, IF((sources.client_lib IS NULL OR sources.client_lib = ''), 0, 1) AS use_client_lib,
			v.use_embedded,
			v.use_link,
			sources.proxy_url, IF((sources.proxy_url IS NULL OR sources.proxy_url = ''), 0, 1) AS use_proxy_url,
			shows.title AS show_title, v.has_children, v.video_type_id, v.param_1, v.param_2, param_3, param_4, shows.show_type_id
			{$columns}
			FROM videos AS v
			LEFT OUTER JOIN sources ON v.source_id = sources.source_id
			JOIN shows ON v.show_id = shows.show_id
			{$joins}
			WHERE {$conditions}
			AND v.parent_id = '0'
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
			
		";
		
		//echo $sql; die();
		
		$results = DB::query($sql);
		
		//put segments in video list if necessary
		//insert channel videos as nested queries
		if (!array_key_exists("nosegments", $options)) {
			for ($i = 0 ; $i < count($results) ; $i++)
			{
				$id =  $results[$i]['video_id'];
				if ($results[$i]['has_children'] == '1')
				{
					$segments = self::get_segments($id);
					array_push($results[$i], $segments);
				}	
			}	
		}

		return $results;
		
	}
	
	public static function get_segments($id)
	{
		
		$sql = "
			SELECT v.title, v.detail, v.video_id, v.show_id, 
			v.season, v.episode, v.date_air, v.date_pub, v.url_link, v.url_source, v.thumb, v.duration,
			sources.client_lib, IF((sources.client_lib IS NULL OR sources.client_lib = ''), 0, 1) AS use_client_lib,
			v.use_embedded,
			sources.proxy_url, IF((sources.proxy_url IS NULL OR sources.proxy_url = ''), 0, 1) AS use_proxy_url,
			shows.title AS show_title, v.has_children, v.video_type_id, v.param_1, v.param_2, param_3, param_4
			FROM videos AS v
			JOIN sources ON v.source_id = sources.source_id
			JOIN shows ON v.show_id = shows.show_id
			WHERE v.parent_id = '" .  $id  ."'
			ORDER BY parent_order_by
	
		";			
		
		return DB::query($sql);
		
	}	
	
	public static function get_total_videos($id , $tids = "" ) {
		
			
		$conditions = "";
		if (!empty($tids)) $conditions .= "AND v.video_type_id IN ({$tids})";
		
		$sql = "
			SELECT count(v. video_id) as rCount
			FROM videos v
			WHERE show_id = '". $id . "'
			{$conditions}
			AND parent_id = '0'
		";
		$q = DB::query($sql);
		return $q[0]["rCount"];
	}	

	
	public static function related_products($req)
	{
		if (!array_key_exists('id', $req)) {
			throw new Exception("MISSING REQUIRED KEY id", 1); // abstract this
		} else {
		
			$sql = "
				SELECT name, thumb, link, detail, type, price
				FROM video_products
				WHERE video_id = '" . $req['id'] . "'
				UNION
				SELECT name, thumb, link, detail, type, price 
				FROM products 
				limit 1;
			";			


			//echo $sql; die();

			$data = DB::query($sql);
		
		
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else {
				render_data_as_xml($data);
			}

		}
		
	}
	
	public static function recommend_video($req)
	{
		
		
		
		$sql = array (
			"video_id"	 			=>	$req['video_id'],
			"segmentation_id"		=> 	$req['segmentation_id'],	
			"source_id"				=> 	1,	
			"weight"				=> 50,
			"date_added"	=>	date("Y-m-d G:i:s"),
			);
		

		$nSQL = "INSERT INTO recommendation_videos SET " . DB::assoc_to_sql_str($sql);	
				//echo $nSQL;
		DB::query($nSQL , false);	
		
		echo "video recommended";
		die();
		
		
	}
	
	
	
	public static function add_video($req)
	{
		
		if (!array_key_exists('source_id', $req)) {
			throw new Exception("MISSING REQUIRED KEY source_id", 1); // abstract this
		} else {
		
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		
		$_title = stripslashes($req['title']);
		
		
		$sql = array (
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_parent_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$req['source_id'],
			"show_id"		=> 	$req['show_id'],	
			"title"			=> 	$_title,	
			"detail"		=>	stripslashes($req['detail']),	
			"url_source" 	=>	$req['url_source'],
			"url_link"		=> 	$req['url_link'],	
			"thumb" 		=>	$req['thumb'],
			"param_1"		=>  $req['param_1'],
			"param_2"		=>	$req['param_2'],
			"param_3"		=>	$req['param_3'],
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	date("Y-m-d G:i:s")
	
			);
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		//echo $nSQL;
		DB::query($nSQL , false);		



		echo $_title;
		$_channel_ids = explode(",", $req['channel_ids']) ;
		
		foreach ($_channel_ids as $_channel_id ) {
			# insert channels and programs...
			echo $_channel_id . "<br>";
			
			if (!empty($_channel_id ))
			{	
				$sql = array(
					"channel_id" 	=> 	$_channel_id,
					"video_id"	 	=>	$_video_id,
					"order_by"		=>	"-" . time(),
					"status"		=>	1,
					"source"		=>	3,
					);

					$nSQL = "INSERT INTO channel_videos SET " . DB::assoc_to_sql_str($sql);
					echo $nSQL.  "<br>";
					DB::query($nSQL , false);

					echo time();
			}
					
		}
		
		
		die();
		

		
	}
		
	}			
	
	public function add_to_channel($req)
	{
		$_video_id = $req['id'];
		
		if ($req['ext']== 1)
		{
			
			$func = "make_" .$req['t'];
			
			$nVars = self::$func($req);
			$req = array_merge($nVars, $req);
			$_video_id = self::insert_video($req);
		}
		
		
		
					$sql = array(
					"channel_id" 	=> 	$req['channel_id'],
					"video_id"	 	=>	$_video_id,
					"order_by"		=>	"-" . time(),
					"status"		=>	1,
					"source"		=>	3,
					);

					$nSQL = "INSERT INTO channel_videos SET " . DB::assoc_to_sql_str($sql) . "ON DUPLICATE KEY UPDATE order_by = order_by	";
					//echo $nSQL.  "<br>";
					
					DB::query($nSQL , false);
					
					Status::added_video_to_channel( array(
					"channel_id" 	=> 	$req['channel_id'],
					"video_id"	 	=>	$_video_id
					));
					
					echo "<span style='color:#ff0000'>Added to Channel</span>"; die();
		
		
	}
	
	public function make_yt($req)
	{
		
		$_youtube_id =  $req['id'];
		$video_id = $_youtube_id;
		
		//we dont have it so addit
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$video_id;
		// read feed into SimpleXML object
		$entry = simplexml_load_file($feedURL);
		
		// get nodes in media: namespace for media information
		$media = $entry->children('http://search.yahoo.com/mrss/');
		
		// get video player URL
		$attrs = $media->group->player->attributes();
		$watch = $attrs['url']; 
		
		// get video thumbnail
		$attrs = $media->group->thumbnail[0]->attributes();
		$thumbnail = $attrs['url'];
		//echo $thumbnail;

		$req['title'] = $entry->title;
		$req['detail'] = $entry->content;
		$req['date_pub']= $entry->published; //date("Y-m-d", strtotime($entry->published));
		
		
		$_youTube_base = "http://www.youtube.com/v/";
		$_youTube_get_URL = "http://www.youtube.com/get_video.php?video_id=__VID__&t=__TID__";
		$_thumb_base = "http://i.ytimg.com/vi/__ID__/default.jpg";
		
		
		$req['source_id'] = "e23bf93e-7fdb-102b-908a-00304897c9c6";
		$req['show_id'] = "92a439fe-80bc-102b-908a-00304897c9c6";
		
		$req['thumb'] = str_replace("__ID__", $_youtube_id, $_thumb_base);;
		
		$req['org_video_id'] = $_youtube_id;
		$req['url_source'] = $_youTube_base . $_youtube_id;
		$req['use_embedded'] = "1";
		$req['param_1']		=  $_youTube_base;
		$req['param_2']		=	$_youtube_id;
		$req['param_3']		=	$_youTube_get_URL;
				
		return $req;
	}
	
	private static function insert_video($req)
	{
		

		$_video_id =  DB::UUID();
		$_parent_id = 0;
		
		$_title = stripslashes($req['title']);
		
		if (empty($req['date_pub'])) $req['date_pub'] = date("Y-m-d G:i:s");
		
		
		$sql = array (
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$req['org_video_id'],
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$req['source_id'],
			"show_id"		=> 	$req['show_id'],	
			"title"			=> 	$_title,	
			"detail"		=>	stripslashes($req['detail']),	
			"url_source" 	=>	$req['url_source'],
			"url_link"		=> 	$req['url_link'],	
			"use_embedded"	=> 	$req['use_embedded'],
			"thumb" 		=>	$req['thumb'],
			"param_1"		=>  $req['param_1'],
			"param_2"		=>	$req['param_2'],
			"param_3"		=>	$req['param_3'],
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	$req['date_pub']
	
			);
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		//echo $nSQL;
		DB::query($nSQL , false);		
		
		return $_video_id;
		
		
	}
	
	
	
}

?>