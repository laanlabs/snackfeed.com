<?

$win_title = "Users Shows List";

$rowcount = 0;
$sql = " SELECT u.user_id, u.email, u.name_first, u.name_last, cu.user_id as cu_user_id
 	FROM users u LEFT OUTER JOIN show_users cu ON u.user_id = cu.user_id AND cu.show_id = '{$_REQUEST['show_id']}'
	ORDER BY email, name_last, name_first ASC;";
$q = DB::query($sql);



  

?>