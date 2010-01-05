<?


$sql = "DELETE FROM groups  
	WHERE group_id = '${_REQUEST['group_id']}'";

DB::query($sql , false);



header("Location: /?a=groups.list");


?>