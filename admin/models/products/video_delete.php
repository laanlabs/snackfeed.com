<?


$nSQL = "DELETE FROM  video_products WHERE id = '" . $_REQUEST['id'] . "';";


DB::query($nSQL , false);


header("Location: /?t=picker&a=products.video&video_id=" . $_REQUEST['video_id']);

?>

