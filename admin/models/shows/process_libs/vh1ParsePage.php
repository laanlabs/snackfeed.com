
<?
	//$get_video_url = "http://www.mtv.com/player/includes/flvgen.jhtml?vid=__ID__&hiLoPref=hi";
	$get_video_url = "http://www.vh1.com/video/player/videos/player/includes/flvgen.jhtml?vid=__ID__&hiLoPref=hi";
	$get_video_list = "http://www.vh1.com/video/play.jhtml?id=";




    $_base_thumb = "http://www.vh1.com";

	$ch = curl_init($_source_params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);
	curl_close($ch);

	//get FLV

//echo $html_content;


	//$pattern ='#play.jhtml\?id=(.*)\"#i';
	$pattern ='#_image\"><a href=\"\/video\/play.jhtml\?id=(.*?)\"(.*?)title=\"(.*?)\"(.*?)src=\"(.*?)\"#i';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches); 
	
	





for ($i=0; $i < count($matches[0]); $i++)
{
	
	$vh1_video_id =  $matches[1][$i];
	
	echo $vh1_video_id; 
	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $vh1_video_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;

	
	
			//*** INSERT PARENT ***//
			$sql = array (
				"batch_id" 		=> 	$_batch_id,
				"video_id"	 	=>	$_video_id,
				"org_video_id"	=>	$vh1_video_id,
				"parent_id"		=> 	$_parent_id,
				"has_children"	=>	1,
				"source_id"		=>	$_source_id,
				"show_id"		=> 	$_show_id,	
				"title"			=> 	$matches[3][$i],	
				"detail"		=>	"VH1",	
				"url_source" 	=>	$_video_url,
				"url_link"		=> 	"",	
				"thumb" 		=>	$_base_thumb. $matches[5][$i],
				"date_added"	=>	date("Y-m-d G:i:s"),
				"date_pub"		=>	date("Y-m-d G:i:s"),
				"order_by"		=>	$_order

				);

			echo "ADDED: " . $matches[3][$i] . "<br/>";


			$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

			DB::query($nSQL , false);
			$rCount++;
	
			
			
			
			$ch = curl_init($get_video_list . $vh1_video_id);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$html_content = curl_exec($ch);
			curl_close($ch);


			//$pattern ='#play.jhtml\?id=(.*)\"#i';
			$pattern ='#img_link_.\"\s*href=\"(.*?)\"><img\s*src=\"(.*?)\"#i';
			preg_match_all($pattern, $html_content, $matches2);
			//print_r($matches2);


			//$pattern ='#play.jhtml\?id=(.*)\"#i';
			$pattern ='#list_link\">(.*?)\<\/a#i';
			preg_match_all($pattern, $html_content, $matches3);
			//print_r($matches3);



		

//id="img_link_1" href=" " href="


			$_parent_id = $_video_id;
			$_parent_order_by = 1;
			
			
			for ($j=0; $j < count($matches2[0]); $j++)
			{
				

				$_segment_id = end(explode("vid=", $matches2[1][$j]));
				echo $_segment_id;
			
				
				
				$video_xml_url = str_replace( "__ID__", $_segment_id, $get_video_url );

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
					"org_video_id"	=>	$vh1_video_id,
					"parent_id"		=> 	$_parent_id,
					"parent_order_by" => $_parent_order_by,
					"source_id"		=>	$_source_id,
					"show_id"		=> 	$_show_id,	
					"title"			=> 	$matches3[1][$j],	
					"detail"		=>	"VH1",	
					"url_source" 	=>	$_video_url,
					"url_link"		=> 	"",	
					"thumb" 		=>	$_base_thumb . $matches2[2][$j],
					"date_added"	=>	date("Y-m-d G:i:s"),
					"date_pub"		=>	date("Y-m-d G:i:s")

					);
				

				echo "ADDED: " . $matches3[1][$j] . "<br/>";


				$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

				DB::query($nSQL , false);
				$rCount++;	
				$_parent_order_by++;			
				
				$j++;
			
			}




	
			
			
	
	}
	
	
	
}






?>