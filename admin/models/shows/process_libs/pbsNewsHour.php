<?
$_xml_request_url = "http://player.entropymedia.com/core";
$_xml_request_base =  '<?xml version="1.0"?><getdir brn="1" ses="0" ccd="0" uid="0" sec="0" ins="0" pkg="news__ID__" />';
$_video_base_url = "http://www-tc.pbs.org";


$_NH_yesterday = date("dmY",mktime(0,0,0,date("m"),date("d")-1,date("Y")) ); 
$_NH_today = date("dmY");
$_dateArray = array($_NH_yesterday, $_NH_today ); 

//$_NH_date = "29092008";
//print_r($_dateArray);

foreach ($_dateArray as $_NH_date) {


//** INSERT SEGMENTS **//
$_newshour_request_str = str_replace("__ID__", $_NH_date ,$_xml_request_base);

echo $_NH_date . "<br>";

$ch = curl_init($_xml_request_url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $_newshour_request_str);
$html_content = curl_exec($ch);
curl_close($ch);

//header("Content-type: text/xml");
echo $html_content; 
//die();


$pattern =	'#<ditem\s*typ=\"0\"\s*id=\"(.*?)\"';
$pattern .= '\s*tmb=\"(.*?)\"';
$pattern .= '\s*src=\"(.*?)\"';
$pattern .= '(.*?)dti=\"(.*?)\"';
$pattern .= '(.*?)<tit><\!\[CDATA\[(.*?)\]\]><\/tit>';
$pattern .= '<dsc><\!\[CDATA\[(.*?)\]\]><\/dsc>';

$pattern .=  '#is';
preg_match_all($pattern, $html_content, $matches);


/*
 1 = id
 2= jpg
 3 = flv
 5 = date
7 = title
8 desc

*/




	//$xml2 = simplexml_load_string($html_content);


//foreach ($xml2->ditem as $item)
for ($i=0; $i  <  count($matches[1]) ; $i++) 	
	{


		//$_id = $item->attributes()->id;
		$_id = $matches[1][$i];

		$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
		$q = DB::query($sql);

		if (!$q[0]["org_video_id"]) 
		{
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;

		//$item->attributes()->dti

		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_order_by" => $_parent_order_by,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$matches[7][$i],	
			"detail"		=>	$matches[8][$i],	
			"url_source" 	=>	$_video_base_url . $matches[3][$i],
			"url_link"		=> 	"",	
			"thumb" 		=>	$matches[2][$i],
			"date_pub"		=>	$matches[5][$i],
			"date_added"	=>	date("Y-m-d G:i:s")

			);
	

		echo "ADDED: " . $matches[7][$i]. "<br/>";


		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

		DB::query($nSQL , false);


		$rCount++;	
		
	}
		
}

}//end dateloop

?>



