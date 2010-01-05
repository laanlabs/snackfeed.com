
<?
$_xml_request_base =  '<?xml version="1.0"?><getdir brn="2" ses="0" ccd="0" uid="0" sec="0" ins="0" pkg="__ID__" />';
$_xml_request_url = "http://player.entropymedia.com/core";
$_video_base_url = "http://www-tc.pbs.org";

$_source_type_id = (!empty($_source_params_2)) ? $_source_params_2 : "2";

echo "URL: " . $_source_params  . "<br>";

$i = 0;


$xml = simplexml_load_file($_source_params);

foreach ($xml->pkg as $item)
{
// @attributes->id
// idcode
// $item->attributes()->airdate
// $item->attributes()->pageurl
// $item->attributes()->logo
	$_id= $item->attributes()->id;






	
	


	echo $item->title;


		


	


		


		echo $item->title . "<br/>";


			
		
		
		
		//** INSERT SEGMENTS **//
		$_request_str = str_replace("__ID__", $_id ,$_xml_request_base);
		


		$ch = curl_init($_xml_request_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $_request_str);
		$html_content = curl_exec($ch);
		curl_close($ch);

		//echo $html_content;		
		
		$html_content =preg_replace('/\&/', '', $html_content);
		$xml2 = simplexml_load_string($html_content);

		
		echo "FOUND SEGEMENTS: " . count($xml2) . "<br>";		
		

		$k=1;
			
		
		foreach ($xml2->ditem as $item)
		{

		$_id= $item->attributes()->id;


		//echo "NOT FOUND MAKE ENTRY";
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		$_parent_order_by = 1;

		$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
		$q = DB::query($sql);
		
		if (!$q[0]["org_video_id"]) 
		{


			$sql = array (
				"batch_id" 		=> 	$_batch_id,
				"video_id"	 	=>	$_video_id,
				"org_video_id"	=>	$_id,
				"parent_id"		=> 	$_parent_id,
				"parent_order_by" => $k,
				"source_id"		=>	$_source_id,
				"show_id"		=> 	$_show_id,	
				"title"			=> 	$item->tit,	
				"detail"		=>	$item->dsc,	
				"url_source" 	=>	$_video_base_url . $item->attributes()->src,
				"url_link"		=> 	$item->attributes()->pageurl,	
				"thumb" 		=>	$item->attributes()->tmb,
				"date_added"	=>	date("Y-m-d G:i:s"),
				"video_type_id" =>  $_source_type_id,
				"date_pub"		=> 	$item->attributes()->dti

				);


			echo "ADDED: " . $item->tit . "<br/>";
			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
			DB::query($nSQL , false);
			$rCount++;	
			$k++;			
	
		}			
			

	}
	
echo "<hr>";
$i++;

}



?>




