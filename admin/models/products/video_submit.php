<?

$sql =  array();
while (list($key,$value) = each($_POST))
{
	$sql[ltrim($key,"_")] = $value;
}


$nSQL = "INSERT INTO video_products SET " . DB::assoc_to_sql_str($sql);


DB::query($nSQL , false);


?>

<script>
	window.close();
</script>

<? die(); ?>