<?

echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);

//echo "TITILE: " . $xml->channel->title;

$i = 0;

foreach ($xml->results->video as $video)
{
	
	$_id =  $video['id'];
	
	
	
	
	
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;


		foreach ($video->videoMedias->videoMedia as $media)
		{
			if ($media->format == 'flash')
			{
				$_flv = $media->progDeliveryUrl;
				break;
			}


		}


			$sql = array (
				"batch_id" 		=> 	$_batch_id,
				"video_id"	 	=>	$_video_id,
				"org_video_id"	=>	$_id,
				"parent_id"		=> 	$_parent_id,
				"source_id"		=>	$_source_id,
				"show_id"		=> 	$_show_id,	
				"title"			=> 	$video->title,	
				"detail"		=>	$video->description,	
				"url_source" 	=>	$_flv,
				"url_link"		=> 	"",	
				"thumb" 		=>	 $video->image->resizedImage[4]->imageUrl,
				"date_added"	=>	date("Y-m-d G:i:s"),
				"date_pub"		=> 	$video->firstPublishDate

				);

			echo $video->title;
			
			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

			DB::query($nSQL , false);
			$rCount++;	
	
	
	
	}
	

	
	
	
	

	
 $i++;	
}





?>