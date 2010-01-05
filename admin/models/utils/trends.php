
<?
$starttime = microtime();$startarray = explode(" ", $starttime); $starttime = $startarray[1] + $startarray[0];

require_once '/var/www/sf-public/lib/you_tube_helper.php';
require_once(APP_ROOT . "/lib/simple_html_dom.php");


$_date = date("Y-m-d G:i:s");








		$_t = "empty";

		$trends = array();


		$feedURL = "http://www.google.com/trends/hottrends/atom/hourly";
		
		
		// read feed into SimpleXML object
		$sxml = simplexml_load_file($feedURL);
		

		$entry = $sxml->entry[0];
		
		
		$str = "<html><body>" . $entry->content. "</body></html>";
		$html = str_get_html($str);
		
		$i = 0;
		foreach($html->find('a') as $element)
		{
		
			$trends[$i]['keywords'] = $element->plaintext;
			$i++;		
		}
		
		
		//get the HT: namespace with snippets
		$entry = $sxml->entry[1];
		$trend = $entry->content->children('http://www.google.com/trends/hottrends');

		$i = 0;
		foreach ($trend->root->entry as $t_entry) 
		{
			$trends[$i]['source'] = addslashes((string)$t_entry->source);
			$trends[$i]['source_url'] = (string)$t_entry->source_url;
			$trends[$i]['snippet'] = addslashes(trim(strip_tags((string)$t_entry->snippet)));
		$i++;		
		}

for ($i=0; $i < count($trends); $i++) { 
	
	$_order = $i + 1;
	$sql = "INSERT INTO google_trends SET 
			order_by = '{$_order}',
			title = '{$trends[$i]['keywords']}',
			detail = '{$trends[$i]['snippet']}',
			source = '{$trends[$i]['source']}',
			source_url = '{$trends[$i]['source_url']}',
			date_created = '{$_date}'
			ON DUPLICATE KEY UPDATE 
				order_by = '{$_order}',
				detail = '{$trends[$i]['snippet']}',
				source = '{$trends[$i]['source']}',
				source_url = '{$trends[$i]['source_url']}'
			";
	
		DB::query($sql, false);
	
}


		
for ($i=0; $i < 20 ; $i++) { 

$sql = "SELECT trend_id FROM google_trends WHERE title = '{$trends[$i]['keywords']}'";
$q = DB::query($sql);
$_trend_id = $q[0]['trend_id'];


$_keywords = $trends[$i]['keywords']; 
//$_keywords = "+".$_keywords;
//$_keywords  = str_replace(" "," +", $_keywords );

echo "LOOKING FOR: " . $_keywords . "<br>";


$data = s_search($_keywords,5);


echo "FOUND SF: " . count($data) . "<br>";




for ($k=0; $k < count($data) ; $k++) { 
	
	$sql = "INSERT INTO google_trend_videos SET
		trend_id = '{$_trend_id}',
		video_id = '{$data[$k]['video_id']}', 
		title = '" . addslashes($data[$k]['title']) . "', 
		detail = '" . addslashes($data[$k]['detail']) . "', 
		thumb = '{$data[$k]['thumb']}', 
		show_title = '" . addslashes($data[$k]['show_title']) . "', 
		show_id = '{$data[$k]['show_id']}'
		ON DUPLICATE KEY UPDATE status = status";
	DB::query($sql, false);	
}

$yt_count = 5 - count($data);

if ($yt_count > 0 )
{

	$results_data = YouTubeHelper::perform_search( array('query' => $trends[$i]['keywords']  , 
						'start-index'=>'1' , 'max-results'=>'10' , 'orderby'=>'relevance' ) );
	$video_results = $results_data['videos'];
	
	echo $vTotal = $results_data['total']. "<br>";
	
	if ($vTotal < $yt_count) $yt_count = $vTotal ;
						
for ($k=0; $k < $yt_count ; $k++) { 
	
	$sql = "INSERT INTO google_trend_videos SET
		trend_id = '{$_trend_id}',
		video_id = '0',
		ext_id = '{$video_results[$k]['video_id']}', 
		video_type = '2', 
		title = '" . addslashes($video_results[$k]['title']) . "', 
		detail = '" . addslashes($video_results[$k]['detail']) . " ', 
		thumb = '{$video_results[$k]['thumb']}', 
		show_title = 'youtube', 
		show_id = '92a439fe-80bc-102b-908a-00304897c9c6'
		ON DUPLICATE KEY UPDATE status = status";
	DB::query($sql, false);	
}





}

//print_r($data);

//print_r($trends);

}		
	

	$ping_title = "Snackfeed search terms video trends blog";
	$ping_url = "http://snackfeed.com/public/trends";
	$ping_rss = "http://snackfeed.com/public/trends_rss";

//echo $ping_title . $ping_url . $ping_rss ;


//ping_blogs($ping_title,$ping_url,$ping_rss );


$endtime = microtime();$endarray = explode(" ", $endtime);$endtime = $endarray[1] + $endarray[0];$totaltime = $endtime - $starttime;$totaltime = round($totaltime,5);
echo "This page loaded in $totaltime seconds.";
	
?>
