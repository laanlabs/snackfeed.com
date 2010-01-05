<?

$_feed_program_id = isset($_REQUEST['feed_program_id']) ? $_REQUEST['feed_program_id'] : '0';





$win_title = "Programs Edit for Public Feed: " ;

$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name 
 FROM shows s LEFT OUTER JOIN sources sc ON s.source_id = sc.source_id
 WHERE 1 
 ORDER BY s.title, s.order_by, s.title DESC;";
$q2 = DB::query($sql);


$_base_table = "feed_program";

include LIB."/calls/db_edit.php";


?>