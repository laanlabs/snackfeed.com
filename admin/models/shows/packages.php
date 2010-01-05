<?

$win_title = "Packages List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM packages 
	ORDER BY name, order_by ;";
	
$q = DB::query($sql);



  

?>