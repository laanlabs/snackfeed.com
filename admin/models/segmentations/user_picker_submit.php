<?



//clear list
$_user_id = $_POST['_user_id'];
$sql = "DELETE FROM user_segmentations WHERE user_id = '{$_user_id}'";
DB::query($sql , false);




foreach ($_POST['_segmentation_ids'] as $_segmentation_id)
{

$_weight = $_POST["_segmentation_weight_".$_segmentation_id];
	
	
		//echo $_show_id ."<br/>";
		$sql = "INSERT INTO  user_segmentations SET 
				user_id = '{$_user_id}',
				segmentation_id 	= '{$_segmentation_id}',
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