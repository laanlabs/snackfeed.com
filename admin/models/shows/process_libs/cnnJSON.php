<?


$_cnn_JSON_base_url = "http://www.cnn.com/video/data/2.0/";
$_cnn_video_base_url = "http://ht.cdn.turner.com/cnn/big";

$r = array();
for ($i=0;$i<16;$i++) {
    $r[$i] = rand(0,9);
}


$cnn_url =  $_source_params . "?0." . implode("", $r);

echo "URL:" . $cnn_url . "<br/>";



$xml = simplexml_load_file($cnn_url);


foreach ($xml as $video) 
{

	$_cnn_video_id =  $video->video_id;

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_cnn_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;		
		
		$_JSON_url = $_cnn_JSON_base_url . $video->video_url;
		
		
		//echo 	$_JSON_url;die();
		
		$ch = curl_init ($_JSON_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$page_data = curl_exec($ch);


		//GET DATA BY HAND AS IS NOT FORMATTED FOR PROPER JSON DECODDING with PHP lib

		$pattern = "#location:\s*\'?(.*?)\',#i";
		preg_match_all($pattern, $page_data, $matches);
		//print_r($matches);
		$_flv = $_cnn_video_base_url . $matches[1][0] . "_576x324_dl.flv";	
	
		$pattern = "#headline:\s*\'?(.*?)\',#i";
		preg_match_all($pattern, $page_data, $matches);
		//print_r($matches);
		$_headline =  $matches[1][0] ;	

		$pattern = "#description:\s*\'?(.*?)\',#i";
		preg_match_all($pattern, $page_data, $matches);
		//print_r($matches);
		$_desc =  $matches[1][0] ;
		



		
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_cnn_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$_headline,	
			"detail"		=>	$_desc ,	
			"url_source" 	=>	$_flv,
			"url_link"		=> 	"",	
			"thumb" 		=>	$video->image_url,
			"date_pub"	=>	date("Y-m-d G:i:s"),
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);
		
		//need to added
		//date
		
		echo $_headline . "<br/>";

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;
		
		
	}

	
}

/*

	http://www.cnn.com/.element/ssi/www/auto/2.0/video/xml/by_section_us.xml?0.3146250748413312
	http://www.cnn.com/.element/ssi/www/auto/2.0/video/xml/by_section_showbiz.xml?0.3146250748413312
	http://www.cnn.com/.element/ssi/www/auto/2.0/video/xml/most_popular.xml?0.5637790059921728
	http://www.cnn.com/.element/ssi/www/auto/2.0/video/xml/by_section_sports.xml?0.47403347756966246


	http://ht.cdn.turner.com/cnn/big/us/2008/02/28/lopez.really.dirty.house.kcal_576x324_dl.flv
	http://www.cnn.com/video/data/2.0/video/us/2008/02/28/lopez.really.dirty.house.kcal.json
*/	


?>





