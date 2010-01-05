<?


$_NBC_URL = "http://www.nbcolympics.com/video/modules/json/resourcedata/__ID__/index.html";
$_NBC_BASE = "http://www.nbcolympics.com";
echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);



//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->channel->item as $item)
{
	
	
	$_link = $item->link;
	$temp2 = explode("?", $_link);
	parse_str(end($temp2));  

	$_nbc_id =  $assetid;
	if (empty($_nbc_id)) $_nbc_id =  $videoid;
	
	$_id = $_nbc_id;
	

	if (!empty($_id)){

	echo $item->link . "<br/>";
	echo $_id . "<hr>";

	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		



	//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		
		$_thumb = @$item->enclosure->attributes()->url;
		if (empty($_thumb))
		{
			$_thumb = "http://www.snackfeed.com/images/shows/72d45102-b525-102b-aa95-00304897c9c6.jpg";
		}
		
		
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	strip_tags($item->description),	
			"url_source" 	=>	$item->link,
			"url_link"		=> 	$item->link,
			"thumb" 		=>	$_thumb,
			"video_type_id"	=> 	1,
			"use_embedded"	=>	2,
			"video_format_id" => 2,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		//print_r($sql);	die();

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	}
	
	
	
$i++;
	
}







?>
