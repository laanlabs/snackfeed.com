<?

$_base_table = "show";

include LIB."/calls/db_edit.php";



$sql = " SELECT source_id, name 
 FROM sources 
 ORDER BY name; ";
$q1 = DB::query($sql);

$sql = " SELECT air_status_id, air_status 
 FROM lkp_air_status 
 ORDER BY air_status_id; ";
$q2 = DB::query($sql);

$sql = " SELECT * 
 FROM lkp_show_process_type 
 ORDER BY show_process_type_id; ";
$q3 = DB::query($sql);

$sql = " SELECT * 
 	FROM lkp_show_type 
 	ORDER BY show_type_id; ";
$q4 = DB::query($sql);




?>