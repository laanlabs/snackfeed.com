<?

	$_base_url ="http://www.pbs.org";

	$_episode_list_url = "http://www.pbs.org/moyers/journal/archives/archives.php";

// get the first two pages of the archives
	$ch = curl_init($_episode_list_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content = curl_exec($ch);
	curl_close($ch);

/*
	$ch = curl_init($_episode_list_url . "?start=20");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$html_content .= curl_exec($ch);
	curl_close($ch);
*/	
	
	//GET THE ALL ALAILABLE EPISODEDS FROM THE FILTER LIST
	$pattern ='#class=\"atitle\">(.*?)<\/a><br>(.*?)<br>(.*?)images\/video_icon\.gif(.*?)\/moyers\/journal\/(.*?)\.html#is';
	preg_match_all($pattern, $html_content, $matches);
	//print_r($matches);	
	
	
	
	for ($j=0; $j < count($matches[0]); $j++)
	{
	 $_id = $matches[5][$j];	

	//make date from id
	
	$dtmp = explode("/", $_id);
	$_month = substr($dtmp[0], 0, 2);
	$_day = substr($dtmp[0], 2, 2);
	$_year = substr($dtmp[0], 4, 4);
	
	$_date=  $_year . "-" . $_month . "-" . $_day;
	echo $_date;


	$sql = "SELECT org_video_id FROM videos WHERE org_video_id = '" . $_id ."' AND show_id = '" . $_show_id . "';";		
	$q = DB::query($sql);
	
	if (!$q[0]["org_video_id"]) 
	{
		//echo "NOT FOUND MAKE ENTRY";
	
		$_video_id =  DB::UUID();
		$_parent_id = 0;

		
	 	$_page_url = $_base_url .	"/moyers/journal/" . $_id . ".html";
		echo $_page_url ."<br>";
		
		$ch = curl_init($_page_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html_content = curl_exec($ch);
		curl_close($ch);

		//GET THE ALL ALAILABLE EPISODEDS FROM THE FILTER LIST
		$pattern ='#so\.addVariable\(\"file\",\s*\"(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches2);
		//print_r($matches2);
		$_flv = $_base_url . $matches2[1][0];
		
		//GET THE ALL ALAILABLE EPISODEDS FROM THE FILTER LIST
		$pattern ='#so\.addVariable\(\"image\",\s*\"(.*?)\"#i';
		preg_match_all($pattern, $html_content, $matches2);
		//print_r($matches2);
		$_thumb = $_base_url . $matches2[1][0];	
		
					$sql = array (
						"batch_id" 		=> 	$_batch_id,
						"video_id"	 	=>	$_video_id,
						"org_video_id"	=>	$_id,
						"parent_id"		=> 	$_parent_id,
						"source_id"		=>	$_source_id,
						"show_id"		=> 	$_show_id,	
						"title"			=> 	$matches[1][$j],	
						"detail"		=>	$matches[2][$j],	
						"url_source" 	=>	$_flv,
						"url_link"		=> 	$_page_url,	
						"thumb" 		=>	$_thumb,
						"date_added"	=>	$_date,
						"date_pub"	=>	$_date,
						"order_by"		=>  $j
						);

					$nSQL = "INSERT INTO videos SET " . DB::assoc_to_sql_str($sql);

					DB::query($nSQL , false);
					$rCount++;

		//1 title
		//2 desc


	}

		
	}	
	
	




?>

