<?


$msn_url_embed = "http://msnbcmedia.msn.com/i/msnbc/Components/Video/_Player/configurations/eplayerv2.swf?domain=www.msnbc.msn.com&amp;settings=22425448&amp;useProxy=true&amp;wbDomain=www.msnbc.msn.com&amp;launch=__ID__&amp;sw=1600&amp;sh=1200&amp;EID=oVPEFC&amp;playerid=22425001";

$msn_link = "http://www.msnbc.msn.com/id/22425001/#";

$msnbc_show_url = str_replace( "xxx", $_source_params, $_url );

echo "URL:" . $msnbc_show_url . "<br/>";


$xml = simplexml_load_file($msnbc_show_url);


foreach ($xml->video as $video) {
	
	$msnbc_video_id = $video->attributes()->docid;
	
	//echo $msnbc_video_id ; die();
	
	//check for entry

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $msnbc_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
	
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$row = simplexml_load_string($video->asXML());
		$v = $row->xpath("//media[@type='flashVideo']");	
		$msnbc_video_url = $v[0];
		
		$msnbc_embed_url = str_replace("__ID__", $msnbc_video_id, $msn_url_embed);
		

		$v = $row->xpath("//media[@type='thumbnail']");	
		$msnbc_image_url = $v[0];
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$msnbc_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->headline,	
			"detail"		=>	$video->caption,	
			"url_source" 	=>	$msnbc_embed_url,
			"url_cache" 	=>	$msnbc_video_url,
			"use_embedded"	=>	1,			
			"url_link"		=> 	$msn_link . $msnbc_video_id ,	
			"thumb" 		=>	$msnbc_image_url,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>	date("Y-m-d G:i:s"),
			"duration"		=>	$video->date
	
			);
		
		//need to added
		//date
		
		echo $video->headline . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;	
	

	
	}	
	



	

}





?>