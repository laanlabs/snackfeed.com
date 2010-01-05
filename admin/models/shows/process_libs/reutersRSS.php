<?



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

		$v = $xml->xpath("//media:text");
		$v1 = $xml->xpath("//media:thumbnail");


		//&videoURL=(.*?)&

 	   	$ch = curl_init($_link);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);

		$pattern ='#&videoURL=(.*?)&#i';
		preg_match_all($pattern, $html_content, $matches);
		//print_r($matches);
		
		
		$_flv = $matches[1][0];      


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($v[$i])),	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$v1[$i]['url'],
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