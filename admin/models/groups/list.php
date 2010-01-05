<?

$win_title = "Group Watch List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM groups
	ORDER BY date_created DESC;";
$q = DB::query($sql);



  

?>