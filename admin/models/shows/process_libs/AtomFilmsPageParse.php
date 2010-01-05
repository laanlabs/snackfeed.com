<?

$_base_content = "http://media.mtvnservices.com/video/feed.jhtml?ref=http%3A//None&type=normal&uri=mgid%3Ahcx%3Acontent%3Aatom.com%3A";




echo "URL: " . $_source_params  . "<br>";

//use curl instead of xml load because of errors in rss


$ch = curl_init($_source_params);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$html_content = curl_exec($ch);
curl_close($ch);		
     
//echo $html_content;




$pattern =	"#uri\:\s*\'mgid\:hcx\:content\:atom\.com\:(.*?)\'#i";
preg_match_all($pattern, $html_content, $matches);
print_r($matches);
		



for ($j=0; $j < count($matches[0]); $j++)
{
	
	$_id = $matches[1][$j];
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	

		$_content_url =  $_base_content . $_id;

		echo $_content_url . "<br>";



		$ch = curl_init($_content_url);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);
		
		
		$sxml = simplexml_load_string($html_content);
		
		$media = $sxml->channel->item->children('http://search.yahoo.com/mrss/');
		
		
		$_link = $sxml->channel->item->link;
		$_title = (string)$media->group->title;	
		$_detail = (string)$media->group->description;	
		
		$attrs = $media->group->thumbnail->attributes();			
		$_thumb = $attrs['url'];
		
		$attrs = $media->group->player->attributes();			
		$_source = $attrs['url'];

		$_date = _normalisedate($sxml->channel->item->pubDate);


	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$_title,	
			"detail"		=>	$_detail,	
			"url_source" 	=>	$_source,
			"use_embedded"	=>	1,
			"url_link"		=> 	$_link,	
			"thumb" 		=>	$_thumb,
			"date_pub"		=>	$_date,
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);
		


		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		//echo $nSQL; die();
		
		DB::query($nSQL , false);
		$rCount++;

		
		
	}	
	
	
	
	
	
$i++;
	
}



?>