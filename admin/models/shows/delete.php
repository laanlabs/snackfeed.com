<?

$_show_id = $_REQUEST['show_id'];
$sql = "DELETE FROM shows  
	WHERE show_id = '" . $_show_id . "'";

DB::query($sql , false);


$sql = "DELETE FROM videos  
	WHERE show_id = '" . $_show_id . "'";

DB::query($sql , false);




header("Location: /?a=shows.list");


?>