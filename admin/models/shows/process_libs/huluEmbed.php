<?

$typeArray = array("episode", "clip");


//get content_id from rest req
$_url = str_replace( "xxx", $_source_params, $_url );



$seasonArray = explode( "," , $_source_params_2);

foreach ($seasonArray as $_season) {
$_season_url = str_replace( "yyy", $_season, $_url );

	echo "SEASON: " . $_season . "<br/>";


//loop the type of show
foreach ($typeArray as $_type) {
	
	//set type	
	echo $_type . "<br/>";
	$_type_url = str_replace( "zzz", $_type, $_season_url );


//loop pages -- dont do more than 10 pages ever
for ($_pageno=1; $_pageno < 10 ; $_pageno++) { 
	# code...

	//loop pages
	$_page_url = str_replace( "__PAGENO__", $_pageno, $_type_url );

echo " URL: " . $_page_url . "<br>";



$xml = simplexml_load_file($_page_url);
//var_dump($xml);

	if (empty($xml->video))
	{
		echo "no more " . $_type . "<br/>";
		break;
		//die();		
	}


foreach ($xml->video as $video) {
    
	//get content-id and make hulu eid out of it
	$hulu_content_id = $video->{'content-id'};
	

	
	

	$data = $hulu_content_id . $_params;
	echo $hulu_content_id . "<br>";
	$hulu_eid =  base64_encode(pack('H*',md5($data)));
	// $hulu_eid = str_replace( "+", "-", $hulu_eid );
	// $hulu_eid = str_replace( "==", "", $hulu_eid );
	// $hulu_eid = str_replace( "/", "_", $hulu_eid );
	
$hulu_eid = $video->{'eid'};	
	echo "eid: " . $hulu_eid . "<br>";






	//begin insert

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $hulu_eid ."' AND show_id = '" . $_show_id . "';";	
	$q = DB::query($sql);
	

	
	if (!$q[0]["org_video_id"]) 
	{
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_video_url = "http://www.hulu.com/embed/" . $hulu_eid;
		
		//find video type
		$_video_type_id = 0;
		echo $video->{'programming-type'};
		if ( $video->{'programming-type'} == 'Full Episode') { 
			$_video_type_id = 1;
		}  elseif ( $video->{'programming-type'} == 'Full Movie') {
			$_video_type_id = 2;
		} else {
			$_video_type_id = 2;
		}
		
		
	
		 
		
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$hulu_eid,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	$video->description,	
			"url_source" 	=>	$_video_url,
			"url_link"		=> 	"",	
			"use_embedded"	=>	$_use_embedded,
			"thumb" 		=>	$video->{'thumbnail-url'},
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>  $video->{'original-premiere-date'},
			"date_expire"	=> 	$video->{'expires-at'},	
			"video_type_id"	=>	$_video_type_id,
			"video_type_desc" => $video->{'programming-type'} 
			);

	
 
		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
	
		
	
		DB::query($nSQL , false);
		$rCount++;
		
	
	
	}



}

}//end page no loop


} //end type loop


} //end season loop

?>