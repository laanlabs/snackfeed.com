
<?


$_base_xml = "http://www.mydamnchannel.com/xml/getembedmovie.aspx?associd=";

echo "URL: " . $_source_params  . "<br>";

$i = 0;


$xml = simplexml_load_file($_source_params);

foreach ($xml->channel->item as $item)
{
	
	//http://feeds.feedburner.com/~r/MyDamnChannel-BigFatBrain/~3/437928596/1167_981.aspx
	$html_content = $item->link; 

	$pattern = '#\_([0-9]*)\.aspx#i';
	preg_match_all($pattern, $html_content, $matches2);
	$_id = $matches2[1][0];		

	echo $item->title;

		$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
		$q = DB::query($sql);
		
		if (!$q[0]["org_video_id"]) 
		{

		

		//echo "NOT FOUND MAKE ENTRY";
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		$_parent_order_by = 1;
	
		
		
		//** INSERT SEGMENTS **//
		$_request_str = str_replace("__ID__", $_id ,$_xml_request_base);
		
		$_xml_request_url = $_base_xml . $_id;

		
		$ch = curl_init($_xml_request_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $_request_str);
		$html_content = curl_exec($ch);
		curl_close($ch);

		
		$pattern = '#\<movie\>(.*?)\<\/movie\>#i';
		preg_match_all($pattern, $html_content, $matches2);
		//print_r($matches2);
		$_flv = $matches2[1][0];		

		$pattern = '#src\=\"(.*?)\"#i';
		preg_match_all($pattern, $item->description, $matches2);
		//print_r($matches2);
		$_thumb = $matches2[1][0];


			$sql = array (
				"batch_id" 		=> 	$_batch_id,
				"video_id"	 	=>	$_video_id,
				"org_video_id"	=>	$_id,
				"parent_id"		=> 	$_parent_id,
				"source_id"		=>	$_source_id,
				"show_id"		=> 	$_show_id,	
				"title"			=> 	$item->title,	
				"detail"		=>	trim(strip_tags($item->description)),	
				"url_source" 	=>	$_flv,
				"url_link"		=> 	$item->link,	
				"thumb" 		=>	$_thumb,
				"date_added"	=>	date("Y-m-d G:i:s"),
				"video_type_id" =>  2,
				"date_pub"		=> 	_normaliseDate($item->pubDate)

				);


			echo "ADDED: " . $item->title . "<br/>";
			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
			DB::query($nSQL , false);
			$rCount++;	
	

		}
	
echo "<hr>";
$i++;

}



?>




