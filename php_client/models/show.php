<?

class Show {
	

 	function __construct()
	{
	

		
	}

public static function detail($req)
	{
		
		global $_nav_shows; $_nav_shows = "_on"; 
		
		global  $header_block;
		$header_block .= '<link rel="stylesheet" href="/static/css/v3/show.css?1" type="text/css" media="screen"  charset="utf-8" />';
		


		
		global $req_login; $req_login = false;
		
		
		global $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		global $shows_data, $videos_data, $data_related, $o, $t, $q, $c, $ob, $id, $d , $vTotal, $type_data, $user_shows, $user_channels, $following;
		global $_v, $_tabs, $_options;
		
		$following = false;
		$_options = true;
		
		$shows_data = self::find(array("show_ids" => $req['id']));
		
		//SET TAB DEFAULTS - FIGURE OUT WHAT TAB OPTIONS TO SHOW (EPISODE/CLIPS or VIDEOS)
		(string)$tids = $shows_data[0]['video_type_ids'];
		if ((stristr($tids, "1"))  ){
			$_tabs = 1; //SETS THE TAB OPTIONS
			$t = isset($req['t']) ? $req['t'] : "1";
			$_v = isset($req['_v']) ? $req['_v'] : "episodes";
		} else {
			$_tabs = 2;
			$_v = isset($req['_v']) ? $req['_v'] : "videos";
		}
		
		
				
		if ($_v == "clips") $t = "2";
		if ($t == '2') $t = "0,2"; //INCLUDE UNKNOWN IN CLIPS
		
			
			
		  //SET DEFAULTS
			$c = 30;
			$o = isset($req['o']) ? $req['o'] : 0;
			$s = isset($req['s']) ? $req['s'] : '';
			$ob = isset($req['ob']) ? $req['ob'] : 'v.date_pub-DESC';
			
			// cc added this, order wasnt working for the shows.
			$req['order'] = $ob;
			
			$_ob = str_replace("-", " " , $ob);
			$id = $req['id'];
			$q =  $req['q'];
			$vid_opts = $req;
			 
			//print_r($vid_opts); die();
		
			if (!empty($q)) { $req['filter'] = $q; $t= "0,1,2"; }
			if (!empty($t)) $req['video_type_id'] = $t ;
		
		
				
			$defaults = array("order" => $ob , "limit" => $c, "offset" => $o, "show_id" => $req['id'], "nosegments" => true );
			$options = array_merge($defaults, $req);
			
			//print_r( $options );
		
			switch ($_v) 
			{
			case "activity":
				$_options = false; 
				break;
			case "search":
				$_options = false;
				if (empty($q)) { break;}	
					
			default:	
			$videos_data = Video::find($options);
			$vTotal =  Video::get_total_videos( $id, $t );	
			$d = $o+$c; 
			if (($o+$c) > $vTotal) $d = $vTotal;   
			

				
			}	


				$user_shows = self::get_user_shows($id);
				for ($i=0; $i < count($user_shows); $i++) { 
					if ($user_shows[$i]['user_id'] == User::$user_id) $following = true;
				}
				
				//$user_channels = User::get_user_channels(array("user_id" => User::$user_id, "data" => 1));
			
			$data_related = self::shows_related($id);	
					
		$_show_title = htmlspecialchars(stripslashes($shows_data[0]['title']));			
		$sf_title = "snackfeed - " . $_show_title ;
		$sf_meta_title = $_show_title ;	
		$sf_meta_desc = $_show_title  . 
			" - " .htmlspecialchars(stripslashes($shows_data[0]['detail']));	
			
		
		$header_block .= '<link rel="alternate" type="application/rss+xml" title="' . $_show_title . '  video feed [RSS]" href="http://snackfeed.com/shows/rss/' . $id  . '">';			
			
				

				
	}

