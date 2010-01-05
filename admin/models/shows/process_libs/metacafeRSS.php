<?



echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

echo $xml->title;


foreach ($xml->channel->item as $item)
{
	
	$_metacafe_id = $item->id;
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_metacafe_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		


		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_metacafe_link =  $item->link;


		$ch = curl_init ($_metacafe_link);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$page_data = curl_exec($ch);


		$pattern ='#mediaURL=?(.*?)&postRollContentURL#i';
		preg_match_all($pattern, $page_data, $matches);
		$_flv = $matches[1][0];

		$pattern ='#<img\s*src=\"?(.*?)\"#i';
		preg_match_all($pattern, $item->description, $matches);
		//print_r($matches);
		$_thumbnail = $matches[1][0];
		

       


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_metacafe_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	"",	
			"thumb" 		=>	$_thumbnail,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		//need to added
		//date
		
		echo $item->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	

	
}




?>