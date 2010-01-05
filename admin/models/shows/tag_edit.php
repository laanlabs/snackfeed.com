<?

$_base_table = "tag";

include LIB."/calls/db_edit.php";


$sql = " SELECT  *  FROM tags WHERE parent_id = '0' AND tag_id != '{$_tag_id}' ";
$q1 = DB::query($sql);

$sql = " SELECT  *  FROM lkp_tag_type ORDER BY tag_type_id ";
$q2 = DB::query($sql);




?>