<?

echo "YOUTUBE process <br/>";

//http://gdata.youtube.com/feeds/api/users/tadwook/favorites?orderby=updated


$feedURL = str_replace("__USERNAME__", $_username, $_url_user_feed);
echo "URL: " . $feedURL . "<br/>";


// read feed into SimpleXML object
$sxml = simplexml_load_file($feedURL);


$results_data = array();
$i = 0;

// iterate over entries in feed
foreach ($sxml->entry as $entry) {
		
		// get nodes in media: namespace for media information
		$media = $entry->children('http://search.yahoo.com/mrss/');
		
		// get video player URL
		$attrs = $media->group->player->attributes();
		$watch = $attrs['url']; 
		
		// get video thumbnail
		$attrs = $media->group->thumbnail[0]->attributes();
		$thumbnail = $attrs['url']; 
		
		// get <yt:duration> node for video length
		$yt = $media->children('http://gdata.youtube.com/schemas/2007');
		$attrs = $yt->duration->attributes();
		$length = $attrs['seconds']; 
		
		// get <yt:stats> node for viewer statistics
		$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
		$attrs = $yt->statistics->attributes();
		
		$viewCount = @$attrs['viewCount'] ? @$attrs['viewCount'] : 0; 
		
		
		// get <gd:rating> node for video ratings
		$gd = $entry->children('http://schemas.google.com/g/2005'); 
		if ($gd->rating) {
		  $attrs = $gd->rating->attributes();
		  $rating = $attrs['average']; 
		} else {
		  $rating = 0; 
		} 
		
		$_yt_watch_url = (string)$watch;
		
		$_yt_title = (string)$media->group->title;
		$_yt_detail = (string)$media->group->description;
		$_yt_thumb = (string)$thumbnail;
		$_yt_views = (string)$viewCount;
		$_yt_date_pub = (string)$entry->published;
		
		
		echo "FOUND" . $_yt_title . $watch_url . "<br>";
		
		$_youtube_id = end(explode("/",$entry->id));
		
		$_comment = "favorited this video on youTube";
		
	//look for this entry in users table
	$sql = "SELECT guid_hash FROM ext_user_items 
			WHERE ext_id = '{$_ext_id}' AND user_id = '{$_user_id}' 
			AND guid_hash = '{$_youtube_id}';";
		$q1 = DB::query($sql);		
		
		if (count($q1) == 0 )
		{

			//SHOW IS NOT IN USER FEED-- DO WE HAVE IT IN DB

			//DO WE HAVE THIS VIDEO			
			//DO WE HAVE THIS VIDEO			
			$sql = "SELECT video_id, title, thumb, detail FROM videos 
					WHERE source_id = '{$_source_id}'
					AND org_video_id = '{$_youtube_id}'";
			$q2 = DB::query($sql);	
		
			
			if (count($q2)>0) {
				
				$_video_id = $q2[0]['video_id'];
				echo "WE HAVE THIS VIDEO" . $_video_id . "<br>";
					
				
			} else {
				$_video_id =  DB::UUID();
				$_parent_id = 0;
				$_batch_id = 0;
				$_youTube_base = "http://www.youtube.com/v/";
				$_youTube_get_URL = "http://www.youtube.com/get_video.php?video_id=__VID__&t=__TID__";
				$_thumb_base = "http://i.ytimg.com/vi/__ID__/default.jpg";
		
		
				$sql = array (
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_youtube_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$_yt_title,	
			"detail"		=>	trim(strip_tags($_yt_detail)),	
			"url_source" 	=>	$_youTube_base . $_youtube_id,
			"url_link"		=> 	$_yt_watch_url,	
			"thumb" 		=>	$_yt_thumb,
			"param_1"		=>  $_youTube_base,
			"param_2"		=>	$_youtube_id,
			"param_3"		=>	$_youTube_get_URL,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	$_yt_date_pub
			);

	
		//print_r($sql);die();
		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		DB::query($nSQL , false);

			}
			
			
			//add this to the feed
			Status::user_favorited_video( array( "action_icon" => "0" , "video_id" => $_video_id , "comment" => $_comment) );	
			
			//INSERT into user feed
			$sql = "INSERT INTO ext_user_items SET 
					ext_id = '{$_ext_id}',
					user_id = '{$_user_id}',
						guid_hash = '{$_youtube_id}'";
			DB::query($sql, false);			
			
			echo "VIDEO ADDED: " . $_yt_title . "<br>";
			
		}	

		
		
		$i++;
	}
		


?>