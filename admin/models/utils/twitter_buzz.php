<?


$_t ="empty";

$_date = date("Y-m-d G:i:s");



$json_url = "http://search.twitter.com/trends.json";

echo $json_url . "<br/>";

$ch = curl_init ($json_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$json_data = curl_exec($ch);
curl_close ($ch);


$obj = json_decode($json_data);

// var_dump( "<pre>" , $obj , "</pre>" );
 

foreach ($obj->trends as $trends) {
	
	
	echo $_term = addslashes($trends->name);
	
	//insert this video so it doesn get redon
	$sql = "INSERT INTO trends SET 
		term = '{$_term}', 
		date_added = '{$_date}',  
		date_updated = '{$_date}'
		
		ON DUPLICATE KEY UPDATE count = count+1, date_updated = '{$_date}'
		";
		
		//echo $sql;
		
		DB::query($sql, false);	
	
	
	
}	 
 
 ?>