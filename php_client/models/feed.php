<?php

class Feed {
	
	public static $actions = array( "_default" => 1, "shows" => 1 , "you"=>1 , "me"=>1, "friends" => 1, "messages" =>1 , "" =>1 , "/" =>1 , "all" =>1 );
	
	
	/*
		sections: 
		  user home
			user profile
			public timeline
	
	*/
	
	public static function _default( $req )
	{
		
		global $_nav_feed; $_nav_feed = "_on";
		
		$opts = array_merge( array("section" => "home" , "sub_section" => "") , $req );
		
		global $data, $section, $recent_status, $sub_section, $follow_stats, $user_id, $profile_view, $username, $user_thumb, $filter, $new_messages, $show_welcome;
		
		
		
		
		$section = $opts['section'];
		$sub_section = $opts['sub_section'];
		
		$user_id = isset( $req['uid'] ) ? $req['uid'] : User::$user_id;
		
		
		if ( User::$user_id && $section == "home" )
		$new_messages = User::get_number_new_messages();
		
		
		if ( isset( $req['feed_view'] ) ) {
			// set thumbnail preferences...
			Prefs::set("feed_view" , $req['feed_view'] );
		}
		
		if ( !Prefs::get("welcome_message" ) ) {
			$show_welcome = true;
			Prefs::set("welcome_message" , 1 );
		}
		
			
		$arr = User::find( array("user_ids" => $user_id ) );
		$username = $arr[0]['nickname'];
		$user_thumb =  $arr[0]['thumb'] ? $arr[0]['thumb'] : User::$user_default_icon;
		
		
		if ( $user_id != User::$user_id ) {
			$section = "profile";
		}
		
		$profile_view = ($section != "public_timeline");
		
		//$profile_view = false;
		
		
		$opts['user_id'] = $user_id;
		
		//$options = array( "user_id" => $user_id );
		
		
		
		if ( isset( $req['only'] ) ) {
		$opts['only_likes'] =  $req['only'] == "likes" ? true : false;
		$opts['only_messages'] =  $req['only'] == "messages" ? true : false;
		
		if ( $opts['only_messages'] ) {
			//$sub_section = "messages";
			$opts['only_people'] = true;
		}
		
		if ( $opts['only_likes'] ) {
			//$sub_section = "likes";
		}
		
		$filter = "only_".$req['only'];
		}
		
		
		
		if ( $section == "profile" || $sub_section == "my_activity" ) { 
			$opts['only_people']  = true;
			$opts['profile_view'] = true;
		}
		
		global $header_block;
		$header_block .= '<link rel="stylesheet" href="/static/css/v2/feed_view.css" type="text/css" media="screen"  charset="utf-8">';
		
		
		if ( $sub_section == "shows" ) {
			
			$options = array( 
				"user_id" => $user_id, 
				"data" => 1,
				/*"channel_id" => $req['id'],*/
				"nosegments" => "1",
				"data" => "1", 
				"date_range" => "month",
				"fav_user_id" => $user_id,
				"limit" => "1000", "offset" => "0" );
			
			
			$data = Feed::find_blog_data( $options );
		}
		else {
		
			$timeline_data = Feed::find_timeline_data2( $opts );
			$data = $timeline_data['videos'];
			//$new_messages = $timeline_data['new_messages'];
		}
		
		//print_r($timeline_data);
		//die();
		
		$follow_stats = Feed::get_stats( $opts );
		
		//$username = $follow_stats['username'];
		
		//$recent_status = Status::get_recent_status( User::$user_id );
		
	}
	
	
	public static function get_user_feed( $req ) {
			
			// used to get a feed of just one user's activities...
			
			// filter by the guys nickname.. ie the action in the url /feed/cc
			$arr = User::find( array("filter" => $req["action"] ) );
			
			//$username = $arr[0]['user_id'];
			//$user_thumb =  $arr[0]['thumb'] ? $arr[0]['thumb'] : User::$user_default_icon;
			
			$req["uid"] = $arr[0]['user_id'];
			
			if ( !$req['uid'] ) {
				header("Location: /feed");
			} else {
				self::_default( $req );
			}
			
	}
	
	
	public static function messages( $req ) {
		
		$req["only"] = "messages";
		$req["sub_section"] = "messages";
		
		self::_default( $req );
		
	}
	
