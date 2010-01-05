<?




 $_REQUEST["video_id"] ;

$sql = " SELECT  *
	FROM video_products  
 	WHERE video_id = '{$_REQUEST["video_id"]}'
 	ORDER BY date_added DESC;
";
$q = DB::query($sql);
//echo $sql;



?>