<?

	require_once LIB. "/Stats.php";

	$s = new Math_Stats();
	$count_array = array();	
	

	$_url = "http://www.google.com/search?hl=en&q=%22__SEARCH__%22+site%3Asidereel.com&btnG=Search";
	//$_url = "http://search.yahoo.com/search;_ylt=A0geu6638tFHLX4BkgWl87Ug?p=%22__SEARCH__%22+site%3Atv.com&y=Search&fr=yfp-t-501&ei=UTF-8";
	$_url = "http://www.alexa.com/search?q=%22__SEARCH__%22+site%3Atv.com";

	$_max_index = 0;
	$_min_index = 0;


	$sql = " SELECT DISTINCT show_id, title, popularity, '' as new_pop, '' as new_index
	 	FROM shows 
		LIMIT 500  ;";
	$show_array = DB::query($sql);





	for ($i=0; $i < count($show_array) ; $i++) { 

		echo "SHOW: " . $show_array[$i]['title'] . "<br/>";
		

	$_title = urlencode($show_array[$i]['title']);
		
	$_search_url = str_replace("__SEARCH__", $_title, $_url );


	$ch = curl_init($_search_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


  $html_content = curl_exec($ch); // execute the curl command
  curl_close($ch); // close the connection
	
//	echo $html_content;
	
	
		//</b> of about <b>566</b>
	//<p>1 - 10 of 23,200 from
	
		$pattern ='#<\/b>\s*of\s*about\s*<b>(.*?)<\/b>#i';
		$pattern ='#<\/strong>\s*of\s*about\s*<strong>(.*?)<\/#is';
		preg_match_all($pattern, $html_content, $matches);
		//print_r($matches);
	
		$_total_results = str_replace(",", "" , $matches[1][0]);
		$show_array[$i]['new_pop'] = $_total_results;
		
		$count_array[$i] = $_total_results;
		
	
		
	
		echo "TOTAL RESULTS: " .  $_total_results . "<br>";
		
		
		$sql = " UPDATE shows
				SET popularity_temp = '{$_total_results}'
		 		WHERE show_id = '{$show_array[$i]['show_id'] }'
			 ;";
		echo $sql; 
		
		DB::query($sql, false);	
		
		echo "<hr/>";
		
	}

	echo "<h1>corrected index values</h1>";


	//print_r($count_array);
	$s->setData($count_array);

	
	print_r($s->quartiles());
	$_tmp = $s->quartiles();
	$_ciel = $_tmp['25'];






	
	
	die();



?>