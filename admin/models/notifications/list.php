<?

$win_title = "Notifications List";


$sql = " SELECT *
		FROM notifications
 		ORDER BY  date_start DESC;";

$q = DB::query($sql);

//echo $sql;
?>
  
