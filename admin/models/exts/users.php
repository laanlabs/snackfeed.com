<?


$win_title = "Users Accounts For: ";

$_ext_id = $_REQUEST['ext_id'];

$rowcount = 0;
$sql = " SELECT u.*, e.*
		 FROM ext_users e
		 LEFT OUTER JOIN users u ON u.user_id = e.user_id
			
		 WHERE 1
			AND e.ext_id = '{$_ext_id}'	 
		 ORDER BY u.email;";
$q = DB::query($sql);



?>