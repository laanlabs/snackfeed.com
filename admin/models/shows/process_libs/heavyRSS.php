
<?

$_base_url = "http://www.heavy.com";
$_gateway_url = "http://www.heavy.com/flash/data/remoting/gateway.php?params=[__videoID__]&exec=getVideoById";


echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

echo $xml->title;


foreach ($xml->channel->item as $item)
{
	
	$_heavy_id = end(explode("/", $item->guid));
	

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_heavy_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		


		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_heavy_link =  str_replace("__videoID__", $_heavy_id, $_gateway_url);

		

		$ch = curl_init ($_heavy_link);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$page_data = curl_exec($ch);


 
		$pattern ='#\"file\":\"?(.*?)\"#i';
		preg_match_all($pattern, $page_data, $matches);
		$_flv =  stripslashes($matches[1][0]);

		$pattern ='#\"thumb\":\"?(.*?)\"#i';
		preg_match_all($pattern, $page_data, $matches);
		$_thumb = $_base_url . stripslashes($matches[1][0]);


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_heavy_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	"",	
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
	
	
	
	
	

	
}




?>