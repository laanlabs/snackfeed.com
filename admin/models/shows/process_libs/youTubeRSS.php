<?


$_youTube_base = "http://www.youtube.com/v/";
$_youTube_get_URL = "http://www.youtube.com/get_video.php?video_id=__VID__&t=__TID__";

echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$tmp = explode("v=", $item->link);
	$_youtube_id = $tmp[1];
	

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_youtube_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		

		//use xpath for namespace
		$v = $xml->xpath("//media:thumbnail");



	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_youtube_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_youTube_base . $_youtube_id,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$v[$i]['url'],
			"param_1"		=>  $_youTube_base,
			"param_2"		=>	$_youtube_id,
			"param_3"		=>	$_youTube_get_URL,
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