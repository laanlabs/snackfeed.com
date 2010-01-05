<?


$sql = " DELETE
 	FROM channel_videos 
 	WHERE video_id in (SELECT video_id from videos WHERE show_id =  '{$_REQUEST["show_id"]}' );";

echo $sql;

$q = DB::query($sql, false);


$sql = " DELETE
 	FROM videos 
 	WHERE show_id = '{$_REQUEST["show_id"]}' 
	;";

echo $sql;

$q = DB::query($sql, false);








?>

<a href="javascript:window.close()">done</a>


<?die();  ?>