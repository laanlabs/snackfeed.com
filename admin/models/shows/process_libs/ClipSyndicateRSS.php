



<?


$_xml_base_url = "http://eplayer.clipsyndicate.com/pl_xml/video/";


echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);



//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$tmp = explode("/", $item->guid);
	$_id = end($tmp);
	

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_xml_url = $_xml_base_url . $_id;
	

	
		$xml2 = simplexml_load_file($_xml_url);
		
		//assume the video is the last trac -- couldnt find a consistant variable to filter on...
		foreach ($xml2->trackList->track as $track) {
			$_track = $track->location;
			
			$_flv =  $track->location;
			$_thumb = $track->image;			
			
		}



		

	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	strip_tags($item->description),	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$_thumb,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		//need to added
		//date
		
		//echo $item->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	
$i++;
	
}







?>
