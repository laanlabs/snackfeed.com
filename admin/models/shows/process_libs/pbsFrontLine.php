
<?
$_xml_request_url = "http://player.entropymedia.com/core";
$_xml_request_base =  '<?xml version="1.0"?><getdir brn="2" ses="0" ccd="0" uid="0" sec="0" ins="0" pkg="frol__ID__" />';
$_frontline_xml_url_base = "http://www.pbs.org/wgbh/pages/frontline/video/flv/enh/frol__ID__.xml";
$_video_base_url = "http://www-tc.pbs.org";

$_frontline_url = "http://www.pbs.org/wgbh/pages/frontline__ID__.html";

echo "URL: " . $_source_params  . "<br>";

$xml = simplexml_load_file($_source_params);


$i = 0;
$_old_id = 'some_junk';

foreach ($xml->channel->item as $item)
{
	
	//$_link = str_replace("/frontline/rss/redir", "", $item->link);
	$_link = $item->link;
	
	$_id = $_link;
	
	

	
	
	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);


	echo $item->title;



	
	if (!$q[0]["org_video_id"]) 
	{
		

		//echo "NOT FOUND MAKE ENTRY";
		$_video_id =  DB::UUID();
		$_parent_id = 0;
		$_parent_order_by = 1;
	
		
	
		echo $_link;
		

	   	$ch = curl_init($_link);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);


		//look for multipart links first
		//flvpop('/bushswar/view/main');
		//http://www.pbs.org/wgbh/pages/frontline/bushswar/view/main.html
			$pattern ="#flvpop\(\'(.*?)\'#i";
			preg_match_all($pattern, $html_content, $matches);
			//print_r($matches);
			$result = array_unique($matches[1]);

			print_r($result);
			echo "///";

			if (!empty($result))
			{
				$find_url = $_frontline_url;
			} else {
				$result[0] = $_link;
				$find_url = "__ID__";
			}
			

			foreach ($result as $value) { 
				

				
				
				
				$_url = str_replace("__ID__", $value, $find_url );
				
				
				echo $_url . "<br>";
				
				$ch = curl_init($_url);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$html_content = curl_exec($ch);
				curl_close($ch);
		





						/******** START LOOP **********/
								//$pattern ='#play.jhtml\?id=(.*)\"#i';
								$pattern ="#popplayer\(1\,0\,\'?(.*?)\'#i";
								preg_match_all($pattern, $html_content, $matches);
								print_r($matches);
								$_frontline_show_id = $matches[1][0];
		
		
		

		
								//** INSERT SEGMENTS **//
								$_frontline_request_str = str_replace("__ID__", $_frontline_show_id ,$_xml_request_base);
								
						
	
								$ch = curl_init($_xml_request_url);
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
								curl_setopt($ch, CURLOPT_HEADER, 0);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt ($ch, CURLOPT_POSTFIELDS, $_frontline_request_str);
								$html_content = curl_exec($ch);
								curl_close($ch);

								echo $html_content;
								//die();
								
							
								//$html_content = iconv("ISO-8859-1", "ISO-8859-1//IGNORE", $html_content);
								//$html_content =preg_replace('/[^\ -z]/', '', $html_content);
								$html_content =preg_replace('/\&/', '', $html_content);
								
								
								
								
								$xml2 = simplexml_load_string($html_content);

		
								echo "FOUND EPISODES: " . count($xml2) . "<br>";
	
		
								if (count($xml2) > 0 )
								{ 
		
									//dont do this for the multi part
									if ($_id != $_old_id) {
										echo "INSERT ON FIRST PASS";
						
										$sql = array (
											"batch_id" 		=> 	$_batch_id,
											"video_id"	 	=>	$_video_id,
											"org_video_id"	=>	$_id,
											"parent_id"		=> 	$_parent_id,
											"has_children"	=>	1,
											"source_id"		=>	$_source_id,
											"show_id"		=> 	$_show_id,	
											"title"			=> 	$item->title,	
											"detail"		=>	$item->description,	
											"url_source" 	=>	"",
											"url_link"		=> 	$_link,	
											"thumb" 		=>	$xml2->ditem[0]->attributes()->tmb,
											"date_added"	=>	date("Y-m-d G:i:s"),
											"date_pub"		=> 	_normaliseDate($item->pubDate)

											);
	
										//echo $item->title . "<br/>";

										$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);
										//echo $nSQL; 
									
						
										DB::query($nSQL , false);
										$rCount++;	
									
									}

									$_parent_id = $_video_id;
										

		
								foreach ($xml2->ditem as $item)
								{
		
									$_segment_id =  DB::UUID();


	
									$sql = array (
										"batch_id" 		=> 	$_batch_id,
										"video_id"	 	=>	$_segment_id,
										"org_video_id"	=>	$_id,
										"parent_id"		=> 	$_parent_id,
										"parent_order_by" => $_parent_order_by,
										"source_id"		=>	$_source_id,
										"show_id"		=> 	$_show_id,	
										"title"			=> 	$item->tit,	
										"detail"		=>	$item->dsc,	
										"url_source" 	=>	$_video_base_url . $item->attributes()->src,
										"url_link"		=> 	"",	
										"thumb" 		=>	$item->attributes()->tmb,
										"date_added"	=>	date("Y-m-d G:i:s")

										);
		

									echo "ADDED: " . $item->tit . "<br/>";


									$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

									DB::query($nSQL , false);


									$rCount++;	
									$_parent_order_by++;			
			
			
								}
				
							}
		
							$_old_id = $_id;
						/******** END LOOP **********/


			}
				

		
}
	
	
	//if ($i > 7 ) die();
	$_old_id = "some_more_junk";
	
$i++;
	
}



?>




