 <?
  
 /*
http://online.wsj.com/static_html_files/video-collections.xml
http://online.wsj.com/api-video/find_all_videos.asp?type=wsj-section&query=News&count=60
http://online.wsj.com/api-video/get_video_info.asp?guid={EFC028CE-2D62-4E62-A88F-75F044173C90}&fields=all
http://feeds.wsjonline.com/wsj/video/world/feed
 */



$_JSON_url = $_source_params; 
		
$ch = curl_init ($_JSON_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$json_data = curl_exec($ch); 
curl_close ($ch);


$obj = json_decode($json_data);

foreach ($obj->items as $item) 
{
 	
	
	$_id =  $item->id;

	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		
		
		$_video_id =  DB::UUID();
		$_parent_id = 0;	
		
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$item->name,	
			"detail"		=>	$item->description,	
			"url_source" 	=>	$item->videoURL,	
			"url_link"		=> 	"",	
			"thumb" 		=>	$item->thumbnailURL,
			"date_pub"	=>	date("Y-m-d H:i:s",$item->unixCreationDate),
			"date_added"	=>	date("Y-m-d G:i:s")
	
			);
		

		
		echo 	$item->name . "<br/>";

		//print_r($sql); die();

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;		
		
		
		
	}		
	
		
		
} 
 ?>
 
 
 