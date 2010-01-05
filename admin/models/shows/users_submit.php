<?



//clear list
$_show_id = $_POST['_show_id'];
$sql = "DELETE FROM show_users WHERE show_id = '" . $_show_id . "'";
DB::query($sql , false);




foreach ($_POST['_user_ids'] as $_user_id)
{
	
	
		//echo $_user_id ."<br/>";
		$sql = "INSERT INTO  show_users SET 
				user_id = '" . $_user_id . "',
				show_id = '" . $_show_id . "'";
		DB::query($sql , false);
		
	
}
?>

<script>
	window.close();
</script>

<? die(); ?>


