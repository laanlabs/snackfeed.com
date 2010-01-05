<?

$win_title = "Trends List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM trends
	ORDER BY rank DESC, date_updated DESC;";
$q = DB::query($sql);



  

?>