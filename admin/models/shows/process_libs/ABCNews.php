<?

$_show_url =  $_url . $_source_params ;

echo "URL:" . $_show_url . "<br/>";


$xml = simplexml_load_file($_show_url);


foreach ($xml->playlist->channel->clip as $video) {
	
	$_id = $video->attributes()->hitcat;
	
	//echo $_id; die();
	
	//check for entry

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	
	
	if (!$q[0]["org_video_id"]) 
	{
	
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;

		$dtmp = explode("/", $video->attributes()->date);
		$_month = $dtmp[0];
		$_day = $dtmp[1];
		$_year = $dtmp[2];

		$_date=  $_year . "-" . $_month . "-" . $_day;
		echo $_date;
	
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->attributes()->title,	
			"detail"		=>	$video->attributes()->captionnp,	
			"url_source" 	=>	$video->video->attributes()->progurl,
			"url_link"		=> 	$video->attributes()->linkurl,	
			"thumb" 		=>	$video->attributes()->image,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>	$_date
	
			);
		
		//need to added
		//date
		
		echo $video->attributes()->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
	
		//echo $nSQL;die();
	
		DB::query($nSQL , false);
		$rCount++;	
	

	
	}	
	



	

}





?>