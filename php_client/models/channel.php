<?

class Channel {
	
	public static function _default($req)
	{
		
		global $req_login; $req_login = false;
		
		global $channel_data, $fav_videos_data, $show_data, $user_data, $youtube_top_rated, $staff_data;


		require_once LIB.'/you_tube_helper.php';
		$youtube_top_rated = YouTubeHelper::get_top_rated_today();



	
		$sql = "SELECT count(su.user_id) as user_count,
		s.show_id, s.title, s.detail, s.thumb
		FROM shows s
     	 JOIN show_tags st ON s.show_id = st.show_id AND st.tag_id = '02bc123e-a7b9-102b-998b-00304897c9c6'
    	  LEFT OUTER JOIN user_shows su ON su.show_id = s.show_id
		GROUP BY s.show_id
		ORDER BY user_count DESC
		LIMIT 5 ";
		
		$staff_data = DB::query($sql);


		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-14,date("Y")) );
		$sql = "SELECT count(up.user_id) as user_count,
		u.user_id, u.nickname, u.thumb, u.location, u.bio
		FROM user_updates up
			JOIN users u ON up.user_id = u.user_id 
		WHERE up.date_added > '{$_date}'
		GROUP BY up.user_id
		ORDER BY user_count DESC
		LIMIT 5 ";
		
		$user_data = DB::query($sql);



		$sql = "SELECT count(su.user_id) as user_count,
		s.show_id, s.title, s.detail, s.thumb
		FROM user_shows su
			JOIN shows s ON su.show_id = s.show_id

		GROUP BY su.show_id
		ORDER BY user_count DESC
		LIMIT 5 ";
		
		$show_data = DB::query($sql);

		
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-14,date("Y")) );
		$sql = "SELECT count(cu.user_id) as user_count,
		c.channel_id, c.title, c.detail, c.thumb
		FROM channel_users cu
			JOIN channels c ON cu.channel_id = c.channel_id
		GROUP BY cu.channel_id
		ORDER BY user_count DESC
		LIMIT 5 ";
		
		$channel_data = DB::query($sql);
		
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-14,date("Y")) );
		$sql = "SELECT count(uv.video_id) as video_count,
		v.video_id, v.title, v.detail, v.thumb
		FROM user_videos uv 
			JOIN videos v ON uv.video_id = v.video_id AND v.date_added > '{$_date}'	
		GROUP BY uv.video_id
		ORDER BY video_count DESC
		LIMIT 5
			";
		
		$fav_videos_data = DB::query($sql);
		
		
	}


	public static function ls($req)
	{
		global $data;
		
		$data = self::find();
		
	}


	public static function detail($req)
	{
		global $data, $channel_users, $header_block;
		
		$options = array("user_id" => User::$user_id, "data" => 1, "channel_id" => $req['id'], "nosegments" => "1", "data" => "1"  );
		$data = self::get_details_and_videos_for($options);
		
		//echo print_r($data);
		//die();
		
		/// RSS Render /////
		if ( $req['format'] == "rss" ) {
			
			include LIB."/rss_helper.php";
			$rss_meta = array( "desc" => $data['meta']['title'].$data['meta']['detail']['detail'] );
			RssHelper::print_rss( $rss_meta, $data['videos'] );
			// should die;
			
		}
		
		$header_block = "<link rel='alternate' href='/channels/detail/{$req['id']}?format=rss' type='application/rss+xml'/>";
		
		$channel_users = self::get_channel_users(array("channel_id" => $req['id']));
		
	}

	public static function edit($req)
	{
		global $_channel_id, $data, $_call, $vMsg;
		
		$_channel_id = (empty($_REQUEST['id'])) ? '0' : $_REQUEST['id'];

		//create or update channel		
		if ($req['channel_update'] == '1')
		{
			
			
			$sql = array();
			$sql['channel_id'] 	= ($_channel_id != '0') ? $_channel_id : DB::UUID();	
			$sql['title']		=	$req['title'];
			$sql['subtitle']	=	$req['subtitle'];
			$sql['detail']	=	$req['detail'];
				
			if ($_channel_id == '0') 
			{
				
				$_channel_id = $sql['channel_id'];
				$sql['thumb'] =  "/static/images/channel_icons/default_thumb.jpg";
				$sql['thumb_lg'] = "/static/images/channel_icons/default_lg.jpg";
	
				$nSQL = "INSERT INTO channels SET " . DB::assoc_to_sql_str($sql);
	
				//add user to channel as admin
				$sql = " INSERT INTO channel_users SET
				user_id = '" . User::$user_id . "',
				channel_id = '{$sql['channel_id']}',
				role = '100',
				status = '1'
				";	
				
				DB::query($sql, false);
						
				$vMsg = 'channel created';

				
			} else {
				//UPDATE
				$vMsg = 'channel updated';
				$nSQL = "UPDATE channels SET " . DB::assoc_to_sql_str($sql) . " WHERE channel_id = '{$_channel_id}';";
			}
			
			DB::query($nSQL , false);
	
		}
		

		if ($_channel_id == '0' )
		{
			$_call = "create";
			//set defaults
			$data[0]['title'] = "new channel";
			$data[0]['detail'] = ""; 
			$data[0]['subtitle'] = "this channel rocks";
		} else {
			$_call = "update";
			$data = self::find(array("channel_ids"=> $_channel_id));
		}
		
	}

	public static function edit_images($req)
	{
		
		
		
		global $data, $channel_images_thumb, $channel_images_thumb_lg,  $vMsg ;
		
		
		$_channel_id =  $_REQUEST['id'];
		$data = self::find(array("channel_ids"=> $_channel_id));
		
		$channel_images_thumb = array();
		$channel_images_thumb_lg = array();
		
		$web_dir = "/static/images/channel_icons/";
		
		$icon_dir = APP_ROOT . "/webroot/{$web_dir}";
		$upload_root = "/var/www/sf-public/webroot";
		
				
			if ($handle = opendir($icon_dir)) {
			    while (false !== ($file = readdir($handle))) {
			        if (strpos($file, 'thumb.gif',1)||strpos($file, 'thumb.jpg',1) ) {
			            array_push($channel_images_thumb, $web_dir. $file);
			        }
			    
			        if (strpos($file, 'thumb_lg.gif',1)||strpos($file, 'thumb_lg.jpg',1) ) {
			            array_push($channel_images_thumb_lg, $web_dir. $file);
			        }
			        
		        }
			    closedir($handle);
			}		
				



		if ($req['channel_update'] == 1 )
		{
			
			
		//upload image
		$_POST['channel_thumb']=  empty($_FILES["file"]["name"]) ? $_POST['channel_thumb'] : image_upload_jpg( $upload_root, "/static/channels/", $_channel_id, "file" );
	
		$_POST['channel_thumb_lg']=  empty($_FILES["file_lg"]["name"]) ? $_POST['channel_thumb_lg'] : image_upload_jpg( $upload_root, "/static/channels/", $_channel_id . "_lg" , "file_lg" );
		
			
			$sql = "UPDATE channels SET 
			thumb = '{$_POST['channel_thumb']}',
			thumb_lg = '{$_POST['channel_thumb_lg']}'
			WHERE channel_id = '{$_channel_id}';";

			DB::query($sql , false);

			$vMsg = "your image has been updated";
		
		
		
		}
		
		
		
	}


	public static function edit_pro($req)
	{
		global $data;
		
		$_channel_id =  $_REQUEST['id'];
		$data = self::find(array("channel_ids"=> $_channel_id));
	}


	public static function unfollow($req)
	{
		

			$_user_id = User::$user_id;
			$_channel_id = $req['channel_id'];
			
			$sql = " DELETE FROM channel_users
			WHERE user_id = '{$_user_id}'
			AND channel_id = '{$_channel_id}'
			";	
			
			DB::query( $sql , false );
			
		
	}
	

	
	public static function follow($req)
	{
		

			$_user_id = User::$user_id;
			$_channel_id = $_REQUEST['id'];
			
			$sql = " INSERT INTO channel_users SET
			user_id = '{$_user_id}',
			channel_id = '{$_channel_id}',
			role = '1',
			status = '1'
			ON DUPLICATE KEY UPDATE status = status
			";	
			
			DB::query( $sql , false );
			
			Status::user_followed_channel( array( "channel_id" => $_channel_id ) );
			
			die();
		
	}
	
	
	public static function invite($req)
	{
		
		global $data, $channel_roles, $_channel_id, $vMsg;
		
		$_channel_id =  $_REQUEST['id'];
		$data = self::find(array("channel_ids"=> $_channel_id))	;
		
		$channel_roles = DB::query("SELECT * FROM lkp_channel_roles ORDER BY channel_role");
		

		if ($req['channel_invite'] == '1' )
		{
			
			//see if we can find their user id
			$_user_id = User::get_user_id(array("email" => $req['email'] , "data" => 1));
			
			
			if (!empty($_user_id))
			{
			
			$vMsg =  "We found the user and they have been added to channel";
			
			//send invite -- will do the change status later
				$sql = " INSERT INTO channel_users SET
				user_id = '{$_user_id}',
				channel_id = '{$_channel_id}',
				role = '{$req['channel_role']}',
				status = '1'
				ON DUPLICATE KEY UPDATE status = status
				";	
				
				DB::query($sql, false);
			} else {
				
				$vMsg = "That user (  {$req['email']}  ) is not registered in our system - invites to external users are not available yet";
				
			}
			
			
			
		}

		
		
	}
	
	
	


	
	public static function save_order_by($req)
	{

		//turn list into vars
		parse_str($_POST['data']);  
	
		echo $channel_id . ""; 
	
		for ($i = 0; $i < count($channelList); $i++) { 
			
			//echo $channelList[$i] . "<br/>"; 
			$sql = "UPDATE channel_videos SET order_by  = {$i} 
					WHERE channel_id = '{$channel_id}'
					AND video_id = '{$channelList[$i]}';";
					
				$sql = "
					INSERT INTO channel_videos SET  
					channel_id = '{$channel_id}',
					video_id = '{$channelList[$i]}',
					source = '1',
					status = 1,
					order_by = {$i}

					ON DUPLICATE KEY 
						UPDATE order_by  = {$i}, status = 1 
					;";		
					
					
			DB::query($sql, false);		  
			
			}
			 
	
		die();

		
	}
	
	public function remove_video($req)
	{
	
		$sql = " 
		 UPDATE channel_videos
			SET status = 0
			WHERE channel_id = '{$req['channel_id']}'
			AND video_id = '{$req['video_id']}' ;";
		$rows = DB::query($sql, false);
		
		echo "video delete";
		die();
	
		
	}
	
	
	
	public static function get_programs($req)
	{
		$sql = " 
		 SELECT p.*, s.title,  s.thumb
		 FROM programs p
			INNER JOIN shows s ON s.show_id = p.show_id
		 WHERE p.channel_id = '{$req['channel_id']}'
		 ORDER BY p.order_by DESC;";
		$rows = DB::query($sql);
		
		$data = array( "programs" => $rows);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
	}
	
	
	public static function edit_program($req)
	{
		
		$_program_id = (empty($_REQUEST['id'])) ? '0' : $_REQUEST['id'];
		$_show_id = $req['show_id'];
		$_channel_id = $req['channel_id'];
		
		
		$sql = array();
		$sql['channel_id'] = $_channel_id;
		$sql['show_id'] = $_show_id;
	

		
		

		if ($_program_id == '0') 
		{
			$sql['program_id'] =  DB::UUID();	

			
		    $sql['video_count'] = 0;
		    $sql['video_date_offset'] = 0 ;
		    $sql['video_filters'] = '';
		    $sql['video_grouping'] = 0;
		    $sql['video_fill_status'] = 1;
		    $sql['status'] = 1;
		    $sql['order_by'] = "-" . time(); 
			$nSQL = "INSERT INTO programs SET " . DB::assoc_to_sql_str($sql);
		
		} else {
			//UPDATE
			$sql['video_count'] = $req['video_count'];
		    $sql['video_date_offset'] = $req['video_date_offset'];
		    $sql['video_filters'] = $req['video_filters'];
		    $sql['video_grouping'] = $req['video_grouping'];
		    $sql['video_fill_status'] = $req['video_fill_status'];
		    $sql['status'] = $req['status'];
		    $sql['order_by'] = $req['order_by'];
			
			$nSQL = "UPDATE programs SET " . DB::assoc_to_sql_str($sql) . " WHERE program_id = '{$_program_id}';";
		}
		
		echo $nSQL; 
		DB::query($nSQL , false);
		echo "show add to end of channel list -- ";
		
		die();
		
		
	}
	
	
	public function get_show_videos($req)
	{
		
		$sql = " 
		 SELECT v.video_id, v.title, v.thumb, v.detail,
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub
			
		 FROM videos v
		
		 WHERE v.show_id = '{$req['show_id']}'
			AND video_id NOT IN 
				(SELECT v1.video_id FROM channel_videos v1 WHERE v1.channel_id = '{$req['channel_id']}' AND v1.status > 0  )
		 ORDER BY v.date_pub DESC
		 LIMIT 50;";
		$rows = DB::query($sql);
		
		
		$data = array( "videos" => $rows);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
		
		
	}
	
	
	
	public static function get_channel_list($req) {
		$rows = self::find($req);
		
		//echo count($rows);die();
		
		//insert channel videos as nested queries
		for ($i = 0 ; $i < count($rows) ; $i++)
		{
			$id =  $rows[$i]['channel_id'];
			$opts = array("channel_ids" => $id,  "limit" => 3 );
			$videos = self::find_videos_by_channel($opts);
			$video_data = array("videos" => $videos);
			array_push($rows[$i], $videos);	
		}

		$data = array("total_results" => self::get_total_channels(), "channel" => $rows);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
	
	
	}


	public static function show_channel_list($req) {
		
		global $channel;
		
		
		$channel = self::find($req);
		
		return $channel;
		
		//print_r($channel);
	
	}
	
	/*
		CONTROLLER ACTION
		
		return meta data and videos for a show
		
		@param array $request
			show_id -> required
	*/
	public static function get_details_and_videos_for($req) {
		if (!array_key_exists('channel_id', $req)) {
			throw new Exception("MISSING REQUIRED KEY channel", 1); // abstract this
		} else {
			$opts = array("channel_ids" => $req["channel_id"]);
			//$vid_opts = $req;
			
			$meta = self::find($opts);
			$vid_opts = array_merge($req, $opts);
			$videos = self::find_videos_by_channel($vid_opts);
			
			$total_results =  self::get_total_videos( $req["channel_id"]);
	
			$data = array("total_results" => $total_results ,"meta" => $meta[0], "videos" => $videos);
		
	
		
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else if (array_key_exists('data', $req)) {
				return $data;	
			} else {
				render_data_as_xml($data);
			}
		
		
		}	
	}

	
	/*
		return a list of shows
	
		@param array $options
			order
			limit
			offset
	*/
	public static function find($options = array()) {
		$defaults = array("order" => '', "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
		foreach ($options as $key => $value) {
			$options[$key] = DB::escape($value);
		}	
		
		$joins = "";
		$conditions = "1";
		$columns = "";
		if (array_key_exists("channel_ids", $options)) {
			$conditions .= " AND c.channel_id IN (".quote_csv($options['channel_ids']).")";
		}
		
		if (array_key_exists("owner_id", $options)) {
			$joins .= " INNER JOIN channel_users cu ON c.channel_id = cu.channel_id AND cu.user_id = '{$options['owner_id']}'";
			$columns = ", cu.role, cu.status";
		}
		
		if (array_key_exists("role_ids", $options)) {
			$conditions .= " AND cu.role IN ({$options['role_ids']})";
		}
		
		
		$sql = "
			SELECT c.channel_id, c.title, c.detail,  c.subtitle,
			IF(LOCATE('http',c.thumb)>0, c.thumb, concat('" . BASE_URL ."', c.thumb) ) as thumb,
			IF(LOCATE('http',c.thumb_lg)>0, c.thumb_lg, concat('" . BASE_URL ."', c.thumb_lg) ) as thumb_lg
				{$columns}
			FROM channels c {$joins}
			WHERE {$conditions}
			ORDER BY c.order_by
			LIMIT {$options['offset']}, {$options['limit']}
		";
		
		//echo $sql;die();
		
		return DB::query($sql);
	}
	
	
	public static function get_channel_users($options = array())
	{
		
			$defaults = array("order" => 'cu.role DESC, u.email', "limit" => 100, "offset" => 0);
			$options = array_merge($defaults, $options);
		
			
			$conditions = "";
		if (array_key_exists("role_ids", $options)) {
			$conditions .= " AND cu.role in ({$options['role_ids']}) ";
		}
			
			
			$sql = "
			SELECT u.user_id, u.email, u.nickname, u.name_first, u.name_last,
			cu.role, cu.status, lkp.channel_role_title
			FROM users u INNER JOIN channel_users cu ON u.user_id = cu.user_id
				JOIN lkp_channel_roles lkp ON cu.role = lkp.channel_role
			WHERE cu.channel_id = '{$options['channel_id']}'
				{$conditions}
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
		";
		
		//echo $sql;die();
		
		return DB::query($sql);
		
		
	}
	
	
	
	public static function find_videos_by_channel($options = array()) {
		
		
		
		$defaults = array("order" => '', "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
		foreach ($options as $key => $value) {
			$options[$key] = DB::escape($value);
		}	
		
		$conditions = "1";
		$joins = "";
		$columns = "";
		
		if (array_key_exists("channel_ids", $options)) {
			$conditions .= " AND c.channel_id = ".quote_csv($options['channel_ids'])."";
		}

		if (array_key_exists("user_id", $options)) {
			//$conditions .= " AND v.video_id not in (SELECT uv.video_id FROM user_videos uv WHERE uv.user_id = '{$options['user_id']}')";
			$joins = " LEFT OUTER JOIN user_videos uv ON uv.video_id = v.video_id AND uv.user_id = '{$options['user_id']}'";
			$columns = ", IF((uv.user_id IS NULL ), 0, 1) AS watched ";
		}
		
		$sql = "
			SELECT v.video_id, v.title, v.detail, v.url_source,
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
			IF(LOCATE('http',v.thumb)>0, v.thumb, concat('" . BASE_URL ."', v.thumb) ) as thumb,
			v.duration,
			sc.client_lib, IF((sc.client_lib IS NULL OR sc.client_lib = ''), 0, 1) AS use_client_lib,
			v.use_embedded,
			sc.proxy_url, IF((sc.proxy_url IS NULL OR sc.proxy_url = ''), 0, 1) AS use_proxy_url,
			sh.title AS show_title	
			{$columns}
			FROM videos v
				LEFT OUTER JOIN sources sc ON v.source_id = sc.source_id
				JOIN shows sh ON v.show_id = sh.show_id
				JOIN channel_videos c ON c.video_id = v.video_id AND c.status > 0
		
			{$joins}
			WHERE {$conditions}
			AND v.parent_id = 0
			ORDER BY c.order_by
			LIMIT {$options['offset']}, {$options['limit']}

		";
		

		return DB::query($sql);
	}	
	
	public static function get_total_channels() {
		
		$sql = "
			SELECT count(channel_id) as rCount
			FROM channels
		";
		$q = DB::query($sql);
		return $q[0]["rCount"];
	}	
	 
	public static function get_total_videos($id) {
		
		$sql = "
			SELECT count(channel_id) as rCount
			FROM channel_videos
			WHERE channel_id = '". $id . "'
		";
		$q = DB::query($sql);
		return $q[0]["rCount"];
	}	
	
	
}

?>
