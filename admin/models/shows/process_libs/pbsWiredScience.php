<?
	$_base_url ="http://www.pbs.org";
	$_location_base = "/kcet/wiredscience/video/";
	$_flv_url = "http://www.pbs.org/kcet/wiredscience/assets/video/__ID__.flv";

	$_episode_url = "http://www.pbs.org/kcet/wiredscience/video/filter?pge=1&filter=0&order=&id=undefined&featured_id=undefined&episode=";

	$_episode_list_url = "http://www.pbs.org/kcet/wiredscience/video/";

   	$ch = curl_init($_episode_list_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);
	curl_close($ch);



	//GET THE ALL ALAILABLE EPISODEDS FROM THE FILTER LIST
	$pattern ='#Filter.by.Episode(.*?)\<\/select#is';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches);
	$tmp = $matches[1][0];
	

	
	//GET THE ALL ALAILABLE EPISODEDS FROM THE FILTER LIST
	$pattern ='#option.value=\"(.*?[0-9])\"#i';
	preg_match_all($pattern, $tmp, $matches);
	//print_r($matches);

	for ($j=0; $j < count($matches[0]); $j++)
	{

		$_episode_id = $matches[1][$j];
		echo "GET FILTER FOR EPISODE: " . $_episode_id . "<br>";



	 	$ch = curl_init($_episode_url . $_episode_id);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);


		$pattern ='#<a.href=\"(.*?)\"><img.src=\"(.*?)\".alt="(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches2);
		//print_r($matches2);
		
		for ($i=0; $i < count($matches2[0]); $i++)
		{
			
	
				$_thumb = $matches2[2][$i];
				$_id = str_replace(".jpg", "", end(explode("-", $_thumb)) );
				
				$_flv = str_replace("__ID__", $_id, $_flv_url);
				
				echo $_flv;
				
		
				//1 url
				//2 thumb
				//3 title
	
	
	
				$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
				$q = DB::query($sql);

				if (!$q[0]["org_video_id"]) 
				{


					//echo "NOT FOUND MAKE ENTRY";

					$_video_id =  DB::UUID();
					$_parent_id = 0;


					$sql = array (
						"batch_id" 		=> 	$_batch_id,
						"video_id"	 	=>	$_video_id,
						"org_video_id"	=>	$_id,
						"parent_id"		=> 	$_parent_id,
						"source_id"		=>	$_source_id,
						"show_id"		=> 	$_show_id,	
						"title"			=> 	$_episode_id . ": " . $matches2[3][$i],	
						"detail"		=>	"EPISODE: " . $_episode_id,	
						"url_source" 	=>	$_flv,
						"url_link"		=> 	$_base_url . $matches2[1][$i],	
						"thumb" 		=>	$_base_url . $matches2[2][$i],
						"date_added"	=>	date("Y-m-d G:i:s"),
						"date_pub"		=>	date("Y-m-d G:i:s"),
						"order_by"		=> $_episode_id*1000 + $i
						);

					$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

					DB::query($nSQL , false);
					$rCount++;


				}
	
			
		}		
		



	}


die();
?>