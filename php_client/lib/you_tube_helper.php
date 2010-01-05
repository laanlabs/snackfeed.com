


<?php

class YouTubeHelper {
	
	
	
	public static function try_mem () {
				
				require_once LIB."/memhelper.php";
				
				
				
				$sMyString = "I'm going to be cached!";
				MemHelper::getMem()->set("mykey", $sMyString, false, 600) 
				
				or die ("Could not write to the cache");
				
				
				$get_result = MemHelper::getMem()->get('mykey');
				
				echo "Data from the cache: ".$get_result; 
		
		
	}
	
	
	public static function get_youtube_related_videos( $vId ) {
		
		
		
		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$vId.'/related';
		
		
		// read feed into SimpleXML object
		$sxml = simplexml_load_file($feedURL);
		
		
		// get summary counts from opensearch: namespace
		$counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
		$vTotal = $counts->totalResults;
		
		
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
				
				$results_data[$i]["watch_url"] = (string)$watch;
				
				$results_data[$i]["title"] = (string)$media->group->title;
				$results_data[$i]["detail"] = (string)$media->group->description;
				$results_data[$i]["thumb"] = (string)$thumbnail;
				$results_data[$i]["views"] = (string)$viewCount;
				$results_data[$i]["date_pub"] = (string)$entry->published;
				
				$i++;
			}
		
		
		return $results_data;
		
	}
	
	public static function get_top_rated_today()
	{
		
		return YouTubeHelper::get_you_tube_feed( "top_rated" , "today" );
	}
	
	
	
	public static function get_most_viewed_today()
	{
		
		return YouTubeHelper::get_you_tube_feed( "most_viewed" , "today" );
		
	}
	
	public static function get_most_linked_today()
	{
		
		return YouTubeHelper::get_you_tube_feed( "most_linked" , "today" );
		
	}
	
	
	/// generic function to get youtube feeds...
	public static function get_you_tube_feed( $feed_name , $time )
	{
		
		
		// required in app.php
		require_once LIB."/memhelper.php";
		
		//or die ("Could not write to the cache");
		
		$mem_key = $feed_name.$time."1";
		
		$get_result = MemHelper::getMem()->get($mem_key);
		
		if ( $get_result ) {
			return $get_result;
		} 
		
		// this_week
		
		// http://gdata.youtube.com/feeds/api/standardfeeds/most_viewed
		// http://gdata.youtube.com/feeds/api/standardfeeds/most_linked
		// http://gdata.youtube.com/feeds/api/standardfeeds/top_rated?time=today
		// http://gdata.youtube.com/feeds/api/standardfeeds/most_discussed
		
		$feedURL = 'http://gdata.youtube.com/feeds/api/standardfeeds/'.$feed_name.'?time='.$time;
		
		
		// read feed into SimpleXML object
		$sxml = simplexml_load_file($feedURL);
		
		
		// get summary counts from opensearch: namespace
		$counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
		$vTotal = $counts->totalResults;
		
		
		$results_data = array();
		$videos = array();
		
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
				
				$videos[$i]["watch_url"] = (string)$watch;
				
				$videos[$i]["title"] = (string)$media->group->title;
				$videos[$i]["detail"] = (string)$media->group->description;
				$videos[$i]["thumb"] = (string)$thumbnail;
				$videos[$i]["views"] = (string)$viewCount;
				$videos[$i]["date_pub"] = (string)$entry->published;
				$videos[$i]["video_id"] = str_replace("http://www.youtube.com/watch?v=", "",   $videos[$i]["watch_url"] );
				
				$i++;
			}
		
		
		//$results_data = array( "total" => $vTotal , "videos" => $videos );
			
		// write to memcached
		MemHelper::getMem()->set( $mem_key , $videos, false, 1000 );
		
		return $videos;
		
	}
	
	
	public static function perform_search( $params ) {
		
		
		foreach ( $params as $param ) {
			
		}
		
		$feedURL =
		'http://gdata.youtube.com/feeds/api/videos?vq='.$params['query'].'&start-index='.$params['start-index'].'&max-results='.$params['max-results'].'&orderby='.$params['orderby'] ;
		
		
		// read feed into SimpleXML object
		$sxml = simplexml_load_file($feedURL);
		
		
		// get summary counts from opensearch: namespace
		$counts = $sxml->children('http://a9.com/-/spec/opensearchrss/1.0/');
		$vTotal = $counts->totalResults;
	
		
		
		$results_data = array();
		$videos = array();
		
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
				
				
				$videos[$i]["watch_url"] = (string)$watch;
				
				$videos[$i]["title"] = (string)$media->group->title;
				$videos[$i]["detail"] = (string)$media->group->description;
				$videos[$i]["thumb"] = (string)$thumbnail;
				$videos[$i]["views"] = (string)$viewCount;
				
				//$videos[$i]["date_pub"] = (string)$entry->published;
				$videos[$i]["date_pub"] = (string)date("M-d-y", strtotime(  (string)$entry->published ));
				
				$videos[$i]["video_id"] = str_replace("http://www.youtube.com/watch?v=", "",   $videos[$i]["watch_url"] );
				
				
				$i++;
			}
			
			
			
			$results_data = array( "total" => (string)$vTotal , "videos" => $videos );
			
			
			return $results_data;
		
		
	}
	
	
}