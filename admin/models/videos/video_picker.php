<?

$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name ";
$sql .= " FROM shows s, sources sc ";
$sql .= " WHERE s.source_id = sc.source_id ";
$sql .= " ORDER BY s.title ASC;";
$q1 = DB::query($sql);


$_show_id =  empty($_REQUEST["show_id"]) ? $q1[0]['show_id'] : $_REQUEST["show_id"] ;

$sql = " SELECT DISTINCT v.video_id, v.title, v.detail 
	FROM videos v 
 	WHERE v.show_id = '" . $_show_id . "'
	AND v.parent_id = 0	
 	ORDER BY date_added DESC;
";
$q = DB::query($sql);
//echo $sql;



?>