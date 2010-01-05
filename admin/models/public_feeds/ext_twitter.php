<?

$_t= "empty";
//get the max tw_id

$sql = "SELECT max(tw_id) as tw_id FROM ext_twitter_youtube ;";
$q = DB::query($sql);
$tw_id = $q[0]['tw_id'];



//since_id={$tw_id}

$json_url = "http://search.twitter.com/search.json?&since_id={$tw_id}&rpp=100&&q=+filter%3Alinks+youtube.com/watch";

echo $json_url . "<br/>";

$ch = curl_init ($json_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$json_data = curl_exec($ch);
curl_close ($ch);


$obj = json_decode($json_data);

 //var_dump( "<pre>" , $obj , "</pre>" );

echo count($obj->results);

foreach ($obj->results as $result) {
echo $result->id . ":" . $result->text . "<br/>";



$_text = $result->text;


		$pattern ='#youtube\.com\/watch\?v=([A-Za-z0-9_%-]*)[&\w;=\+_\-]*#i';
		preg_match_all($pattern, $_text, $matches);
		//print_r($matches);
		$youtube_id = $matches[1][0];
		
		if (strlen($youtube_id) < 10 )
		{
			
			//look for URL shorteners
			$pattern ='#tinyurl\.com\/([A-Za-z0-9._%-]*)[&\w;=\+_\-]*#i';
			preg_match_all($pattern, $_text, $matches);
			//print_r($matches);
			$tiny_id = $matches[1][0];
			
			
			
			if (!empty($tiny_id))
			{
				
				echo "TINY ID: " . $tiny_id . "<br/>";
				$_url = "http://search.twitter.com/hugeurl?url=http%3A%2F%2Ftinyurl.com%2F{$tiny_id}";
				echo $_url;
				$ch = curl_init ($_url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
				$_data = curl_exec($ch);
				curl_close ($ch);	
				echo $_data;
				
				$pattern ='#youtube\.com\/watch\?v=([A-Za-z0-9_%-]*)[&\w;=\+_\-]*#i';
				preg_match_all($pattern, $_data, $matches);
				//print_r($matches);
				$youtube_id = $matches[1][0];
							
			}
			
			
			
			
			
		}



echo $youtube_id . "<br/>";

if (strlen($youtube_id) > 8 )
{




	$_thumb = "http://i2.ytimg.com/vi/" . $_id . "/default.jpg";
	$_date = date("Y-m-d G:i:s");
	$_tweet = addslashes($result->text);
	
	$sql = "
		INSERT INTO ext_twitter_youtube SET  
		youtube_id = '{$youtube_id}',
		count = 1,
		tw_id = '{$result->id}',
		tweet = '{$_tweet}',
		from_user = '{$result->from_user}',
		thumb = '{$_thumb}',
		date_added = '{$_date}',
		date_published = '{$entry->published}'

		
		ON DUPLICATE KEY UPDATE count = count+1, date_updated = '{$_date}'	
		;";		


	DB::query($sql, false);
echo  "RECORD CREATED<br/>";
}

echo  "<hr/>";

}



//update missing titles

	$sql = "
		SELECT youtube_id FROM ext_twitter_youtube 
		WHERE title = '' OR title is null 
		ORDER BY count DESC
		LIMIT 20
		;";		


	$q = DB::query($sql);

	foreach ($q as $r) {
		
		$youtube_id = $r['youtube_id'];
		$_status = "1";
		

		$feedURL = 'http://gdata.youtube.com/feeds/api/videos/'.$youtube_id;
		// read feed into SimpleXML object
		$entry = simplexml_load_file($feedURL);
		
		if (!empty($entry))
		{
		// get nodes in media: namespace for media information
		$media = $entry->children('http://search.yahoo.com/mrss/');
		
		// get video player URL
		$attrs = $media->group->player->attributes();
		$watch = $attrs['url']; 
		
		// get video thumbnail
		$attrs = $media->group->thumbnail[0]->attributes();
		$_thumb = $attrs['url'];
		//echo $thumbnail;

		$_title = addslashes($entry->title);
		$_detail = addslashes($entry->content);
		$_date_pub= $entry->published; //date("Y-m-d", strtotime($entry->published));
		} else {
			
			$_status = "0";
			$_title = "JUNK VIDEO";
			
		} 


	$sql = "
		UPDATE ext_twitter_youtube SET  
		title = '{$_title}',
		detail = '{$_detail}',
		date_published = '{$_date_pub}',
		status = '{$_status}'
			WHERE youtube_id = '{$youtube_id}';";
		
		 DB::query($sql, false);



	}

//var_dump( "<pre>" , $obj , "</pre>" );




echo "ALL DONE!!!!!";


?>