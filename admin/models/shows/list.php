<?

$win_title = "Show List";

$_offset= isset($_REQUEST['o']) ? $_REQUEST['o'] : '0';

$_show_type_id = isset($_REQUEST['_show_type_id']) ? $_REQUEST['_show_type_id'] : '1';

$_page_size = 10;


$conditions = "";

if ( !empty($_REQUEST['_source_id']) )  $conditions .= "AND s.source_id = '" . $_REQUEST['_source_id'] . "' "; 
if ( !empty($_REQUEST['_filter']) )  $conditions .= "AND s.title LIKE '%" . $_REQUEST['_filter'] . "%' "; 
$conditions .= "AND s.show_type_id = {$_show_type_id} ";


$rowcount = 0;
$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name 
 	FROM shows s LEFT OUTER JOIN sources sc ON s.source_id = sc.source_id
 	WHERE 1  
	{$conditions}
 	ORDER BY s.title, s.order_by, s.title DESC
	LIMIT {$_page_size} OFFSET {$_offset} ;";
	
//echo $sql;	die();
	
$q = DB::query($sql);




$sql = " SELECT source_id, name, detail 
 	FROM sources 
 	ORDER BY name; ";
$q1 = DB::query($sql);

$sql = " SELECT * 
 	FROM lkp_show_type 
 	ORDER BY show_type_id; ";
$q2 = DB::query($sql);  

?>