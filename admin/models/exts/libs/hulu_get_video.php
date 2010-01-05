<?

function hulu_get_video($_hulu_page_url, $eid)		
{
	
//the magic contant
$k = 3.735928559e9;		


	 	$ch = curl_init($_hulu_page_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);

		$pattern ='#addVariable\(\"content_id\"\,\s*\"(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches2);
		//print_r($matches2);



//$_content_hash = 'm1puzpmq';
$_content_hash = $matches2[1][0];
$str = substr($_content_hash, 1);
$x = base_convert($str, 36,10);
$sql = "SELECT {$x}^{$k} as content_id";
$q = DB::query($sql);
$_content_id = $q[0]['content_id'];
echo "HULU CONTNET_ID: " . $_content_id . "<br>";


$_xml_url = "http://r.hulu.com/videos?content_id=" . $_content_id ;
echo $_xml_url . "<br>"; 

$xml = simplexml_load_file($_xml_url);
//var_dump($xml);

	if (empty($xml->video))
	{
		echo "no more " . $_type . "<br/>";
		die();		
	}

foreach ($xml->video as $video) {
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		$_use_embedded = 1;
		$_batch_id = 0;
		$_source_id = "2b2569be-2bd6-102b-9a93-001c23b974f2";
			
	
		$_video_url = "http://www.hulu.com/player.swf?eid=" . $eid;
		
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
		
		
		
//WHAT SHOW DOES THIS BELONG TO
$_show_title = $video->show->name;
$sql = "SELECT show_id FROM shows WHERE title = '{$_show_title}'";
$q = DB::query($sql);

if (count($q)== 0){
	$_show_id = '207b153a-4b71-102b-9c45-001c23b974f2'; //CHANGE THIS TO CATCH ALL
} else {
	$_show_id = $q[0]['show_id'];			
}


		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_content_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$video->title,	
			"detail"		=>	$video->description,	
			"url_source" 	=>	$_video_url,
			"url_link"		=> 	$_hulu_page_url,	
			"use_embedded"	=>	$_use_embedded,
			"thumb" 		=>	$video->{'thumbnail-url'},
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>  $video->{'original-premiere-date'},
			"date_expire"	=> 	$video->{'expires-at'},	
			"video_type_id"	=>	$_video_type_id,
			"video_type_desc" => $video->{'programming-type'} 
			);

	
		//print_r($sql);
		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		DB::query($nSQL , false);


}







	return $_video_id;


}









?>