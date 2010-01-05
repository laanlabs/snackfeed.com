<?php

class Status {
	
	public static function user($req) {
		
		
		
		
	}
	
	/*
	
	--  these have not been implemented or standardized in DB, 
	--  so feel free to write notes / ideas
	
	action_id's
		0: watched
		1: added to channel
		2: liked
		3: commented 
		
	content_type's
		0 - video
		1 - show
		2 - channel
		3 - comment
		4 - user_video?
		5 - 
	
	
	
	*/
	
	
	
	
	public static function get_recent_status( $_user_id ) {
		
		
		
		$sql = "SELECT 
		
		date_added,
		user_id,
		content_id,
		detail,
		
		DATE_FORMAT( date_added , '%b %e') as date_formatted
		
		FROM user_updates WHERE user_updates.user_id = '{$_user_id}'
		ORDER BY date_added DESC
		LIMIT 10";
		
		$q = DB::query($sql);
		
		return $q;
		
	}
	
	
	//// Status updates ////////
	
	public static function user_followed_show( $params ) {
		
		if ( !User::$user_id ) { echo "Not logged in"; die(); }
		
		$sql = "SELECT title, thumb, detail FROM shows WHERE shows.show_id = '{$params['show_id']}'";
		$q = DB::query($sql);
		
		if (count($q) == 0 ) {echo "No shows with that id"; die;}
		
		$username = User::$username;
		$user_id = User::$user_id;
		$details = $username . " is now following the show: ".$q[0]['title'];
		
		$show_details = $q[0]['detail'];
		$show_title = $q[0]['title'];
		$show_thumb = $q[0]['thumb'];
		
		// here we would SQL to see if the user has following set to private, then choose, 0, 1, 2 accordingly.
		
	 //Status::insert_status( 
	 //	array( "username" => $username , 
	 //	"user_id" => $user_id , 
	 //	"scope" => "2",
	 //	"content_type" => "1",
	 //	"action_id" => "2",
	 //	"content_id" => $params['show_id'],
	 //	"detail" => $details,
	 //	) );
		
		Status::insert_status( 
			array( 
			"user_id" => $user_id , 
			"user_nickname" => $username , 
			"scope" => "2",
			"content_type" => "1",
			"action_id" => "3",
			"detail" => "",
			"content_id" => $params['show_id'],
			"content_title" => $show_title,
			"content_detail" => $show_details,
			"content_thumb" => $show_thumb
			) );
		
	}
	
	public static function user_followed_channel( $params ) {
		
		
		if ( !User::$user_id ) { echo "Not logged in"; die(); }
		
		$sql = "SELECT title FROM channels WHERE channels.channel_id = '{$params['channel_id']}'";
		$q = DB::query($sql);
		
		if (count($q) == 0 ) {echo "No channels with that id"; die;}
		
		$username = User::$username;
		$user_id = User::$user_id;
		$details = $username . " is now following the channel: ".$q[0]['title'];
		

		
		
		// here we would SQL to see if the user has following set to private, then choose, 0, 1, 2 accordingly.
		
		Status::insert_status( 
			array( "username" => $username , 
			"user_id" => $user_id , 
			"scope" => "2",
			"content_type" => "2",
			"action_id" => "2",
			"content_id" => $params['channel_id'],
			"detail" => $details
			) );
			
			
		
			
		
	}
	
