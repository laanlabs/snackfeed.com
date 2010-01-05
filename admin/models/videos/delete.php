<?

$sql = "DELETE FROM videos  
	WHERE video_id = '" . $_REQUEST['video_id'] . "'";

DB::query($sql , false);

$sql = "DELETE FROM videos  
	WHERE parent_id = '" . $_REQUEST['video_id'] . "'";

DB::query($sql , false);



header("Location: /?a=videos.list&show_id=" . $_REQUEST['show_id'] . "&channel_id=" . $_REQUEST['channel_id']);
?>