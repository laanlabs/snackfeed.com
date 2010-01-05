<?


$sql = " DELETE
 	FROM channel_videos 
 	WHERE video_id in (
		SELECT video_id from videos WHERE show_id =  '{$_show_id}' 
		AND (date_expire > '0000-00-00 00:00:00' AND date_expire <  '" . date("Y-m-d G:i:s"). "')
		);";

//echo $sql;

DB::query($sql, false);


$sql = " DELETE
 	FROM videos 
 	WHERE show_id = '{$_show_id}' 
	AND (date_expire > '0000-00-00 00:00:00' AND date_expire <  '" . date("Y-m-d G:i:s"). "');";

//echo $sql;

DB::query($sql, false);








?>