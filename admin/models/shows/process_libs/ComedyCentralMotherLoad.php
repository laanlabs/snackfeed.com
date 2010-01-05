<?


$_url =  str_replace("__ID__", $_source_params, $_url);


echo $_url;



$xml = simplexml_load_file($_url);

$_base_url = "http://www.comedycentral.com";

$rCount = 0;

echo "<hr>";
/* Search for <a><b><c> */
$result = $xml->xpath("//element[@parentid='" . $_source_params . "']");



foreach ($result as $title) {    



//	echo $title['parentid'] . "<br>";
	
	$_title  = $title->title;   
	$_desc = $title->description ;  
	$_author = $title->author ;  

	$_title = mysqli_real_escape_string($link,  $_title);
	$_desc = mysqli_real_escape_string($link,  $_desc);


//	echo $_title . "<br>";  
	
	$_image_url = $_base_url . trim($title->imageurl); 
	$_org_video_id = trim($title->videoid); 
	$_video_url = $_base_url .  trim($title->videourl);   	

//	echo $_org_video_id . "<br>"; 	
//	echo $_image_url . "<br>";   	
//	echo $_video_url . "<br>";   		

	$_url_link = "http://www.thedailyshow.com/video/index.jhtml?videoId=" . $_org_video_id;
	
	//begin insert
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_org_video_id ."' AND show_id = '" . $_show_id . "';";
	$q = DB::query($sql);
	



	
	if (!$q[0]["org_video_id"]) 
	{
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_org_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$_title,	
			"detail"		=>	$_desc,	
			"url_source" 	=>	$_video_url,
			"url_link"		=> 	$_url_link,	
			"thumb" 		=>	$_image_url,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($title->airdate),
			"order_by"		=>	$_org_video_id	
			);

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;
	
	}
	

	
	
	
	
	
	
}

//echo $rCount . "<br>";  

?>