	public static function you( $req ) {
		
		$req["sub_section"] = "my_activity";
		$req['uid'] = User::$user_id;
		self::_default( $req );
		
	}
	
	public static function me( $req ) {
		
		$req["sub_section"] = "my_activity";
		$req['uid'] = User::$user_id;
		self::_default( $req );
		
	}
	
	public static function all( $req ) {
		/*
		global $data, $section, $recent_status,$sub_section;
		$section = "public";
		$sub_section = "";
		
		$options = array( 
			"user_id" => User::$user_id );
		
		global $header_block;
		$header_block = "<link rel=\"stylesheet\" href=\"/static/css/v2/feed_view.css\" type=\"text/css\" media=\"screen\"  charset=\"utf-8\">";
		
		$options['get_public'] = true;
	 	$data = Feed::find_timeline_data2( $options );
		*/
		
		$req['section'] = "public_timeline";
		$req['sub_section'] = "";
		$req['get_public'] = true;
		
		self::_default( $req );
	
	}
	
	public static function shows ( $req ) {
		
		//global $data, $section, $recent_status, $sub_section;
		//$section = "";
		//$sub_section = "shows";
		
		//$options = array( 
		//	"user_id" => User::$user_id, 
		//	"data" => 1,
		//	"channel_id" => $req['id'],
		//	"nosegments" => "1",
		//	"data" => "1", 
		//	"date_range" => "month",
		//	"fav_user_id" => User::$user_id,
		//	"limit" => "1000", "offset" => "0" );
		
		//global $header_block;
		//$header_block = "<link rel=\"stylesheet\" href=\"/static/css/v2/feed_view.css\" type=\"text/css\" media=\"screen\"  charset=\"utf-8\">";
		
		//$data = Feed::find_blog_data($options);
		$req['section'] = "home";
		$req['sub_section'] = "shows";
		//$req['get_public'] = true;
		
		self::_default( $req );
		
		
	}
	
	
	public static function friends ( $req ) {
		
		/*
		global $data, $section, $recent_status, $sub_section;
		$section = "tl";
		$sub_section = "friends";
		
		$options = array( 
			"user_id" => User::$user_id );
		
		global $header_block;
		$header_block = "<link rel=\"stylesheet\" href=\"/static/css/v2/feed_view.css\" type=\"text/css\" media=\"screen\"  charset=\"utf-8\">";
		
		$options['only_people'] = true;
		$options['get_public'] = true;
	 	$data = Feed::find_timeline_data2( $options );
	
		*/
	
		$req['section'] = "home";
		$req['sub_section'] = "friends";
		$req['get_public'] = false;
		$req['only_people'] = true;
		
		self::_default( $req );
		
	}
	
	
	
	
	public static function find_timeline_data2( $req ) {
	
		//require_once LIB."/memhelper.php";
		// trying to make this a generic call for everything to use...
		
		//foreach ($req as $item)
		//{
		//	$mem_key .= $item;
		//}
		
		//$get_result = MemHelper::getMem()->get( $mem_key );
		//
		//if ( $get_result ) {
		//	return $get_result;
		//}
		
			
		// the 3 'sources' right now...
		$get_status = false;
		$get_channels = false;
		$get_videos = true;
		
		// whether to get clips or just episodes
		$hide_clips = true;
		
		// disregard user specific information, so get everthing thats going on...
		$get_public = $req['get_public'] ? $req['get_public'] : false;
		
		$profile_view = $req['profile_view'] ? $req['profile_view'] : false;
		
		
		// dont show the user things they have watched...
		$hide_watched = true;
		
		// only show status updates from friends
		$only_people = $req['only_people'] ? $req['only_people'] : false;
		
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-19,date("Y")) );
		
		//set user_id to 
		$_user_id = isset($req["user_id"]) ? $req["user_id"] : "84f8189e-465f-102b-9839-001c23b974f2";
					
		$default_thumb = "/static/user.png";
		
		$status_user_specific = "where 1 ";
		
		if ( !$get_public ) { 
			// if not a public timeline, get user specific stuff...
			
			$user_specific .= "and s.show_id in ( SELECT show_id from (SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}') as t )";
			
			if ( $only_people == true ) {
				 
				if ( $profile_view ) {
					
					// looking at a public timeline of a users feed, so dont show messages sent to/by them.
					$status_user_specific .= " and up.user_id = '{$_user_id}' and up.action_id < 4";
					
				} else {
					
					// friends view, dont show yourself... ?
					$status_user_specific .= " and up.user_id in (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}') and up.user_id != '{$_user_id}' and up.action_id < 4 ";
					
				
					
					
					
				} 
				
			} else {
				
				
				// the typical feed call... includes your stuff, and your followers,
				 // $status_user_specific .= "	AND (up.user_id in (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}') AND up.action_id < 4 AND up.action_id > 1 ) 
				 // 				 			
				 // 				 			or  (up.user_id = '{$_user_id}' and up.action_id = 5)";
				

					 $status_user_specific .= "	AND 
					( up.user_id in ( SELECT user_id FROM ( SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}') as x ) AND up.action_id < 4 AND up.action_id > 1 ) 

					 	or  (up.user_id = '{$_user_id}' and up.action_id = 5)";

				
				// or (up.user_id != '{$_user_id}' and up.action_id != 5)
					
			}
			
			if ( $req['only_likes'] ) {
				$status_user_specific .= " and up.action_id = 2";
			} 
			
			if ( $req['only_messages'] ) {
				
				$status_user_specific = " where (up.user_id = '{$_user_id}' and up.action_id = 5)";
			}
			
			
			
			
			$channel_user_specific = "WHERE c.date_added > '{$_date}1' \n and c.channel_id IN (SELECT cu.channel_id FROM channel_users cu WHERE cu.user_id = '{$_user_id}')";
			
		} else {
			
			$status_user_specific .= " and up.action_id < 4";
			$channel_user_specific = "WHERE c.date_added > '{$_date}'";
			// AND v.date_added > '2008-06-01'
		}
		
		
		
		
		//  subject_type  
		//  subject_id    
		//  subject_title 
		//  subject_thumb 
		//  subject_link	
		    
		//  object_type  
		//  object_id    
		//  object_title 
		//  object_thumb 
		//  object_link   
		//  
		//  location_type 	 
		//  location_id   	 
		//  location_title  
		//  location_thumb   
		//  location_link
		//  
		//  
		//  time_ago
		//  time		
		//  
		//  action_id
		//  action_word
		//  action_word2: "to his" , "at" , "from"
		
		
		//$t = microtime(true); //$t is a float
		//$ms = ltrim(number_format($t - floor($t), 2), '0.');
		//echo date('H:i:s:' . $ms, $t) . "<br>";
		
		
		$videos_sql = "SELECT 
		
		s.title as subject_title,
		s.show_id as subject_id,
		count( video_id) as new_content,
		'favorite_videos' as content_source,
		'0' as content_type_specific,
		
		SUM(IF( video_type_id = 1, 1, 0)) as new_episodes,
		SUM(IF( video_type_id = 2 or v.video_type_id = 0, 1, 0)) as new_clips,
		
		GROUP_CONCAT( DISTINCT v.title ORDER BY date_added DESC, v.video_id SEPARATOR '||'     ) as new_titles,
		GROUP_CONCAT( DISTINCT v.detail ORDER BY date_added DESC, v.video_id SEPARATOR '||'    ) as new_details,
		GROUP_CONCAT( DISTINCT v.thumb   ORDER BY date_added DESC, v.video_id SEPARATOR '||'   ) as new_thumbs,
		GROUP_CONCAT( DISTINCT v.video_id ORDER BY date_added DESC, v.video_id SEPARATOR '||'  ) as new_ids,
		GROUP_CONCAT( DISTINCT v.date_added ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_dates,
		'' as new_messages,
		
		v.date_added,
		
		'0' as action_id,
		'0' as action_icon,
		'0' as location_type,
		'0' as location_title,
		'0' as location_id
		
		FROM videos v join shows s on s.show_id = v.show_id
		
		
		
		WHERE v.parent_id = '0'
		AND v.date_added > '{$_date}'
		"
		
		.$user_specific.
		
		"
		group by v.show_id, video_type_id, FLOOR(UNIX_TIMESTAMP(v.date_added)/100)
		order by date_added desc
		
		LIMIT 0, 20
		";
		
		
		
		
		$status_sql = "SELECT 
		
		
		up.user_nickname as subject_title,
		up.user_id as subject_id,
		count( up.content_id ) as new_content,
		'status_updates' as content_source,
		up.content_type as content_type_specific,
    
		'0' as new_episodes,
		'0' as new_clips,
		
		
		GROUP_CONCAT( DISTINCT up.content_title ORDER BY up.date_added DESC SEPARATOR '||'  ) as new_titles,
		GROUP_CONCAT( DISTINCT up.content_detail ORDER BY up.date_added DESC SEPARATOR '||'    ) as new_details,
		GROUP_CONCAT( DISTINCT up.content_thumb ORDER BY up.date_added DESC SEPARATOR '||'   ) as new_thumbs,
		GROUP_CONCAT( DISTINCT up.content_id ORDER BY up.date_added DESC SEPARATOR '||'  ) as new_ids,
		GROUP_CONCAT( DISTINCT up.date_added ORDER BY up.date_added DESC SEPARATOR '||') as new_dates,
		GROUP_CONCAT( DISTINCT up.detail ORDER BY up.date_added DESC SEPARATOR '||'    ) as new_messages,
		
		min(up.date_added) as date_added,
		
		up.action_id,
		up.action_icon,
		up.location_type,
		up.location_title,
		up.location_id
		
		FROM user_updates up 
		".$status_user_specific."
		group by up.user_id, up.action_id, up.content_type, up.location_id, FLOOR(UNIX_TIMESTAMP(up.date_added)/1000)
		ORDER BY up.date_added DESC
		LIMIT 50";
		
		
		
		
/*		
		$channels_sql = "SELECT 
		
		ch.title as subject_title,
		ch.channel_id as subject_id,
		count( v.video_id) as new_content,
		'channel_videos' as content_source,
		'0' as content_type_specific,
		
		SUM(IF( video_type_id = 1, 1, 0)) as new_episodes,
		SUM(IF( video_type_id = 2 or v.video_type_id = 0, 1, 0)) as new_clips,
		
		GROUP_CONCAT( DISTINCT v.title ORDER BY c.date_added DESC, v.video_id SEPARATOR '||'     ) as new_titles,
		GROUP_CONCAT( DISTINCT v.detail ORDER BY c.date_added DESC, v.video_id SEPARATOR '||'    ) as new_details,
		GROUP_CONCAT( DISTINCT v.thumb   ORDER BY c.date_added DESC, v.video_id SEPARATOR '||'   ) as new_thumbs,
		GROUP_CONCAT( DISTINCT v.video_id ORDER BY c.date_added DESC, v.video_id SEPARATOR '||'  ) as new_ids,
		GROUP_CONCAT( DISTINCT v.date_added ORDER BY c.date_added DESC, v.video_id SEPARATOR '||') as new_dates,
		'' as new_messages,
		
		v.date_added,
		
		'0' as action_id,
		'0' as action_icon,
		'0' as location_type,
		'0' as location_title,
		'0' as location_id
		
		FROM (channel_videos c )
		LEFT JOIN videos v ON v.video_id = c.video_id 
		LEFT JOIN channels ch ON c.channel_id = ch.channel_id
		
		".$channel_user_specific."
		
		group by ch.channel_id, v.video_type_id, FLOOR(UNIX_TIMESTAMP(c.date_added)/10000)
		ORDER BY c.date_added DESC
		
		LIMIT 0,50";
		
		*/
		
		
		if ( $only_people ) {
			
			$sql = "(". $status_sql .")"
						."\n order by date_added desc";
			
		} else {
			
			//$sql = "(".$videos_sql.")" 
			//			."\n UNION \n"
			//			."(". $status_sql .")"
			//			."\n UNION \n"
			//			."(".$channels_sql.")"
			//			."\n order by date_added desc \n limit 40";
						
			$sql = "(".$videos_sql.")" 
						."\n UNION \n"
						."(". $status_sql .")"
						."\n order by date_added desc \n limit 40";
				
		}
		
	 // echo "<pre>";
			 // echo $sql;
			 // echo "</pre>";
			 // die();			
		//$sql = "(".$channels_sql.")";
			
			
		$q = DB::query( $sql );
		//echo "<pre>";
		//print_r($q);
		//echo "</pre>";
		//die();
		
		$actions = array( "watched" , "added" , "liked" , "followed" , "were recommended" , "were sent");
		
		$totalMessages = 0;
		
		for ($i=0; $i < count($q) ; $i++) { 
		
				
				$idArray = explode('||', $q[$i]['new_ids']);
				$titleArray = explode('||', $q[$i]['new_titles']);
				$thumbArray = explode('||', $q[$i]['new_thumbs']);
				$detailArray = explode('||', $q[$i]['new_details']);
				$dateArray = explode('||', $q[$i]['new_dates']);
				
				$messageArray = explode('||', $q[$i]['new_messages']);
				
				
				$_max_items_to_show = $q[$i]['content_source']  == "status_updates" ? 3 : 2;
				//$_max_items_to_show = $q[$i]['action_id']  == "1" ? 1 : 3;
				
				
				$_max = min( $_max_items_to_show , count( $detailArray ) );
				
				if ( count( $detailArray ) > $_max_items_to_show ) {
					$q[$i]['extra_children'] = count( $detailArray ) - $_max_items_to_show;
					
					
					if ( $q[$i]['content_source']  == "status_updates" ) {
						$q[$i]['extra_children_link'] = "/users/profile/".$q[$i]['subject_id'];
						
					} else if ( $q[$i]['content_source']  == "channel_videos" ) {
						
						$q[$i]['extra_children_link'] = "/channels/detail/".$q[$i]['subject_id'];
					} else {
						$q[$i]['extra_children_link'] = "/shows/detail/".$q[$i]['subject_id'];
					}
					
				}
				
				
				// episode , clip
				if ( $q[$i]['content_source']  == "status_updates" ) {
					
					$q[$i]['content_type'] = "status";//$actions[ $q[$i]['action_id'] ];
					$q[$i]['action_word'] = $actions[ (int) $q[$i]['action_id'] ];
					
				} else {
					$q[$i]['content_type'] = $q[$i]['new_clips'] > 0 ? "clip" : "episode";
				}
				
				$itemArray = array();
				
				for ($j=0; $j < $_max; $j++) { 
					
					
					if ( $q[$i]['action_id'] == "5" ) {
						//$date_ago = time_ago_verbose( $dateArray[$j] );
						
						$secinday = 24 * 60 * 60;
						
						$epoch = strtotime( $dateArray[$j]  );
						$secsago  = time() - $epoch;
						
						if ( $secsago < $secinday )
						$totalMessages += count( $messageArray );
						
					}
					
					$detailArray[$j] =  strip_tags ($detailArray[$j]);
					$itemArray[$j]['video_id'] =  $idArray[$j];
					$itemArray[$j]['title'] =  stripslashes($titleArray[$j]);
					$itemArray[$j]['detail'] =  (strlen($detailArray[$j]) > 200) ? stripslashes(substr($detailArray[$j], 0 , 200)) . "..." : stripslashes($detailArray[$j]) ;
					$itemArray[$j]['thumb'] =  (stripos($thumbArray[$j], ".jpg") > 0 ) ? $thumbArray[$j] :  BASE_URL . "/images/default.jpg" ;
					$itemArray[$j]['date'] = $dateArray[$j];
					$itemArray[$j]['message'] = $messageArray[$j];
				}
				
				$q[$i]['children'] = $itemArray;
				
				
				
		}
		
		//echo $totalMessages;
		
		
		// write to memcached...
		//MemHelper::getMem()->set( $mem_key , $q, false, 15 );
		//echo "<hr>";
		$t = microtime(true); //$t is a float		
		$ms = ltrim(number_format($t - floor($t), 2), '0.');
		//echo date('H:i:s:' . $ms, $t) . "<br>";
		
		//die();
		
		$data_to_return = array();
		
		$data_to_return['videos'] = $q;
		$data_to_return['new_messages'] = $totalMessages;
		
		return $data_to_return;
			
		

		
	}
	
	
	
	// memcache this beast...
	public static function  find_timeline_data($req) {
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
		
		//$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")) );
		
			//set user_id to 
			$_user_id = isset($req["user_id"]) ? $req["user_id"] : "84f8189e-465f-102b-9839-001c23b974f2";
						
			// user favs
			
			$sql2 = " SELECT s.title, s.show_id, s.thumb, v.title as v_title, v.video_id,
						DATE_FORMAT( v.date_added , '%b %e') as date_formatted,
						DATE_FORMAT( v.date_pub , '%b %e') as date_pub,
						DATE_FORMAT( v.date_air , '%b %e') as date_air,
						v.video_type_id
						FROM shows s LEFT OUTER JOIN videos v ON s.show_id=v.show_id 
						WHERE v.date_added > '{$_date}'
						AND v.parent_id = '0'
						AND v.video_id not in (SELECT uv.video_id FROM user_videos uv WHERE uv.user_id = '{$_user_id}')
						AND s.show_id in (SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}')
						ORDER BY v.date_added DESC, v.date_pub DESC,  v.date_air DESC
						;
			";
			
			$default_thumb = "/static/user.png";
			
			$sql = "(".
			
						"SELECT 
						
						s.title, 
						v.date_added, 
						s.show_id, 
						v.video_id,
						v.thumb, 
						v.title as v_title, 
						'videos' as source,
						DATE_FORMAT( v.date_added , '%b %e') as date_formatted,
						DATE_FORMAT( v.date_pub , '%b %e') as date_pub
						
						FROM videos v LEFT JOIN shows s ON v.show_id=s.show_id 
						WHERE s.show_id in (SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}')
						ORDER BY date_added DESC
						LIMIT 50)
						
						UNION
						
						(
						SELECT 
						
						'status' as title, 
						date_added,
						user_id as show_id,
						content_id as video_id,
						'test thumb' as thumb,
						detail as v_title, 
						'status' as source,
						
						DATE_FORMAT( date_added , '%b %e') as date_formatted,
						DATE_FORMAT( date_added , '%b %e') as date_pub
						
						FROM user_updates
						ORDER BY date_added DESC
						LIMIT 50 )
						
						UNION
						
						(SELECT 
							
						
						ch.title as title, 
						c.date_added,
						c.channel_id as show_id,
						v.video_id as video_id,
						v.thumb as thumb,
						v.title as v_title, 
						'status' as source,
						
						DATE_FORMAT( c.date_added , '%b %e') as date_formatted,
						DATE_FORMAT( v.date_added , '%b %e') as date_pub
						
						FROM (channel_videos c )
						LEFT JOIN videos v ON v.video_id = c.video_id 
						LEFT JOIN channels ch ON c.channel_id = ch.channel_id
						WHERE c.channel_id IN 
						(SELECT cu.channel_id FROM channel_users cu WHERE cu.user_id = '{$_user_id}') 
						
						ORDER BY c.date_added DESC
						
						LIMIT 0,1000)
						
						ORDER BY date_added DESC;
			";
			
			//						v.title, c.channel_id, ch.title, c.date_added
			
			// problem with the channel query, you could have a lot of videos in one channel which may then
			// hit that 1000 limit, so as to not get the other videos? or does it order first.
			
			// also , we dont limit status' to your friends right now
			// or do anything with the public private situation.
			
			
			//echo $sql; die();
			
			$q = DB::query($sql);
			// echo "<pre>";
			// print_r($q);
			// echo "</pre>";
			// die();
			
			
			return $q;
			
			// for ($i=0; $i <  count($q) ; $i++) { 
			// 		echo "<br/>".$q[$i]['title']."  --  ".$q[$i]['v_title']."  -  ".$q[$i]['date_added'];
			// }
			// 
			
			
	}
	
	public static function get_stats( $req ) {
		
	 //require_once LIB."/memhelper.php";
	 //$mem_key = "feed/get_stats/".$req['user_id'];
	 //$get_result = MemHelper::getMem()->get( $mem_key );
	 //
	 //if ( $get_result ) {
	 //	return $get_result;
	 //}
		
		
		$_user_id = $req["user_id"];
		$sql_following = "SELECT us.nickname, us.thumb, us.user_id FROM user_followers uf join users us on us.user_id = uf.user_id WHERE uf.follower_id = '{$_user_id}'";
		
		$sql_followers = "SELECT us.nickname, us.thumb, us.user_id FROM user_followers uf join users us on us.user_id = uf.follower_id WHERE uf.user_id = '{$_user_id}'";
		
		$sql_shows = "SELECT s.title, s.thumb, s.show_id FROM user_shows us join shows s on us.show_id = s.show_id
		where us.user_id = '{$_user_id}'";
		
		// ill change to that one query thing later.
		$following = DB::query( $sql_following );
		$followers = DB::query( $sql_followers );
		$shows = DB::query( $sql_shows );
		
		//echo " Following: ".count( $following );
		//echo "\n Followers: ".count( $followers );
		
		$profile_views = History::get_views_user_is_responsible_for( $_user_id );
		
		$results = array( "following" => $following , "followers" => $followers , "shows" => $shows , "num_followers" => count($followers) , "num_following" => count($following) , "profile_views" => $profile_views );
		
		
		//MemHelper::getMem()->set( $mem_key , $results, false, 5000 );
		
		//print_r( $results );
		//print_r( $followers );
		
		//die();
		return $results;
		
		// SELECT COUNT(*) FROM user_followers uf WHERE uf.follower_id = 'fa5a4e3c-474e-102b-9839-001c23b974f2'
		// SELECT COUNT(*) FROM user_followers uf WHERE uf.user_id = '{}'
		
	}
	
	
	
	
	
	
	public static function get_public_timeline($req) {
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
		
		$sql = "(".
		
					"SELECT s.title, v.date_added, s.show_id, v.video_id,
					v.thumb, v.title as v_title, 
					'videos' as source,
					DATE_FORMAT( v.date_added , '%b %e') as date_formatted
					
					FROM videos v LEFT JOIN shows s ON v.show_id=s.show_id 
					
					ORDER BY date_added DESC
					LIMIT 50)
					
					UNION
					
					(
					SELECT 'status' as title, 
					date_added, 
					'123456' as show_id,
					content_id as video_id,
					'test thumb' as thumb,
					detail as v_title, 
					'status' as source,
					DATE_FORMAT( date_added , '%b %e') as date_formatted
					FROM user_updates
					ORDER BY date_added DESC
					LIMIT 50 )
					
					ORDER BY date_added DESC;
		";
		
		
		$q = DB::query($sql);
		
		return $q;
		die();
		
	}
	
	
	
	
	
	
	
	
	
	///// older functions //////////
	public static function find_blog_data($req){
		
		
		switch ($req["date_range"])
		{
			case "month" :
				$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
				break;
			case "week" :
					$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")) );
					break;
			 default :
				$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")) );
		}
		
		
			//set user_id to 
			$_user_id = isset($req["user_id"]) ? $req["user_id"] : "84f8189e-465f-102b-9839-001c23b974f2";
			
			$sql = " SELECT s.show_id, s.title, s.thumb,
						count(v.video_id) as new_content, 
						SUM(IF(v.video_type_id = 1, 1, 0)) as new_episodes,
						SUM(IF(v.video_type_id = 2 or v.video_type_id = 0, 1, 0)) as new_clips,
						SUM(IF(v.video_type_id = 3, 1, 0)) new_movies,			
						max(v.date_added) as latest_date,
						if ( (DATEDIFF(max(v.date_added), now()) = 0), DATE_FORMAT(max(v.date_added), '%l:%i %p'), DATE_FORMAT(max(v.date_added), '%b %e') ) as date_formatted,
						GROUP_CONCAT(DISTINCT v.title ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_titles,
						GROUP_CONCAT(DISTINCT v.detail ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_details,
						GROUP_CONCAT(DISTINCT v.thumb ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_thumbs,
						GROUP_CONCAT(DISTINCT v.video_id ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_ids,
						GROUP_CONCAT(DISTINCT v.date_added ORDER BY date_added DESC, v.video_id SEPARATOR '||') as new_dates
						FROM shows s LEFT OUTER JOIN videos v ON s.show_id=v.show_id 
						WHERE v.date_added > '{$_date}'
						AND v.parent_id = '0'
						AND v.video_id not in (SELECT uv.video_id FROM user_videos uv WHERE uv.user_id = '{$_user_id}')
						AND s.show_id in (SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}')
						GROUP BY s.show_id
						ORDER BY latest_date DESC 
						;
			";
			
			
			//echo $sql; die();
			
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
			
			//echo print_r($q); die();
			
			return $q;
		
	}
	
	
	public static function feed_expanded($req)
	{

			$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
			$_user_id = isset($req["user_id"]) ? $req["user_id"] : "84f8189e-465f-102b-9839-001c23b974f2";

			$sql = "
			(SELECT
					v.title,
			    v.video_id,
			    v.thumb,
			    v.detail,
					s.title as subject_title,
					s.show_id as subject_id,
					s.title as show_title,
					'favorite_videos' as content_source,
			    		'' as new_messages,
					v.date_added,
					'0' as action_id,
					'0' as location_type,
					'0' as location_title,
					'0' as location_id
					FROM videos v join shows s on s.show_id = v.show_id
					WHERE v.parent_id = '0'
					AND v.date_added > '{$_date}'
					and s.show_id in ( 
							SELECT show_id from (
								SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}') as t )
					order by date_added desc
					LIMIT 0, 150
					)
			 UNION
			(SELECT
			    up.content_title as title,
			    up.content_id as video_id,
			    up.content_thumb as thumb,
			    up.content_detail as detail,
					up.user_nickname as subject_title,
					up.user_id as subject_id,
					''  as show_title,
					'status_updates' as content_source,
					'0' as new_episodes,
					'0' as new_clips,
					up.action_id,
					up.location_type,
					up.location_title,
					up.location_id
					FROM user_updates up
					where 1 	AND
								( up.user_id in ( SELECT user_id FROM 
									( SELECT uf.user_id FROM user_followers uf 
										WHERE uf.follower_id = '{$_user_id}') as x ) 
										AND up.action_id < 4 AND up.action_id > 1 )			
								 	or  (up.user_id = '{$_user_id}' and up.action_id = 5)
			
					ORDER BY up.date_added DESC
					LIMIT 100)
			 order by date_added desc
			 limit 200
				";
		
			$q = DB::query($sql);
			return $q;
		
	}
	
	
	
	
	
	
	
	
	
	
	// older RSS feed function
	public static function user($req) {
		
				$sql = " SELECT u.user_id, u.email, name_first, name_last
				 	FROM users u
					WHERE (u.nickname = '{$req['id']}') or (u.email = '{$req['id']}')
					";
				$q = DB::query($sql);
				
				$_user_id = $q[0]['user_id'];
				if (empty($_user_id))
				{
					//echo "no rss feed";
					//die();
					
				}
		
			$_rss_url = BASE_URL . "/feeds/user/" . $req['id'];
		
			$opts = array ("user_id" => $_user_id);
		
			$rows = Feed::find_blog_data($opts );
		
			$now = date("D, d M Y H:i:s T");


			$output = "<?xml version=\"1.0\"?>
			            <rss version=\"2.0\"  xmlns:media=\"http://search.yahoo.com/mrss/\">
			                <channel>
			                    <title>SnackFeed RSS for {$q[0]['name_first']}</title>
			                    <link>{$_rss_url}</link>
			                    <description>RSS</description>
			                    <language>en-us</language>
			                    <pubDate>$now</pubDate>
			                    <lastBuildDate>$now</lastBuildDate>
			                    <docs>http://someurl.com</docs>
			                    <managingEditor>info@snackfeed.com</managingEditor>
			                    <webMaster>info@snackfeed.com</webMaster>
			            ";
	
	
			
		
			foreach ($rows as $item)
			{
				$_date = date("r", strtotime($item['latest_date']));
				$_desc = "{$item['new_content']} new pieces of content, 
					Episodes: {$item['new_episodes']}, Clips: {$item['new_clips']}
					{$item['new_titles']}
					";
				$_thumb = BASE_URL . $item['thumb'];
				$_link = BASE_URL;
					
				$output .= "<item><title>".htmlentities($item['title'])."</title>
                    <link>{$_link}</link>
					<description>
					<![CDATA[
					<img src=\"{$_thumb}\" align=\"right\" border=\"0\"   vspace=\"4\" hspace=\"4\" />".htmlentities(stripslashes($_desc))."
					]]></description>
					<media:thumbnail url=\"{$_thumb}\" height=\"90\" width=\"120\"/>
					<pubDate>{$_date}</pubDate>
				    <guid>{$item['show_id']}</guid>	
                </item>";

			}
				
			$output .= "</channel></rss>";
			header("Content-Type: application/rss+xml");
			echo $output;				
		
		die();

	}
	
	
}




?>