<?

$_program_id = isset($_REQUEST['program_id']) ? $_REQUEST['program_id'] : '0';
$_channel_id =  $_REQUEST['channel_id'];

$sql = " SELECT title 
 FROM channels 
 WHERE channel_id = '{$_channel_id}';";
$q = DB::query($sql);




$win_title = "Programs Edit for Channel: " . $q[0]['title'] ;

$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name 
 FROM shows s LEFT OUTER JOIN sources sc ON s.source_id = sc.source_id
 WHERE 1 
 ORDER BY s.title, s.order_by, s.title DESC;";
$q2 = DB::query($sql);


$_base_table = "program";

include LIB."/calls/db_edit.php";


?>