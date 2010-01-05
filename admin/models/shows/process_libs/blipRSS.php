<?



echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$_blip_id = $item->guid;
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_blip_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_link =  $item->link;


		//echo $item->title . "<br>";

		//$row = simplexml_load_string($item->asXML());
		$v = $xml->xpath("//media:content[@type='video/x-flv']");
		//echo $v[$i]['url'] . "<br>";


		$v1 = $xml->xpath("//media:thumbnail");
		//echo $v1[$i]['url'] . "<br>";
		//echo "<hr>";		

       


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_blip_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	strip_tags($item->description),	
			"url_source" 	=>	$v[$i]['url'],
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$v1[$i]['url'],
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