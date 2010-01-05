<?

$_user_id = $_REQUEST['user_id'];

$win_title = "Message List";

$rowcount = 0;
$sql = " SELECT m.* , u.email 
 	FROM messages m, users u
	WHERE m.message_id in (SELECT message_id FROM message_users where user_id = '" . $_user_id ."')
	AND m.user_id = u.user_id
	ORDER BY m.date_added DESC;";

$q = DB::query($sql);

?>