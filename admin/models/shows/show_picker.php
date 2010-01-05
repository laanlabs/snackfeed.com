<?
$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name 
 FROM shows s, sources sc 
 WHERE s.source_id = sc.source_id 
 ORDER BY s.title, s.order_by, s.title DESC;";
$q = DB::query($sql);

?>