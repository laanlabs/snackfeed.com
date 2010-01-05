<?



echo "URL: " . $_source_params  . "<br>";





// set user agent




		$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
		$ch = curl_init($_source_params);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);

		$xml = simplexml_load_string($html_content);


$i = 0;

foreach ($xml->channel->item as $item)
{
	
	$_id = $item->guid;

	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_link =  $item->link;
		$_desc = $item->description;

		//echo $item->desc . "<br>";



		$pattern =	"#data\=\"(.*?)\"#i";
		preg_match_all($pattern, $_desc, $matches);
		//print_r($matches);
		$_flv = $matches[1][0];
		


		$v1 = $xml->xpath("//media:thumbnail");
		$_thumb = $v1[$i]['url']; 
		
		$_desc =  strip_tags($_desc);
		$_desc = str_replace("Can't see the video? Watch this video now in a browser or download this video now.", "", $_desc);
      

 
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	$_desc,
			"use_embedded"	=> 	1,	
			"video_type_id"	=>	"2",
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$_thumb,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		//need to added
		//date
		
		echo $item->title . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	
$i++;
	
}



?>