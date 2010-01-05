<?

/*

http://friendfeed.com/public?service=youtube
http://friendfeed.com/search?&public=1&service=youtube

*/

$json_url = "http://friendfeed.com/api/feed/public?&service=youtube&public=1&who=&format=xml&num=1000000";



$xml = simplexml_load_file($json_url);



//$result = $xml->xpath("//entry/link");

echo count($xml->entry);

foreach ($xml->entry as $entry) {
	
	
	$_id = end(explode("=", $entry->link));
	echo $entry . "<br/>";
	echo $_id . "<br/>";
	echo '<img src="http://i2.ytimg.com/vi/' . $_id . '/default.jpg"/>';
	echo count($entry->like) . "<br/>";
	echo count($entry->comment) . "<br/>";
	
	$_thumb = "http://i2.ytimg.com/vi/" . $_id . "/default.jpg";
	$_date = date("Y-m-d G:i:s");
	$_title = addslashes($entry->title);
	$_likes = count($entry->like);
	$_comments = count($entry->comment);
	
	$sql = "
		INSERT INTO ext_friendfeed_youtube SET  
		youtube_id = '{$_id}',
		ff_id = '{$entry->id}',
		likes = '{$_likes}',
		comments = '{$_comments}',
		title = '{$_title}',
		thumb = '{$_thumb}',
		date_added = '{$_date}',
		date_published = '{$entry->published}'

		
		ON DUPLICATE KEY UPDATE likes = '{$_likes}', comments = '{$_comments}', date_updated = '{$_date}'	
		;";		


	DB::query($sql, false);
	
	
}

//print_r($result);





?>