	private static function show_activity($show_id)
	{
		$sql = "SELECT 
			          up.action_id,
			          up.detail,
			          v.title, v.thumb, v.detail,
								up.user_nickname as subject_title,
			          up.detail,
			          u.thumb as user_thumb
					FROM user_updates up
			  		JOIN  videos v ON v.video_id = up.content_id
			 		JOIN users u ON up.user_id = u.user_id
					WHERE show_id = 'c4478f8c-abab-102b-a744-00304897c9c6'
						AND up.action_id != 0";
		
		
		
	}

	public static function shows_related($show_id)
	{
		
		$sql = "
			SELECT s.show_id, s.title, s.thumb,
			IF((us.show_id IS NULL ), 0, (RAND() * 10 * count(us.show_id) )) AS rank ,
			count(us.show_id) rank2
			FROM shows s
			LEFT OUTER JOIN user_shows us ON s.show_id = us.show_id
			  AND user_id in (SELECT user_id FROM user_shows
							WHERE show_id = '($show_id}')
			AND s.status = 1
			AND s.show_id != '($show_id}'
			GROUP BY s.show_id
			ORDER BY rank DESC, rank2 DESC
			LIMIT 10;";
		return DB::query($sql);	   
		
	}


	public static function _default($req)
	{
		
		global $_nav_shows; $_nav_shows = "_on";
		
		global $req_login; $req_login = false;
		global $data_similar, $data_picks;
		
		$_user_id = User::$user_id;
		//this query get shows that are not in your favorites but in the favs of people related to you -- orders randomy --also puts in popular shows to fill out list so there is always at least 8 results
		$sql = " SELECT DISTINCT s.show_id, s.thumb, s.title, 
			IF((su.show_id IS NULL ), 0, (RAND() * 100)) AS rank , count(su2.user_id) as rank2
			FROM shows s
			LEFT OUTER JOIN user_shows su ON s.show_id = su.show_id AND su.user_id
			  in (SELECT DISTINCT u.user_id FROM users u
			 JOIN user_followers f2 ON f2.user_id = u.user_id AND f2.follower_id = '{$_user_id}'
			 JOIN user_followers f ON f.follower_id = u.user_id AND f.user_id = '{$_user_id}'
			)
			
			   LEFT OUTER JOIN user_shows su2 ON su2.show_id = s.show_id WHERE 1 AND s.status = 1 AND s.show_id NOT IN (SELECT su2.show_id FROM user_shows su2 WHERE su2.user_id = '{$_user_id}' )
			
			   GROUP BY s.show_id ORDER BY rank DESC, rank2 DESC LIMIT 10;";
		
		//echo $sql; die();
		
		$data_similar = DB::query($sql);
		
		
		$sql = "SELECT DISTINCT
				s.show_id, s.title, s.thumb,
				RAND() * (IF((st.show_id IS NULL ), 2,  100)) AS rank 
				FROM shows s
		     	 LEFT OUTER JOIN show_tags st ON s.show_id = st.show_id AND st.tag_id IN ('02bc123e-a7b9-102b-998b-00304897c9c6', 'a6c5656a-3d15-102b-9a93-001c23b974f2')

		WHERE 1
		AND s.status = 1
		AND s.show_id NOT IN (SELECT su2.show_id FROM user_shows su2 WHERE su2.user_id = '{$_user_id}' )

		ORDER BY rank DESC
		LIMIT 10";
		
		
		$data_picks = DB::query($sql);
		
	}
	
	public static function rss($req)
	{
		global $req_login; $req_login = false;
		
		$shows_data = self::find(array("show_ids" => $req['id']));
		
		include LIB."/rss_helper.php";
		
		$sql = " SELECT f.title, f.detail, f.thumb, f.video_id, f.date_added as date_formatted, 
				s.title as show_title
				 FROM feed_publics f
					LEFT OUTER JOIN shows s ON f.show_id = s.show_id
				 WHERE f.status = 1	
				 ORDER BY ts desc	
				 LIMIT 50 ";

			$defaults = array("order" => "v.date_pub-DESC" , "limit" => "200", "offset" => "0", "show_id" => $req['id'], "nosegments" => true );
			$options = array_merge($defaults, $req);

			$data = Video::find($options);				 
				 
		
		
		$rss_meta = array();
		$rss_meta['title'] = stripslashes($shows_data[0]['title']) . " video feed";
		$rss_meta['desc'] = "a taste of the videos on " . 
			stripslashes($shows_data[0]['title']) . " - " . stripslashes($shows_data[0]['detail']);
		$rss_meta['url'] = "http://snackfeed.com/shows/rss/";
		
		RssHelper::print_rss($rss_meta, $data);
	}		
	

