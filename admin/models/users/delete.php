<?


$sql = "DELETE FROM users  
	WHERE user_id = '${_REQUEST['user_id']}'";

DB::query($sql , false);



header("Location: /?a=users.list");


?>