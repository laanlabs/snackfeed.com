<?



//http://r.hulu.com/videos?content_id=4595799
//http://r.hulu.com/videos?content_id=11379011&include=video_assets
echo "HULU LIB <br/>";


$feedURL = $_url_user_feed . $_username . ".rss";
echo "URL: " . $feedURL . "<br/>";


$sxml = simplexml_load_file($feedURL);


// iterate over entries in feed
foreach ($sxml->channel->item as $item) {


	// get nodes in media: namespace for media information
	$media = $item->children('http://search.yahoo.com/mrss/');
	$hulu = $item->children('http://hulu.com/feed');
	
	$rating = $hulu->rating;
	
	
	//only activity with ratings 
	if (!empty($rating)) {
		$attrs = $media->player->attributes();
		$_player = $attrs['url'];
	
		$_eid = str_replace("http://www.hulu.com/embed/","", $_player);
		$_link = $item->link;
		$_guid_hash = md5($_link);
		
		$_comment = "rated this a {$rating} on HULU";
		
		echo $_eid . "<br>";
		echo $_guid_hash . "<br>";  



		//look for this entry in users table
		$sql = "SELECT guid_hash FROM ext_user_items 
				WHERE ext_id = '{$_ext_id}' AND user_id = '{$_user_id}' 
				AND guid_hash = '{$_guid_hash}';";
		$q1 = DB::query($sql);

		
		if (count($q1) == 0 )
		{

			//SHOW IS NOT IN USER FEED-- DO WE HAVE IT IN DB

			//DO WE HAVE THIS VIDEO			
			$sql = "SELECT video_id, title, thumb, detail FROM videos 
					WHERE source_id = '{$_source_id}'
					AND url_source LIKE '%{$_eid}'";
			$q2 = DB::query($sql);	

			if (count($q2)>0) {
				
				$_video_id = $q2[0]['video_id'];
				echo "WE HAVE THIS VIDEO" . $_video_id . "<br>";
					
				
			} else {
				//WE DONT HAVE IT -- GO THROUGH HELL!!!!
				require_once "hulu_get_video.php";	
				echo "getting video from hulu";		
				$_video_id = hulu_get_video($_link, $_eid);

			}
			
			
			//add this to the feed
			Status::user_favorited_video( array( "action_icon" => "0" , "video_id" => $_video_id , "comment" => $_comment) );	
			
			//INSERT into user feed
			$sql = "INSERT INTO ext_user_items SET 
					ext_id = '{$_ext_id}',
					user_id = '{$_user_id}',
						guid_hash = '{$_guid_hash}'";
			DB::query($sql, false);			
			
			echo "VIDEO ADDED: " . $item->title . "<br>";
			
		}				
				


		
	}

echo "<hr>";


}











?>

