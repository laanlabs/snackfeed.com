<?

	require_once LIB. "/Stats.php";

$s = new Math_Stats();
$count_array = array();
$_max_index = 0;

$sql = " SELECT DISTINCT show_id, title, popularity, popularity_temp, '' as new_index
 	FROM shows 
	LIMIT 500  ;";
$show_array = DB::query($sql);


for ($i=0; $i < count($show_array) ; $i++) 
{ 
	
	$count_array[$i] = $show_array[$i]['popularity_temp'];
	if ( $show_array[$i]['popularity_temp'] > $_max_index ) $_max_index = $show_array[$i]['popularity_temp'];
	
}	


echo "<h1>corrected index values</h1>";


print_r($count_array);
$s->setData($count_array);


print_r($s->quartiles());
$_tmp = $s->quartiles();
$_ciel = $_tmp['25'];

echo "<table>";

for ($i=0; $i < count($show_array) ; $i++) 
{ 
	
	echo "<tr><td>: " . $show_array[$i]['title'] . "</td><td>";

		$_index = round(($show_array[$i]['popularity_temp'] / $_max_index)*100);		
	


	echo "" .  $_index . "</td></tr>";
	
	
	$sql = " UPDATE shows
			SET popularity = '{$_index}'
	 		WHERE show_id = '{$show_array[$i]['show_id'] }'
		 ;";
	 DB::query($sql, false);
	
	
	
}

echo "</table>";


die();

?>