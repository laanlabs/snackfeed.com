<?

$win_title = "Sources List";

$rowcount = 0;
$sql = " SELECT source_id, name, detail ";
$sql .= " FROM sources ";
$sql .= " ORDER BY name; ";
$q = DB::query($sql);



  

?>