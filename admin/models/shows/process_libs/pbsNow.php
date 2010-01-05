
<?

$_base_url ="http://www.pbs.org";
$_RSS_feed = "http://www.pbs.org/now/rss.xml";

$_flv_url = "http://www.pbs.org/now/php/video-playlist.php?topics=%22+topics+%22&showno=__ID__&d=0.0.00&t=%22+t+%22&limit=1";


echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_RSS_feed );


$i = 0;

foreach ($xml->channel->item as $item)
{

$_tmp = $item->link;
$_tmp = str_replace("/index.html", "", $_tmp);
$_id = end(explode("/", $_tmp));

	
//$_id = hash('md5', $item->link);
	
echo "ID: " . $_id . "<br/>";

$_video_link = str_replace("__ID__", $_id, $_flv_url);

echo "LINK: " . $_video_link . "<br/>";

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	

	   	$ch = curl_init($_video_link);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);		
       
		//echo $html_content;
		

		$pattern ='#enclosure\s*type\=\"video\/x\-flv\"\\s*url\=\"(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches);
		//print_r($matches);
		$_flv = $matches[1][0];
		
		$pattern ='#thumbnail\s*url\=\"(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches);
		//print_r($matches);
		$_thumb = $matches[1][0];
		


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	$item->description,	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$_thumb,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);
		
		
		echo $item->title . "<br/>";


		//print_r($sql); die();

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;

		
		
	}
	
	
	
	
	
$i++;
	
}



?>