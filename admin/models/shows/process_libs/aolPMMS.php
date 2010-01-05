<?

$PMMS_URL = "http://videoapi.aolcdn.com/API/platform/jsondispatch.adp/IMetadataDescribe?ClientCap=pp_us.video.aol.com_4.0&linkDomain=http://us.video.aol.com&RefID=video:asset:pmms:__putPMMSHere__&OutputElement=&withUIBranding=false&withUICascade=false&withPlaycount=true&withTags=true&tagCount=25&tagSort=popularity&tagsAscending=false&withReviews=false&averageRatingOnly=true&callback=dojo.io.ScriptSrcTransport._state.IMetaDataDescribe.jsonpCall";


$_source_params = stripslashes($_source_params);
$_source_params =  urlencode($_source_params) ;



$truveo_show_url = str_replace( "__putShowNameHere__", $_source_params, $_url );

$xml = simplexml_load_file($truveo_show_url);




foreach ($xml->VideoSet->Video as $video) {
	
	$truveo_video_id = $video->id;
	
	//check for entry

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $truveo_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
	
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;

		//get platforms PID
		$pattern = '#pmms:?(.*?)\&#i';
		$subject = $video->videoResultEmbedTag;
		preg_match_all($pattern, $subject, $matches);
		//print_r($matches); 
		$_pmms = $matches[1][0];
		echo $video->title."<br/>";
		echo $_pmms . "<br/>";
		
		if ( !empty($_pmms)) 
		{
		
		$aol_jason_url = str_replace( "__putPMMSHere__", $_pmms, $PMMS_URL );
		
		
		$ch = curl_init($aol_jason_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$json_content = curl_exec($ch);
		
		//get FLV
		$pattern = '#so.addVariable\(\"videoUrl\",\s*\"?(.*?)\"#i';
		$pattern ='#flashMBURL\",\s*\"url\":\s*\[\s*\"?(.*?)\"#i';
		//$pattern = '#pmms:?(.*?)\&#i';
		$subject = $json_content ;
		preg_match_all($pattern, $subject, $matches);
		//print_r($matches); 
		$_flv = $matches[1][0];	
		
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$truveo_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	$video->description,	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	"",	
			"thumb" 		=>	$video->thumbnailUrl,
			"date_pub"	=>	date("Y-m-d G:i:s"),
			"date_added"	=>	date("Y-m-d G:i:s")			
	
			);
		
		//need to added
		//dateProduced
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;	
	}

	}
	



	

}








?>