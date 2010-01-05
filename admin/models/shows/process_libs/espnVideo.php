<?



$espn_image_base_url = "http://assets.espn.go.com/";
$espn_video_base_url =  $_params;


$xml = simplexml_load_file($_url);


foreach ($xml->item as $item) {


$espn_media_id = $item->attributes()->id;
	
	
//check for entry
$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $espn_media_id ."' AND show_id = '" . $_show_id . "';";	
$q = DB::query($sql);



	if (!$q[0]["org_video_id"]) 
	{
	
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
	
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$espn_media_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->headline,	
			"detail"		=>	$item->attributes()->sport . " " . $item->caption,	
			"url_source" 	=>	$espn_video_base_url . $item->asseturl,
			"url_link"		=> 	"",	
			"thumb" 		=>	$espn_image_base_url . $item->thumbnailurl,
			"duration"		=>	$item->attributes()->duration,
			"date_pub"	=>	date("Y-m-d G:i:s"),
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);

		//NEED TO BE ADDED
		//	pubdate
		//	contentcat	

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;	
	

	
	}	
	
	
	
	
	
	
}








?>




