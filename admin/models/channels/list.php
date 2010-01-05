<?


$win_title = "Channels List";

$rowcount = 0;
$sql = " SELECT * ";
$sql .= " FROM channels ";
$sql .= " ORDER BY order_by, title DESC;";
$q = DB::query($sql);



?>