<?



//clear list
$_package_id = $_POST['_package_id'];
$sql = "DELETE FROM package_shows WHERE package_id = '" . $_package_id . "'";
DB::query($sql , false);




foreach ($_POST['_show_ids'] as $_show_id)
{
	
	
		//echo $_show_id ."<br/>";
		$sql = "INSERT INTO  package_shows SET 
				package_id = '" . $_package_id . "',
				show_id = '" . $_show_id . "'";
		DB::query($sql , false);
		
	
}


header("Location: /?a=shows.packages");


?>