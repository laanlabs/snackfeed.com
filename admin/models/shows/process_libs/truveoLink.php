<?
$_source_params = stripslashes($_source_params);

echo $_source_params . "<br/> ";
$_source_params =  urlencode($_source_params) ;
echo htmlspecialchars($_source_params);


$truveo_show_url = str_replace( "__putShowNameHere__", $_source_params, $_url );

echo "URL: " . $truveo_show_url . "<br>";



$xml = simplexml_load_file($truveo_show_url);




foreach ($xml->VideoSet->Video as $video) {
	
	$_id = $video->id;
	
	//check for entry

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
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	$video->description,	
			"url_source" 	=>	"",
			"url_link"		=> 	$video->referrerPageUrl,
			"thumb" 		=>	$video->thumbnailUrl,
			"use_embedded"	=>	$_use_embedded,
			"use_link"		=>	$_use_link,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>  _normalisedate($video->dateProduced),
			"video_type_id"	=>	1
	
			);
		
		//need to added
		//dateProduced
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;	


	
	}	
	



	

}








?>