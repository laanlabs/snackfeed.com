<?

$win_title = "Users Channels List";

$rowcount = 0;
$sql = " SELECT u.user_id, u.email, u.name_first, u.name_last, cu.user_id as cu_user_id, cu.role, cu.status
 	FROM users u LEFT OUTER JOIN channel_users cu ON u.user_id = cu.user_id AND cu.channel_id = '{$_REQUEST['channel_id']}'
	ORDER BY email, name_last, name_first ASC;";
$q = DB::query($sql);



  

?>