	// when someone adds a video to a channel...
	public static function added_video_to_channel( $params ) {
		
		//%fix%
		if ( !User::$user_id ) { echo "Not logged in"; die(); }
		//if ( !array_key_exists('user_id', $req) ) {
		//	throw new Exception("MISSING REQUIRED KEY(S):  user_id", 1); // abstract this
		//} else {
		
		// i know there shouldnt be 2 queries here, will fix later... //%fix%
		$sql = "SELECT title FROM videos WHERE videos.video_id = '{$params['video_id']}'";
		$q = DB::query($sql);
		
		$sql2 = "SELECT title FROM channels WHERE channels.channel_id = '{$params['channel_id']}'";
		$q2 = DB::query($sql2);
		
		if (count($q) == 0 ) {echo "No videos with that id"; die;}
		
		$username = User::$username;
		$user_id = User::$user_id;
		$details = $username . " added: ".$q[0]['title'] . " to the channel: ".$q2[0]['title'];
		
		// here we would SQL to see if the user has following set to private, then choose, 0, 1, 2 accordingly.
		
		Status::insert_status( 
			array( "username" => $username , 
			"user_id" => $user_id , 
			"scope" => "2",
			"content_type" => "0",
			"action_id" => "1",
			"content_id" => $params['video_id'],
			"location_id" => $params['channel_id'],
			"location_type" => '1',
			"location_title" => $q2[0]['title'],
			"detail" => $details,
			) );
		
		
	}
	
	
	public static function status_update_watched_video( $params ) {
		
		if ( !User::$user_id ) { echo "Not logged in"; die(); }
		//if ( !array_key_exists('user_id', $req) ) {
		//	throw new Exception("MISSING REQUIRED KEY(S):  user_id", 1); // abstract this
		//} else {
		
		$username = User::$username;
		$user_id = User::$user_id;
		$details = $username . " watched ".$params['show_title'] . " - " . $params['title'];
			
			$sql = "SELECT title, detail, thumb FROM videos WHERE videos.video_id = '{$params['video_id']}'";
			$q = DB::query($sql);
			
			$video_details = $q[0]['detail'];
			$video_title = $q[0]['title'];
			$video_thumb = $q[0]['thumb'];

			// here we would SQL to see if the user has following set to private, then choose, 0, 1, 2 accordingly.

			Status::insert_status( 
				array( 
				"user_id" => $user_id , 
				"user_nickname" => $username , 
				"scope" => "2",
				"content_type" => "0",
				"action_id" => "0",
				"detail" => $details,
				"content_id" => $params['video_id'],
				"content_title" => $video_title,
				"content_detail" => $video_details,
				"content_thumb" => $video_thumb,
				"detail" => $details,
				) );
		
		
	}

	// when someone favorites a video, which is now implemented as a flag_video with rating of 5...
	public static function user_favorited_video( $params ) {
		
		if ( !User::$user_id ) { echo "Not logged in"; die(); }
		
		$sql = "SELECT title, detail, thumb FROM videos WHERE video_id = '{$params['video_id']}'";
		$q = DB::query($sql);
		
		//print_r($q);
		//die();
		if (count($q) == 0 ) {echo "No videos with that id"; die;}
		
		$username = User::$username;
		$user_id = User::$user_id;
		$details = $params['comment'];
		
		$video_details = $q[0]['detail'];
		$video_title = $q[0]['title'];
		$video_thumb = $q[0]['thumb'];
		
		
		// here we would SQL to see if the user has following set to private, then choose, 0, 1, 2 accordingly.
		
		
		$action_icon_number = 0;
		
		switch ( $params['action_icon'] ) {
			
			case "like":
				$action_icon_number = 0;
				break;
				
			case "despair":
				$action_icon_number = 1;
				break;
			
			case "wtf":
				$action_icon_number = 2;
				break;
				
			case "weird":
				$action_icon_number = 3;
				break;
				
			case "laughing":
				$action_icon_number = 4;
				break;
				
			default:
				$action_icon_number = 0;
				break;
				
		}
		
		
		Status::insert_status( 
			array( 
			"user_id" => $user_id , 
			"user_nickname" => $username , 
			"scope" => "2",
			"content_type" => "0",
			"action_id" => "2",
			"action_icon" => $action_icon_number,
			"content_id" => $params['video_id'],
			"content_title" => $video_title,
			"content_detail" => $video_details,
			"content_thumb" => $video_thumb,
			"detail" => $details,
			) );
		
		
	}
	
	public static function insert_status( $args ) {
		
		$args['detail'] = addslashes($args['detail']);
		$_date = date("Y-m-d G:i:s");
		
		$args['content_title'] = DB::escape( $args['content_title'] );
		$args['content_detail'] = DB::escape( $args['content_detail'] );
		$args['content_thumb'] = DB::escape( $args['content_thumb'] );
		if (!$args['action_icon'])$args['action_icon']=0;
		
		$sql = "INSERT INTO user_updates 
		SET user_id = '{$args['user_id']}',
	  user_nickname = '{$args['user_nickname']}',
		action_id = '{$args['action_id']}',
		action_icon = {$args['action_icon']},
		location_id = '{$args['location_id']}',
		location_type = '{$args['location_type']}',
		location_title = '{$args['location_title']}',
		scope = '{$args['scope']}',
		detail = '{$args['detail']}',
		content_id = '{$args['content_id']}',
		content_title = '{$args['content_title']}',
		content_detail = '{$args['content_detail']}',
		content_thumb = '{$args['content_thumb']}',
		content_type = '{$args['content_type']}',
		date_added = '{$_date}'
		";
		
		// we need to escape the detail field for quotes, one time it threw an error 
		// also is injection possible here?
		
		DB::query($sql, false);
		//self::$user_id = $_user_id;
		
	}
	
	//status_update_watched_video
	
}

?>