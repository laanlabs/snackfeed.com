<?


$win_title = "Blogs List";

$rowcount = 0;
$sql = " SELECT * ";
$sql .= " FROM blogs ";
$sql .= " ORDER BY order_by, title DESC;";
$q = DB::query($sql);



?>