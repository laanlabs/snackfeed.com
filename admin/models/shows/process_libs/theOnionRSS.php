<?
$_base_embed = "http://www.theonion.com/content/themes/common/assets/onn_embed/embedded_player.swf?videoid=";
//xmlns:media="http://search.yahoo.com/mrss/" xmlns:dc="http://purl.org/dc/elements/1.1/"

echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);


$i = 0;
$v1 = $xml->xpath("//media:thumbnail");

foreach ($xml->channel->item as $item)
{
	
	$_id = $item->guid;
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;
	
		$_link =  $item->link;
		$_desc = $item->description;

		// get nodes in media: namespace for media information
		$media = $item->children('http://search.yahoo.com/mrss/');

		// get video thumbnail
		$attrs = $media->content->thumbnail[0]->attributes();
		$thumbnail = $attrs['url']; 

		echo $thumbnail. "<br>";



		$dc = $item->children('http://purl.org/dc/elements/1.1/');
		
		$_onion_video_id = $dc->identifier;
		echo $_onion_video_id . "<br>";


		$_embed = $_base_embed . $_onion_video_id . "&image=" . urlencode($thumbnail); 

		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"has_children"	=>	0,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->title,	
			"detail"		=>	trim(strip_tags($item->description)),	
			"url_source" 	=>	$_embed,
			"use_embedded"	=>	1,
			"url_link"		=> 	$item->link,	
			"thumb" 		=>	$thumbnail,
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=> 	_normaliseDate($item->pubDate)
	
			);

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		//echo $nSQL; die();
		
		DB::query($nSQL , false);
		$rCount++;

	
		


		
		
	}
	
	
	
	
	
$i++;
	
}



?>