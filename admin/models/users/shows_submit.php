<?



//clear list
$_user_id = $_POST['_user_id'];
$sql = "DELETE FROM user_shows WHERE user_id = '" . $_user_id . "'";
DB::query($sql , false);




foreach ($_POST['_show_ids'] as $_show_id)
{
	
	
		//echo $_show_id ."<br/>";
		$sql = "INSERT INTO  user_shows SET 
				user_id = '" . $_user_id . "',
				show_id = '" . $_show_id . "'";
		DB::query($sql , false);
		
	
}


header("Location: /?a=users.list");


?>