<?

/*
	client completes this
	1. gets server time  from
		$server_time_url = "http://asfix.adultswim.com/asfix-svc/services/getServerTime";
	2. adds that to &rnd = server_time to url_source
	3. makes http header key and requests video	

*/




$segment_base_url = "http://asfix.adultswim.com/asfix-svc/episodeservices/getVideoPlaylist?id=";




$adultSwim_show_url = $_url . $_source_params ;
echo "URL: " . $adultSwim_show_url . "<br/>";




$xml = simplexml_load_file($adultSwim_show_url);



$id_array = array();


foreach ($xml->episode as $episode) {
	
	$adultSwim_video_id = $episode->attributes()->id;
	array_push($id_array, $adultSwim_video_id);
	
	//INSERT PARENT
	//check for entry
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $adultSwim_video_id ."' AND show_id = '" . $_show_id . "';";	
	$q = DB::query($sql);
	


		$_video_id =  DB::UUID();
		$_parent_id = 0;

		$_video_type_id = 0;
		//echo $episode->attributes()->episodeType;
		if ($episode->attributes()->episodeType == 'EPI') { 
			$_video_type_id = 1;
		} elseif ($episode->attributes()->episodeType == 'PRE') { 
			$_video_type_id = 1;
		}  else {
			$_video_type_id = 2;
		}

		//echo $episode->attributes()->expirationDate;
	


		$sql = array (
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$adultSwim_video_id,
			"parent_id"		=> 	$_parent_id,
			"has_children"	=>	1,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$episode->attributes()->title,	
			"detail"		=>	str_replace("\n", "" ,$episode->description),	
			"url_source" 	=>	"",
			"url_link"		=> 	"",	
			"thumb" 		=>	$episode->attributes()->thumbnailUrl,
			"video_type_id"	=>	$_video_type_id,
			"date_pub"	=>	date("Y-m-d G:i:s"),
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);

		//needs to be addes
		//$episode->attributes()->expirationDate


	 	
		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		//only insert if not there
		if (!$q[0]["org_video_id"]) 
		{
			 DB::query($nSQL , false);
			$rCount++;
		}

	$_parent_id = $_video_id;
	$sCount = 0;
	$segments = simplexml_load_string($episode->segments->asXML());
	foreach ($segments->segment as $segment) {

		echo $segment->attributes()->thumbnailUrl. "<br/>";
		//INSERT SEGMENTS
		$_segment_id =  DB::UUID();
		
		array_push($id_array, $segment->attributes()->id);
		
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_segment_id,
			"org_video_id"	=>	$segment->attributes()->id,
			"parent_id"		=> 	$_parent_id,
			"parent_order_by"=>	$sCount,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"url_source" 	=>	$segment_base_url . $segment->attributes()->id,
			"thumb" 		=>	$segment->attributes()->thumbnailUrl,
			"date_pub"	=>	date("Y-m-d G:i:s"),
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		
		//only insert if not there
		if (!$q[0]["org_video_id"]) 
		{
				DB::query($nSQL , false);	
				$sCount++;
		}	
	
	}
	
	
	//echo $adultSwim_video_id . "<br/>";


	

	
}


//CLEAN UP EXPIRED EPISODES
//echo "HERE<hr/>";
$id_list = quote_csv(implode(",", $id_array));


$sql = "DELETE FROM videos
	WHERE show_id = '{$_show_id}'
AND org_video_id NOT IN ({$id_list})";
DB::query($sql , false);	




?>