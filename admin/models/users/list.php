<?


$_offset= isset($_REQUEST['o']) ? $_REQUEST['o'] : '0';
$_page_size = 25;


$conditions = "";
if ( !empty($_REQUEST['_filter']) )  $conditions .= "AND (u.nickname LIKE '%{$_REQUEST['_filter']}%' OR  u.email LIKE '%{$_REQUEST['_filter']}%')"; 






$win_title = "Users List";

$rowcount = 0;
$sql = " SELECT u.* 
 	FROM users u
 	WHERE 1
	{$conditions}
	ORDER BY nickname ASC
	LIMIT {$_page_size} OFFSET {$_offset} ;";
$q = DB::query($sql);



  

?>