<?


//GET THE COLLECTION ID
echo "URL:" . $_source_params_2 . "<br/>";

$ch = curl_init ($_source_params_2);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$html_content = curl_exec($ch);

//&amp;collectionId=80677&amp;
$pattern ='#\&amp\;collectionId=(.*?)\&amp\;#i';
preg_match_all($pattern, $html_content, $matches);
//print_r($matches);

$_collection_id = $matches[1][0];

//look for the collection id another way
if (empty($_collection_id))
{
	
	$pattern ='#\"collectionId=(.*?)\&amp\;#i';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches);

	$_collection_id = $matches[1][0];
	
}




$_url = str_replace("__ID__", $_collection_id, $_source_params);


echo "URL:" . $_url . "<br/>";
$ch = curl_init ($_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$page_data = curl_exec($ch);





$dom = new DomDocument();

$dom->loadXML($page_data);
$xpath = new DomXPath($dom);
$result = $xpath->query("//module[@id='model']/channel/item");

echo $result->length;
$_link_base = "";


foreach($result as $b) {

 

$guid= $b->getElementsByTagName("guid");
$_guid = $guid->item(0)->firstChild->nodeValue;

$_id = end(explode(":", $_guid));


$link= $b->getElementsByTagName("link");
$_link =  $link->item(0)->firstChild->nodeValue;



	$title= $b->getElementsByTagName("title");
	$_title = $title->item(0)->firstChild->nodeValue;
	
	


	$desc= $b->getElementsByTagName("description");
	$_desc =  $desc->item(0)->firstChild->nodeValue;


	$thumbnail = $b->getElementsByTagName("thumbnail");
    $_thumb = $thumbnail->item(0)->getAttribute('url');
	if (!strstr($_thumb, "http://"))  $_thumb  = $_link .  $_thumb ; 


	$content = $b->getElementsByTagName("content");
    $_content = $content->item(1)->getAttribute('url');
	if (!strstr($_content, "http://"))  $_content  = $_link .  $_content ; 


	$pubDate = $b->getElementsByTagName("pubDate");
    $_pubDate = _normaliseDate( $pubDate->item(0)->firstChild->nodeValue );


	echo $_id . "<br>";
	echo $pubDate->item(0)->firstChild->nodeValue . "<br>";
	
	
	//begin insert
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";
	$q = DB::query($sql);
	



	
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
			"detail"		=>	$_desc,	
			"url_source" 	=>	$_content,
			"url_link"		=> 	$_link,	
			"thumb" 		=>	$_thumb,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	$_pubDate,
			"order_by"		=>	$_id	
			);

		echo $_title;

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;
	
	}
	
	
	

#
}





?>