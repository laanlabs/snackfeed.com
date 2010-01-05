<?
$_source_params = stripslashes($_source_params);

echo $_source_params . "<br/> ";
$_source_params =  urlencode($_source_params) ;
//echo htmlspecialchars($_source_params);


$truveo_url =  "http://www.cbs.com/thunder/swf/rcpHolderCbs-AOL2-PROD.swf?link=http://www.cbs.com&partnerLogo=images/testPartnerLogo.gif&releaseURL=http://release.theplatform.com/content.select%3Fpid=__putPIDHere__&Tracking=true&Embedded=True&partner=aol&autoPlayVid=False";


$truveo_show_url = str_replace( "__putShowNameHere__", $_source_params, $_url );

echo "URL: " . $truveo_show_url . "<br>";



$xml = simplexml_load_file($truveo_show_url);

$id_array = array();


foreach ($xml->VideoSet->Video as $video) {
	
	$truveo_video_id = $video->id;
	array_push($id_array, $truveo_video_id);
	//check for entry

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $truveo_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
	
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		//get platforms PID
		$pid = end(explode("/" ,$video->referrerPageUrl));
		echo strlen($pid) . "<br/> ";
		
		//make sure we have valid PID when is 32 characters long
		if (strlen($pid) == 32 ) {
	
		$truveo_video_url = str_replace( "__putPIDHere__", $pid, $truveo_url );
		
		//update to newer player
		$truveo_video_url = str_replace("swf/rcpHolderCbs-AOL2-PROD.swf", "swf30can10/rcpHolderCbs-3-4x3.swf", $truveo_video_url );
		
		//echo $truveo_video_url;die();
		
		
		
		echo $truveo_video_url . "<br/>";
	
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$truveo_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	$video->description,	
			"url_source" 	=>	$truveo_video_url,
			"url_link"		=> 	"",	
			"thumb" 		=>	$video->thumbnailUrl,
			"use_embedded"	=>	$_use_embedded,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>	date("Y-m-d G:i:s"),
			"video_type_id"	=>	1
	
			);
		
		//need to added
		//dateProduced
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;	
	}

	
	}	
	



	

}



$id_list = quote_csv(implode(",", $id_array));


$sql = "DELETE FROM videos
	WHERE show_id = '{$_show_id}'
AND org_video_id NOT IN ({$id_list})";
DB::query($sql , false);




?>