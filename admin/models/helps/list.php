<?

$win_title = "Invite Code List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM helps
	ORDER BY controller ASC;";
$q = DB::query($sql);



  

?> 