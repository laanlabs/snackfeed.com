<?


echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$tmp = explode("v=", $item->guid);
	$_veoh_id = $tmp[1];
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_veoh_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$details_url = 'http://www.veoh.com/rest/video/' . $_veoh_id . '/details';

		$xml2 = simplexml_load_file($details_url);

		$_flv =  $xml2->video->attributes()->fullPreviewHashLowPath;
		$_thumb = $xml2->video->attributes()->fullMedResImagePath;

	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_veoh_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	_removeEvilTags($item->description),	
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
