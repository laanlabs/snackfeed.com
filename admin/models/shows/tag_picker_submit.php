<?



//clear list
$_show_id = $_POST['_show_id'];
$sql = "DELETE FROM show_tags WHERE show_id = '{$_show_id}'";
DB::query($sql , false);




foreach ($_POST['_tag_ids'] as $_tag_id)
{

$_weight = $_POST["_tag_weight_".$_tag_id];
	
	
		//echo $_show_id ."<br/>";
		$sql = "INSERT INTO  show_tags SET 
				show_id = '{$_show_id}',
				tag_id 	= '{$_tag_id}',
				weight 	= '{$_weight}'
				";
		
		echo $sql;
		
		DB::query($sql , false);
		
	
}








?>

<script>
	window.close();
</script>

<? die(); ?>