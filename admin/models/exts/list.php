<?


$win_title = "External Sources List";

$rowcount = 0;
$sql = " SELECT e.*, s.name as source_name 
		 FROM exts e
		 LEFT OUTER JOIN sources s ON e.source_id = s.source_id
		 WHERE 1
		 
		 ORDER BY name;";
$q = DB::query($sql);



?>