<?


$sql = " SELECT DISTINCT show_id, title, popularity, '' as new_pop, '' as new_index
 	FROM shows 
	LIMIT 500  ;";
$show_array = DB::query($sql);


echo "asdfds" . array_key_exists('house', $show_array);

//die();


$_url = "http://www.sidereel.com/_index/television";


$ch = curl_init($_url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$html_content = curl_exec($ch); 
curl_close($ch); 

//echo $html_content;

/*
<li>                            <a href="/55_Degrees_North">55 Degrees North</a>
                                                        <span class="linkCount"> (18 links)</span>
                                                    </li>
                                                <li>
*/




$pattern ='#<\/li>\s*<li>\s*<a\s*href=\"\/(.*?)\">(.*?)<\/a>\s*<span\s*class=\"linkCount\">\s*\(\s*([0-9]*?)\s*links\)<\/span>#is';
preg_match_all($pattern, $html_content, $matches);
//print_r($matches);

echo "<table>";

for ($i=0; $i <  count($matches[1]); $i++) { 
	
	echo "<tr><td>";
	
	
		$_title = $matches[1][$i];
		$_title = str_replace("_", " ", $_title );
		$_title = urldecode($_title);
		$_title = strtolower($_title);
	
		echo $_title;
		
		echo "</td><td>";
	

for ($j=0; $j < count($show_array) ; $j++) { 
		$_title2 = strtolower($show_array[$j]['title']);
	
	
		if ($_title == $_title2)
		{
			
			echo "found";
			$sql = " UPDATE shows
					SET popularity_temp = '{$matches[3][$i]}'
			 		WHERE show_id = '{$show_array[$j]['show_id'] }'
				 ;";
			echo $sql; 

			DB::query($sql, false);
		}
	
	
}

	
		echo "</td><td>";
		
			echo $matches[3][$i];
		echo "</td></tr>";	
	
}

echo "</table>";
die();


?>