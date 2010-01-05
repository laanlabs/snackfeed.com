
<?


$_xml_url = "http://www.superdeluxe.com/sd/series/__ID__/playlistUploads.xml";


$_url = str_replace("__ID__", $_source_params , $_xml_url );

echo "URL: " . $_url  . "<br>";

$xml = simplexml_load_file($_url);




foreach ($xml->videos->video as $video)
{
	
	$_id =  $video->id;
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		


		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	

	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_heavy_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	trim(strip_tags($video->description)),	
			"url_source" 	=>	$video->videoUrl,
			"url_link"		=> 	$video->videoPageUrl,	
			"thumb" 		=>	$video->imageUrl,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	date("Y-m-d G:i:s")
	
			);
		

		echo $video->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	

	
}




?>