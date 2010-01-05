<?



//clear list
$_channel_id = $_POST['_channel_id'];
$sql = "DELETE FROM channel_tags WHERE channel_id = '{$_channel_id}'";
DB::query($sql , false);




foreach ($_POST['_tag_ids'] as $_tag_id)
{

$_weight = $_POST["_tag_weight_".$_tag_id];
	
	
		//echo $_channel_id ."<br/>";
		$sql = "INSERT INTO  channel_tags SET 
				channel_id = '{$_channel_id}',
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