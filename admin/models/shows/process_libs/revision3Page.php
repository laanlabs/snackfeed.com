<?

echo "url: " . $_source_params;

	$_base_url = "http://revision3.com";
    $_base_thumb = "";

	$ch = curl_init($_source_params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);
	curl_close($ch);



	$pattern ='#<div\s*class=\"episode_info\">\s*<h3>\s*<a\s*href=\"?(.*?)\"#is';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches); 



for ($i=0; $i < count($matches[1]); $i++)
{
	$_id = $matches[1][$i];
	$_url = $_base_url . $_id;
	echo $_url . "<hr>";


	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{

	
	$ch = curl_init($_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);
	curl_close($ch);
	
	
	$pattern = '#file=?(.*?)\.flv\"#i';
	preg_match_all($pattern, $html_content, $matches2);
	//print_r($matches2);	

	$_flv = $matches2[1][0] . ".flv";
	$temp = explode("&", $_flv);
	$_flv = $temp[0];
	echo $_flv . "<hr>";

	
	$pattern = '#Thumb=?(.*?)\.jpg#';
	preg_match_all($pattern, $html_content, $matches3);
	//print_r($matches3);	

	$_thumb = $matches3[1][0] . ".jpg";
	echo $_thumb . "<hr>";


	$pattern = '#<title\>?(.*?)\<\/title\>#';
	preg_match_all($pattern, $html_content, $matches4);
	//print_r($matches3);	

	$_title = $matches4[1][0] ;
	echo $_title . "<hr>";

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
			"title"			=> 	$_title,	
			"detail"		=>	$_detail,	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$_url,	
			"thumb" 		=>	$_thumb,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	date("Y-m-d G:i:s")
	
			);
		
		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		//echo $nSQL; die();
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
$i++;	
	

}
}




?>