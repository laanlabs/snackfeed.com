<?


$_player_embed = "http://media.mtvnservices.com/video/player.swf?uri=mgid:cms:content:southparkstudios.com:__ID__&group=entertainment&type=network&ref=http%3a%2f%2fwww.southparkstudios.com&geo=US";


function jsonSafe($value)
{
	/**
	 * RTE editor should solve "all" our problems however it does not
	 * escape the double quotes in <a href="test">
	 */
	$pattern = array( '/(.*)="(.*)"/iU' );
	$replacement = array( '$1=\'$2\'' );
	//$value = preg_replace($pattern, $replacement, $value);		
 
	$value = str_replace( "\'", "" , $value);


	return str_replace( 
		array( '\r' , '\n'	, "\r"	, "\n"	, '\\' ),
		array( ''   , '' 	, ''	, ''	, '\\\\' ),
		$value 
	);
	
		/**/
	
	return $value;
				
}




require_once LIB. "/jsonrpc/xmlrpc.inc";
require_once LIB. "/jsonrpc/xmlrpcs.inc";


require_once LIB. "/jsonrpc/jsonrpc.inc";

$_season = $_source_params;


$_JSON_url = "http://v1.smoothtube.com/shows/get_details_and_videos_for?show_id=507b7234-2cea-102b-9a93-001c23b974f2&json";
$_JSON_url = "http://southpark.comedycentral.com/feeds/season_json.jhtml?season={$_season}";

$_media_url = "http://media.mtvnservices.com/video/feed.jhtml?COUNTRY_CODE_UPPER_CASE=US&ref=http%3A//www.southparkstudios.com/episodes/&type=network&COUNTRY_CODE=us&uri=mgid%3Acms%3Acontent%3Asouthparkstudios.com%3A__ID__&geo=US&orig=&franchise=&mode=fe&dist=";


$ch = curl_init ($_JSON_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$page_data = curl_exec($ch);


$page_data = jsonSafe( $page_data );

//echo $page_data; die();



//$result = Zend_Json::decode($page_data, Zend_Json::TYPE_OBJECT);

//var_dump($result); die();


//$result = Zend_Json::decode( $page_data);



json_parse($page_data, true);
$jsonData = $GLOBALS['_xh']['value'];






foreach ($jsonData['season']['episode'] as $episode){
	//title
	//description  
	//thumbnail
	//id
	//airdate
	//episodenumber
	//available
	//when
	//print_r($episode);
	
	$dtmp = explode(".", $episode['airdate']);
	$_month = $dtmp[0];
	$_day = $dtmp[1];
	$_year =  ($dtmp[2] > 50 ) ? "19{$dtmp[2]}" : "20{$dtmp[2]}" ;
	
	$_date=  $_year . "-" . $_month . "-" . $_day;
	echo $_date;
	
	
	$_id = $episode['id'];
	
	if (!empty($_id)) 
	{
		
	echo "ID: " . $_id . "<br/>";
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
	
	
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_link =  $item->link;
		$_desc = $item->description;

		$_thumb = $v1[$i]['url']; 

		echo $_link. "<br>";
		$_url_source = str_replace("__ID__", $_id, $_player_embed);

		echo $_url_source . "<br/>";


		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"has_children"	=>	1,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$episode['title'],	
			"detail"		=>	$episode['description'],	
			"url_source" 	=>	$_url_source,
			"use_embedded"	=> 	1,
			"url_link"		=> 	"",	
			"thumb" 		=>	$episode['thumbnail'],
			"video_type_id"	=>	"1",
			"season"		=>	$_season,
			"episode"		=>	$episode['episodenumber'],
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	$_date
	
			);

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
		DB::query($nSQL , false);
		
		
	
	 /*
	
			$_url = str_replace("__ID__", $_id, $_media_url);
	
			echo $_url;
	
			$xml = simplexml_load_file($_url);
			$v1 = $xml->xpath("//media:content[@isDefault='true']");
	
			$i = 0;
			foreach ($xml->channel->item as $item)
			{
		
				$_title =  $item->title;
				$_flv_loc = $v1[$i]['url'];
				$_flv_loc = str_replace("hiLoPref=lo", "hiLoPref=hi", $_flv_loc);
		
				echo $_flv_loc;
		
				$ch = curl_init($_flv_loc);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$xml_content = curl_exec($ch);

				//echo $xml_content;
				preg_match('@<src>?(.*?)<\/src@i',$xml_content, $xml_match);
				$_video_url = $xml_match[1];
				echo $_video_url;
	
		
						$_segment_id =  DB::UUID();
						$_parent_id = $_video_id;



						$sql = array (
							"video_id"	 	=>	$_segment_id,
							"org_video_id"	=>	$_id,
							"parent_id"		=> 	$_parent_id,
							"parent_order_by" => $i,
							"source_id"		=>	$_source_id,
							"show_id"		=> 	$_show_id,	
							"title"			=> 	$_title,	
							"detail"		=>	"",	
							"url_source" 	=>	$_video_url,
							"url_link"		=> 	"",	
							"thumb" 		=>	"",
							"date_added"	=>	date("Y-m-d G:i:s")

							);

						$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
						DB::query($nSQL , false);
		
		
				$i++;
			}
	 */		
	
	}
	
}
	//die();
	
	
	
	
	
	
}




?>