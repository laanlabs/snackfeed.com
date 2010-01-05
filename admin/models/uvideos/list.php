<?

$win_title = "Users Videos List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM uvideos 
	ORDER BY date_created DESC;";
$q = DB::query($sql);



  

?>