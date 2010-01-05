<?

$win_title = "Videos List";


$sql = " SELECT DISTINCT v.video_id, v.title, v.url_source, v.thumb, v.date_added, v.date_pub, v.use_embedded
 	FROM videos v LEFT OUTER JOIN sources s ON  v.source_id = s.source_id 
 	WHERE v.show_id = '{$_REQUEST["show_id"]}'
	 AND v.parent_id = '0'
 	ORDER BY v.date_pub DESC, v.date_added DESC
 	LIMIT 500;";

$q = DB::query($sql);

//echo $sql;

  

?>