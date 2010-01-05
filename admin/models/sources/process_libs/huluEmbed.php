<?

$_show_feed_base_url = "http://www.hulu.com/feed/show/";
$_thumb_base = "http://assets.hulu.com/showthumbs/show_thumbnail_XXX.jpg";

$getCount = 0;

for($i=749; $i<1050 ; $i++)
{
	$_show_url = $_show_feed_base_url . $i;
	
	
	
	$sql = " SELECT source_params 
 			FROM shows WHERE source_id = '" . $_source_id . "'
			AND source_params = '" . $i . "'
			;";

	
	$q = DB::query($sql);
	
	
	
	if (!$q[0]["source_params"]) 
	{
	
		echo "GET THIS SHOW: " . $_show_url . "<br>"; 
		
		
		$ch = curl_init ($_show_url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$rawdata=curl_exec($ch);
		curl_close ($ch);	
		
		
		
		$pattern ='#404\s*Not\s*Found\s*Server#i';
		preg_match_all($pattern, $rawdata, $matches);
		
		print_r($matches);
		
		//echo "404 error";
		if (count($matches[0]) < 1 ) 
		{
			
			
	
		
		
		
		$xml = simplexml_load_file($_show_url);
		
		
		
		
		$_title = str_replace("Hulu - Videos for ", "", $xml->channel->title);
		echo $_title . "<br/>";
		echo "VIDEO COUNT : " . count($xml->channel->item) . "<br/>";
		
		if ( count($xml->channel->item) > 0) 
		{
		
		
			$_show_id = DB::UUID();
			
			//assume we have good show
			$_thumb_url = str_replace("XXX", $i, $_thumb_base );
			
			echo $_thumb_url;
			
			$ch = curl_init ($_thumb_url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			$rawdata=curl_exec($ch);
			curl_close ($ch);



			$_image_name = PUBLIC_ROOT . "/images/shows/" . $_show_id . ".jpg";

			$fp = fopen($_image_name,'w');
			fwrite($fp, $rawdata);
			fclose($fp);
			
			
			
			 $sql =  array(
				"show_id"		=>		$_show_id,
				"source_id"		=> 		$_source_id,
				"source_params" =>		$i,
				"title"			=> 		$_title,
				"thumb" 		=>		"/images/shows/" . $_show_id . ".jpg"
				
				);
			 

	
			 $nSQL = "INSERT INTO shows SET " . DB::assoc_to_sql_str($sql);
			echo $nSQL;
	
			 DB::query($nSQL , false);
			
			
			
				//die();
			
		}
		
		
		}
		
		
		$getCount++;
		//if ($getCount > 6 ) die("tomanny shows");
		
		
	}
	
	
	
	
	
}


die();

?>

500
