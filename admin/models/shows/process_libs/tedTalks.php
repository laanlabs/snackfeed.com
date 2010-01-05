<?

//http://feeds.feedburner.com/tedtalks_video
//http://images.ted.com/images/ted/tedindex/embed-posters/EdUlbrich-2009.embed_thumbnail.jpg


echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$_id = $item->guid;
	

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_link =  $item->link;

		



		//make video URL - .mp4
		
		$_base_id = str_replace( ".mp4", "", end(explode("/", $_id)) );
		$_base_id = str_replace( "_", "-", $_base_id ); 
		
		$_thumb = "http://images.ted.com/images/ted/tedindex/embed-posters/" . $_base_id . ".embed_thumbnail.jpg";
		
		
		
		$_video_url = str_replace( ".mp4", "-embed_high.flv", $_id );
		$_video_url = str_replace( "podcast", "embed", $_video_url );

		//&videoURL=(.*?)&

 	  

	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_video_url,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$_thumb ,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		echo $item->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		//echo $nSQL; die();
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	
$i++;
	
}



?>