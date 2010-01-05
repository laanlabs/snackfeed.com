<?



//clear list
$_channel_id = $_POST['_channel_id'];
$sql = "DELETE FROM channel_users WHERE channel_id = '" . $_channel_id . "'";
DB::query($sql , false);




foreach ($_POST['_user_ids'] as $_user_id)
{
	
	$_role = $_POST["_role_".$_user_id];
	$_status = $_POST["_status_".$_user_id];
	
		//echo $_user_id ."<br/>";
		$sql = "INSERT INTO  channel_users SET 
				user_id = '" . $_user_id . "',
				role = {$_role},
				status = {$_status},
				channel_id = '" . $_channel_id . "'";
		DB::query($sql , false);
		
	
}


header("Location: /?a=channels.list");


?>