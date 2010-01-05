<?
$key_table = "message";


$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}



//remove the values that dont belong in core post
$_r_user_ids = $_POST["_r_user_ids"];
unset($_POST["_video_title"]);
unset($_POST["_r_user_ids"]);


//empty receipents table
	$sql = "
		DELETE FROM message_users WHERE  
		message_id = '" . $_POST['_' .$key_table .'_id']. "'
		;";		

	DB::query($sql, false);


foreach($_r_user_ids as $_r_user_id)
{

	
		$sql = "
			INSERT INTO message_users SET  
			user_id = '" . $_r_user_id . "',
			message_id = '" . $_POST['_' .$key_table .'_id']. "'
		;";		
	
		DB::query($sql, false);
		
	
	
}





include LIB."/calls/db_submit.php";



header("Location: /?a=users.list");






?>