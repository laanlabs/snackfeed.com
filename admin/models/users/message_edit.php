<?

$_base_table = "message";

include LIB."/calls/db_edit.php";

//override vars
$_user_id = $_GET['user_id'];



$sql = " SELECT *,(SELECT COUNT(*) FROM message_users 
			WHERE message_users.user_id = users.user_id 
			AND message_users.message_id = '" . $_message_id ."'
			) AS count 
	FROM users 
	ORDER BY email";

$q1 = DB::query($sql);




//get video title
$sql = " SELECT title 
	FROM videos 
	WHERE video_id = '" . $_video_id . "'";

$q2 = DB::query($sql);

$_video_title = $q2[0]['title'];

?>