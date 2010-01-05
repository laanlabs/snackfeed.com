<?



echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

echo $xml->title;


foreach ($xml->channel->item as $item)
{
	
	//use the video ID from the url
	$_break_id = end(explode("/", $item->guid));
	
	echo $_break_id;


	
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_break_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		


		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_break_link =  $item->guid;


		$ch = curl_init ($_break_link);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$page_data = curl_exec($ch);


		$pattern ="#\'videoPath\'\,\s*\'?(.*?)\'\)#i";
		preg_match_all($pattern, $page_data, $matches);
		//print_r($matches);
		$_flv = $matches[1][0];
		
		$pattern ="#\;sGlobalContentFilePath=\'?(.*?)\'#i";
		preg_match_all($pattern, $page_data, $matches);
		// print_r($matches);
		$_sGlobalContentFilePath = $matches[1][0];		
		
		$pattern ="#sGlobalFileName=\'?(.*?)\'#i";
		preg_match_all($pattern, $page_data, $matches);
		//	print_r($matches);
		$_sGlobalFileName = $matches[1][0];

		$_flv = str_replace("'+sGlobalContentFilePath+'" , $_sGlobalContentFilePath, $_flv);
		$_flv = str_replace("'+sGlobalFileName+'" , $_sGlobalFileName, $_flv);

	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_break_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$item->guid,	
			"thumb" 		=>	$item->enclosure->attributes()->url,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
	
		
		echo $item->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	

	
}




?>