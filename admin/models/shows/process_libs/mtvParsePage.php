
<?
	$get_video_url = "http://www.mtv.com/player/includes/flvgen.jhtml?vid=__ID__&hiLoPref=hi";
	$get_video_list = "http://www.mtv.com/player/u/ajax/vidList.jhtml?id=__ID__";

    $_base_thumb = "http://www.mtv.com";

	$ch = curl_init($_source_params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);


	//get FLV

	$pattern ='#<strong>\s*<a\s*href=\"\/overdrive\/\?(vid|id)=?(.*?)\">(.*)\<#i';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches); 
	
	$pattern ='#icon\"\/>\s*<img\s*src=\"?(.*?)\"#i';
	preg_match_all($pattern, $html_content, $matches2);
	//print_r($matches2);	

	$_flv = $matches2[1][0];




for ($i=0; $i < count($matches[0]); $i++)
{
	
	$mtv_video_id =  $matches[2][$i];
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $mtv_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;


		//if the id is 'ID' then we need to get segment peices
		if ($matches[1][$i] == 'id') 
		{
	
	
			//*** INSERT PARENT ***//
			$sql = array (
				"batch_id" 		=> 	$_batch_id,
				"video_id"	 	=>	$_video_id,
				"org_video_id"	=>	$mtv_video_id,
				"parent_id"		=> 	$_parent_id,
				"has_children"	=>	1,
				"source_id"		=>	$_source_id,
				"show_id"		=> 	$_show_id,	
				"title"			=> 	$matches[3][$i],	
				"detail"		=>	"MTV",	
				"url_source" 	=>	$_video_url,
				"url_link"		=> 	"",	
				"thumb" 		=>	$_base_thumb. $matches2[1][$i],
				"date_added"	=>	date("Y-m-d G:i:s"),
				"date_pub"		=>	date("Y-m-d G:i:s"),
				"order_by"		=>	$_order

				);

			echo "ADDED: " . $matches[3][$i] . "<br/>";


			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

			DB::query($nSQL , false);
			$rCount++;
	
			
			$video_list_url = str_replace( "__ID__", $mtv_video_id, $get_video_list );
			$xml = simplexml_load_file($video_list_url);
			$result = $xml->xpath("//div/a");

			$_parent_id = $_video_id;
			$_parent_order_by = 1;
			
			
			foreach ($result as $video) {
				
				$id_href = $video->attributes()->href;
				echo "VIDEO: " . $id_href  ."<br/>";
				echo "VIDEO: " .  $video->img->attributes()->alt ."<br/>";
				echo "VIDEO: " .  $video->img->attributes()->src ."<br/>";

				
				$id_href_tmp = explode("vid=", $id_href);
				$mtv_seg_video_id = $id_href_tmp[1];
				echo $mtv_seg_video_id;
				
				
				$video_xml_url = str_replace( "__ID__", $mtv_seg_video_id, $get_video_url );

				$ch = curl_init($video_xml_url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$xml_content = curl_exec($ch);

				//echo $xml_content;
				preg_match('@<src>?(.*?)<\/src@i',$xml_content, $xml_match);
				$_video_url = $xml_match[1];
				echo $_video_url;
				
				$_seg_video_id =  DB::UUID();
				
				$sql = array (
					"batch_id" 		=> 	$_batch_id,
					"video_id"	 	=>	$_seg_video_id,
					"org_video_id"	=>	$mtv_seg_video_id,
					"parent_id"		=> 	$_parent_id,
					"parent_order_by" => $_parent_order_by,
					"source_id"		=>	$_source_id,
					"show_id"		=> 	$_show_id,	
					"title"			=> 	$video->img->attributes()->alt,	
					"detail"		=>	"MTV",	
					"url_source" 	=>	$_video_url,
					"url_link"		=> 	"",	
					"thumb" 		=>	$_base_thumb . $video->img->attributes()->src,
					"date_added"	=>	date("Y-m-d G:i:s"),
					"date_pub"		=>	date("Y-m-d G:i:s")

					);
				

				echo "ADDED: " . $video->img->attributes()->alt . "<br/>";


				$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

				DB::query($nSQL , false);
				$rCount++;	
				$_parent_order_by++;			

			
			}




	
			
			
		//*** JUST INSERT SHOWS FROM VID ***///	
		} else {

		$video_xml_url = str_replace( "__ID__", $mtv_video_id, $get_video_url );

		$ch = curl_init($video_xml_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$xml_content = curl_exec($ch);
		
		//echo $xml_content;
		preg_match('@<src>?(.*?)<\/src@i',$xml_content, $xml_match);
		$_video_url = $xml_match[1];
		$_order = $i+1;
	
		$sql = array (
			"batch_id" 		=> 	$_batch_id,
			"video_id"	 	=>	$_video_id,
			"org_video_id"	=>	$mtv_video_id,
			"parent_id"		=> 	$_parent_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$matches[3][$i],	
			"detail"		=>	"MTV",	
			"url_source" 	=>	$_video_url,
			"url_link"		=> 	"",	
			"thumb" 		=>	$_base_thumb . $matches2[1][$i],
			"date_added"	=>	date("Y-m-d G:i:s"),
			"date_pub"		=>	date("Y-m-d G:i:s"),
			"order_by"		=>	$_order
	
			);
		
		echo "ADDED: " . $matches[3][$i] . "<br/>";
		

		$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
	
		DB::query($nSQL , false);
		$rCount++;
		}

	}
	
	
	
}






?>