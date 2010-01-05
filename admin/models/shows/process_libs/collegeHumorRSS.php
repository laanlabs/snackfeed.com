<?

$_video_xml = "http://www.collegehumor.com/moogaloop/video:";


echo "URL: " . $_source_params  . "<br>";




$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$_id = $item->guid;
	
	
	$pattern ='#video\:(.*?)\/#i';
	preg_match_all($pattern, $_id, $matches);
	//print_r($matches);
	$_id = $matches[1][0];
	
	
	//get the id the other way
	if (empty($_id))
	{
		$_id = end(explode(":" , $item->guid));
	} 
	

	
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	

		$v1 = $xml->xpath("//media:description");

	
	
		$xml2 = simplexml_load_file($_video_xml . $_id);

	
	
		$_link =  $item->link;



	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($v1[$i])),	
			"url_source" 	=>	$xml2->video->file,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$xml2->video->thumbnail,
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