	public static function get_user_shows($_show_id)
	{
		
			$sql = " SELECT u.user_id, u.email, u.nickname, u.name_first, u.name_last, u.thumb
		 	FROM users u INNER JOIN user_shows us ON u.user_id = us.user_id 
			WHERE us.show_id = '{$_show_id}' 
			ORDER BY u.email
				";

			//echo $sql; die();

			return DB::query($sql);
		
		
	}

	public static function special($req)
	{
		
		global $data, $news_feed;
		
		$feedURL = "http://sports.yahoo.com/olympics/rss.xml";
		$news_feed = simplexml_load_file($feedURL);

		$_user_id = User::$user_id;
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")) );
		
		$sql = "SELECT s.show_id, s.title, s.thumb,
					count(v.video_id) as new_content,
					SUM(IF(v.video_type_id = 1, 1, 0)) as new_episodes,
					SUM(IF(v.video_type_id = 2 or v.video_type_id = 0, 1, 0)) as new_clips,
					SUM(IF(v.video_type_id = 3, 1, 0)) new_movies,
					max(v.date_added) as latest_date,
					if ( (DATEDIFF(max(v.date_added), now()) = 0), DATE_FORMAT(max(v.date_added), '%l:%i %p'),
					DATE_FORMAT(max(v.date_added), '%b %e') ) as date_formatted,
					GROUP_CONCAT(DISTINCT v.title ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_titles,
					GROUP_CONCAT(DISTINCT v.detail ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_details,
					GROUP_CONCAT(DISTINCT v.thumb ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_thumbs,
					GROUP_CONCAT(DISTINCT v.video_id ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_ids,
					GROUP_CONCAT(DISTINCT v.date_added ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_dates
					FROM shows s LEFT OUTER JOIN videos v ON s.show_id=v.show_id 
					WHERE v.date_added > '{$_data}'
					AND v.parent_id = '0'
					

					AND s.show_id in (SELECT st.show_id FROM show_tags st 		
						WHERE st.tag_id = '4b1c2060-b53c-102b-aa95-00304897c9c6')
					GROUP BY s.show_id
					ORDER BY latest_date DESC ";

		$q = DB::query($sql);
		

			
			
			//REFORMAT ARRAY FOR GROUP CONCAT
			for ($i=0; $i <  count($q) ; $i++) { 
			
					
					$idArray = explode('||', $q[$i]['new_ids']);
					$titleArray = explode('||', $q[$i]['new_titles']);
					$thumbArray = explode('||', $q[$i]['new_thumbs']);
					$detailArray = explode('||', $q[$i]['new_details']);
					$dateArray = explode('||', $q[$i]['new_dates']);
					
					unset($q[$i]['new_ids']); 
					unset($q[$i]['new_titles']); 
					unset($q[$i]['new_thumbs']); 
					unset($q[$i]['new_details']); 
					unset($q[$i]['new_dates']); 
					
					
					$_max = (count($detailArray) > 3 ) ? 3 : count($detailArray);
					
					$itemArray = array();
					
					
					for ($j=0; $j < $_max; $j++) { 
					
						$detailArray[$j] =  strip_tags ($detailArray[$j]);
					
						$itemArray[$j]['video_id'] =  $idArray[$j];
						$itemArray[$j]['title'] =  stripslashes($titleArray[$j]);
						$itemArray[$j]['detail'] =  (strlen($detailArray[$j]) > 200) ? stripslashes(substr($detailArray[$j], 0 , 200)) . "..." : stripslashes($detailArray[$j]) ;
						$itemArray[$j]['thumb'] =  (stripos($thumbArray[$j], ".jpg") > 0 ) ? $thumbArray[$j] :  BASE_URL . "/images/default.jpg" ;
						$itemArray[$j]['date'] = $dateArray[$j];
					
					}
			
					
					$q[$i]['items'] = $itemArray;
			}
					
		$data = $q;
		
	}

	public static function special_shows($req)
	{
		
		global $req_login; $req_login = false;
		
		global $data_similar, $data_picks;
		
		$_user_id = User::$user_id;
		
		
		
			$sql = "SELECT count(su.user_id) as user_count,
			s.show_id, s.title, s.detail, s.thumb,
			(IF((su2.show_id IS NULL ), 0,  1)) AS following 
			FROM shows s
	     	 JOIN show_tags st ON s.show_id = st.show_id AND st.tag_id = '4b1c2060-b53c-102b-aa95-00304897c9c6'
	    	  LEFT OUTER JOIN user_shows su ON su.show_id = s.show_id
			  LEFT OUTER JOIN user_shows su2 ON s.show_id = su2.show_id AND su2.user_id = '{$_user_id}'
			GROUP BY s.show_id, su2.show_id
			ORDER BY user_count DESC
			LIMIT 200 ";

		$data_similar = DB::query($sql);
		
	}



	
	public static function ls($req)
	{
		
		global $req_login; $req_login = false;
		
		global $_nav_shows; $_nav_shows = "_on"; 
		
		global $shows_data, $o, $q, $c, $t, $vTotal, $tag_data;
		
			$c = 30;
			$o = isset($req['o']) ? $req['o'] : 0;
			$s = isset($req['s']) ? $req['s'] : '';
			$t = isset($req['t']) ? $req['t'] : '';
			$ob = isset($req['ob']) ? $req['ob'] : 'date_pub-DESC';
			
			$_ob = str_replace("-", " " , $ob);
			
			$q =  $req['q'];
		
		if (!empty($q)) $req['filter'] = $q;	
		if (!empty($t)) $req['tag_ids'] = $t;	
		$defaults = array("order" => "title-asc", "limit" => $c, "offset" => $o);
		$options = array_merge($defaults, $req);
		
		$shows_data = self::find($options);
		$vTotal = self::get_total_shows($options);
		if ($vTotal < $c ) $c = $vTotal;
		
		
		$sql = "
		SELECT t.tag_id, t.name, count(st.show_id) as vCount
			FROM tags t JOIN show_tags st ON t.tag_id = st.tag_id
			WHERE t.parent_id = '0'
			GROUP BY t.tag_id
				ORDER BY t.name;" ;
			
		$tag_data = DB::query($sql);
		
				
	}
	
	
	public static function autocomplete($req)
	{
		global $shows_data, $o, $q, $c, $t, $ob, $vTotal, $tag_data;
		
			$c = 5;
			$o = isset($req['o']) ? $req['o'] : 0;
			$s = isset($req['s']) ? $req['s'] : '';
			$t = isset($req['t']) ? $req['t'] : '';
			$ob = isset($req['ob']) ? $req['ob'] : 'rank-DESC';
			
			$_ob = str_replace("-", " " , $ob);
			
			$q =  $req['q'];
		
		if (!empty($q)) $req['filter'] = $q;	
		if (!empty($t)) $req['tag_ids'] = $t;	
		$defaults = array("order" => "popularity-desc", "limit" => $c, "offset" => $o);
		$options = array_merge($defaults, $req);
		
		$shows_data = self::find($options);
		$html_data = "<ul>";
		
		for ( $i=0 ; $i < count( $shows_data ) ; $i++) { 
				
				$html_data .= "<li id='".$shows_data[$i]['show_id']."'>";
				
				//$html_data .= "<img style='margin-right: 2px; float: left; width:22px;' src='".$shows_data[$i]['thumb']."'></img>";
				$html_data .= substr($shows_data[$i]['title'],0,40);
				//$html_data .= "<span style='color:#aaaaaa;'>".substr($shows_data[$i]['detail'], 0 , 100)."</span>";
				$html_data .= "</li>";
			
		}
		
		$html_data .= "</ul>";
		echo $html_data;
		die();
		
	}
	
	

	
	public static function get_show_list($req) {
		$rows = self::find($req);
		$data = array("total_results" => self::get_total_shows($req),"records" => count($rows), "shows" => $rows);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else if (array_key_exists('data', $req))	{
			return $data;
		} else {
			render_data_as_xml($data);
		}
		
	}
	
	
	
	/*
		CONTROLLER ACTION
		
		return meta data and videos for a show
		
		@param array $request
			show_id -> required
	*/
	public static function get_details_and_videos_for($req) {
		if (!array_key_exists('show_id', $req)) {
			throw new Exception("MISSING REQUIRED KEY show_id", 1); // abstract this
		} else {
			$opts = array("show_ids" => $req["show_id"]);
			$vid_opts = $req;
			
			//print_r($vid_opts); die();
			
			$meta = self::find($opts);
			$videos = Video::find($vid_opts);
			
			$total_results =  Video::get_total_videos( $req["show_id"]);
			
			$data = array("total_results" => $total_results, "meta" => $meta[0], "videos" => $videos);

			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
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
		

		
		$defaults = array("order" => "title-asc", "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
		
		$options['order'] = str_replace("-", " ", $options['order']);
		
		
		foreach ($options as $key => $value) {
			$options[$key] = DB::escape($value);
		}	
		$conditions = "shows.status = 1";
		if (array_key_exists("show_ids", $options)) {
			
			$conditions .= " AND shows.show_id IN (".quote_csv($options['show_ids']).")";
		
		}
		
		if (array_key_exists("filter", $options)) {
			
			$conditions .= " AND shows.title LIKE '%{$options['filter']}%' ";
		
		}
	
		if (array_key_exists("user_id", $options)) {
			
			$conditions .= " AND shows.show_id IN ( SELECT user_shows.show_id FROM user_shows WHERE user_shows.user_id = '{$options['user_id']}' )";
		
		}
		
		if (array_key_exists("ex_user_id", $options)) {
			
			$conditions .= " AND shows.show_id NOT IN ( SELECT user_shows.show_id FROM user_shows WHERE user_shows.user_id = '{$options['ex_user_id']}' )";
		
		}
		
		if (array_key_exists("fav_user_id", $options)) {
			
			$columns .= " , (SELECT count(show_id) FROM user_shows 
					WHERE  shows.show_id = user_shows.show_id
					AND user_shows.user_id = '{$options['fav_user_id']}' ) as favorite ";
		
		}
		
		if (array_key_exists("tag_ids", $options)) {
			
			$options['tag_ids'] =  str_replace(",","','", $options['tag_ids']);
			
			$conditions .= " AND shows.show_id  IN ( SELECT show_tags.show_id FROM show_tags WHERE show_tags.tag_id IN ('{$options['tag_ids']}') )";
		
		}		
		
		
		
		$sql = "
			SELECT shows.show_id, shows.title, shows.detail, 
			shows.thumb, video_type_ids
			
			{$columns}
			FROM shows
			WHERE {$conditions}
			GROUP BY shows.show_id
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
		";
		

		
		return DB::query($sql);
	}
	
	public static function get_total_shows($options) {
	
		$conditions = "1";
	
		if (array_key_exists("filter", $options)) {
			
			$conditions .= " AND shows.title LIKE '%{$options['filter']}%' ";
		
		}
	
		if (array_key_exists("user_id", $options)) {
			$conditions .= " AND shows.show_id IN ( SELECT user_shows.show_id FROM user_shows WHERE user_shows.user_id = '" . $options['user_id']  . "' )";
		}
		
		if (array_key_exists("ex_user_id", $options)) {
			$conditions .= " AND shows.show_id NOT IN ( SELECT user_shows.show_id FROM user_shows WHERE user_shows.user_id = '{$options['ex_user_id']}' )";
		}
		
		if (array_key_exists("tag_ids", $options)) {

			$options['tag_ids'] =  str_replace(",","','", $options['tag_ids']);
			$conditions .= " AND shows.show_id  IN ( SELECT show_tags.show_id FROM show_tags WHERE show_tags.tag_id IN ('{$options['tag_ids']}') )";

		}		
		
		
		
		$sql = "
			SELECT count(show_id) as rCount
			FROM shows
			WHERE {$conditions}
		";
		$q = DB::query($sql);
		return $q[0]["rCount"];
	}
	
	
	
	/*
		CONTROLLER ACTION
		
		return a list of shows
	*/
	public static function get_tags($req) {
	
		$conditions = "";
		
		if (array_key_exists("show_in_nav", $req)) {
			$conditions .= "AND f.show_in_nav = 1";
		}
		
		$sql = " SELECT f.tag_id, f.name
		 	FROM tags f
			WHERE tag_type_id = 1
			{$conditions}
			ORDER BY order_by, name ;";

		$flags = DB::query($sql);


		$sql = "SELECT
				f.tag_id,
				f.name AS name,  p.name AS parent_name,
				COUNT( p.tag_id ) AS depth,
				if (COUNT( p.tag_id ) = 0, f.name, p.name) as order_by,
				if (COUNT( p.tag_id ) = 0, f.order_by, p.order_by) as top_order_by,
				f.order_by
				FROM
				tags AS f LEFT OUTER JOIN
				tags AS p ON f.parent_id = p.tag_id
				WHERE f.tag_type_id = 2 
				{$conditions}
				group by f.tag_id
				ORDER BY top_order_by, depth, f.order_by ";

		$genres = DB::query($sql);
	
		$data = array("flags" => $flags, "genres" => $genres);
	
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();	
		} else {
			render_data_as_xml($data);
		}
		
	}
	

	public static function get_packages($options) {
	
	
		$defaults = array("order" => "title-asc", "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
	
		$sql = " SELECT p.package_id, p.name, p.detail, p.thumb, 
					
					count(shows.show_id) as shows_count,
					GROUP_CONCAT(shows.title ORDER BY popularity DESC ) as shows_list 
				FROM packages p 
					LEFT OUTER JOIN package_shows ON package_shows.package_id = p.package_id
					LEFT OUTER JOIN shows ON package_shows.show_id = shows.show_id
				GROUP BY p.package_id, p.name, p.detail
				ORDER BY p.order_by 
				LIMIT {$options['offset']}, {$options['limit']} ;
		";

		return DB::query($sql);

		
	}	
	
	public static function get_package_shows($options) {
	
	
		$defaults = array("order" => "vCount-desc", "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
	
		$sql = " SELECT s.show_id, s.title, s.detail, s.thumb,  count(su.user_id) as vCount
			FROM shows s 
				JOIN package_shows ps ON s.show_id = ps.show_id AND ps.package_id = '{$options['package_id']}'
				LEFT OUTER JOIN user_shows su ON s.show_id = su.show_id
			GROUP BY s.show_id
			ORDER BY vCount DESC
			LIMIT {$options['offset']}, {$options['limit']} ;
		";

		return DB::query($sql);

		
	}


	public static function get_shows_blog($req) {
	
	
		$rows = Feed::find_blog_data($req);

		$data = array("total_results" => count($rows), "shows" => $rows);
	
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
	}


	public static function find_show_data($req) {
	
		if (!array_key_exists('show_id', $req)   ) {
			throw new Exception("MISSING REQUIRED KEY(S) show_id, user_id, date", 1); // abstract this
		} else {
		
	
		$opts = array("show_ids" => $req["show_id"]);
		$meta = self::find($opts);
		$videos = Video::find($req);
	
		return array("total_results" => count($videos), "meta" => $meta[0],  "videos" => $videos);
	
		
		}
	}

	public static function get_single_show_blog($req) {
	
		if (!array_key_exists('show_id', $req)   ) {
			throw new Exception("MISSING REQUIRED KEY(S) show_id", 1); // abstract this
		} else {
		
	

		$data = self::find_show_data($req);
	
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
		}
	}
	
	
	
	
	
	
	
	
	
}

?>
