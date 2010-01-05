<?

$_base_item_url = "http://www.current.com/items/";


echo "URL: " . $_source_params  . "<br>";

//use curl instead of xml load because of errors in rss


$ch = curl_init($_source_params);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$html_content = curl_exec($ch);
curl_close($ch);		
     
//echo $html_content;
// \<div\s*class=\"contentItemDesc\">(.*?)<a\s*href=\"\/items\/\"

$pattern =	'#<div\s*class=\"contentItemDesc\">(.*?)<a\s*href=\"\/items\/(.*?)\"#is';

preg_match_all($pattern, $html_content, $matches);
//print_r($matches);



for ($j=0; $j < count($matches[0]); $j++)
{
	
	$_id = $matches[2][$j];
	
	echo $_id;
	
		
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{


		$_link = $_base_item_url . $matches[2][$j];

echo $_link;
		
		//get link page for FLV
		$ch = curl_init($_link);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);




			//	so.addVariable('imageUrl', 'http://i.current.com/images/epg/art/CristineCambrea/1_400x300.jpg');
			//			so.addVariable('videoUrl', 'http://v.current.com/video/feeds/broadcast/Pods/PD18/523/PD18523_44569820.flv')



			$pattern =	"#so.addVariable\(\'imageUrl\'\,\s*\'(.*?)\'#i";
			preg_match_all($pattern, $html_content, $matches2);
			$_thumb = $matches2[1][0];


			$pattern =	"#so.addVariable\(\'videoUrl\'\,\s*\'(.*?)\'#i";
			preg_match_all($pattern, $html_content, $matches2);
			$_flv = $matches2[1][0];

			$pattern =	"#so.addVariable\(\'contentTitle\'\,\s*\'(.*?)\'#i";
			preg_match_all($pattern, $html_content, $matches2);
			$_title = $matches2[1][0];



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
				"detail"		=>	trim(strip_tags($matches[1][$j])),	
				"url_source" 	=>	$_flv,
				"url_link"		=> 	$_link,	
				"thumb" 		=>	$_thumb,
				"date_added"	=>	date("Y-m-d G:i:s"),
				"date_pub"	=>	date("Y-m-d G:i:s")

				);
	
			//need to added
			//date
	
			//echo $item->title . "<br/>";

			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

			DB::query($nSQL , false);
			$rCount++;	




	}



}






?>

