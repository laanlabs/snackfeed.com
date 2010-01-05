<?


$limit= isset($_REQUEST['limit']) ? $_REQUEST['limit'] : '2000';
$_offset= isset($_REQUEST['o']) ? $_REQUEST['o'] : '0';
$_page_size = 25;


$rowcount = 0;
$sql = " SELECT DISTINCT n.* 
 	FROM newsletters n
 	WHERE 1
	ORDER BY email ASC 
	LIMIT {$_page_size} OFFSET {$_offset} ;";
$q = DB::query($sql);

for ($i=0; $i < count($q) ; $i++) { 
	echo $q[$i]['email'] . ",";
}

  die();

?>

