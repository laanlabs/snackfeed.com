<?

$win_title = "Recommended Videos List";


$sql = " SELECT DISTINCT r.*, v.video_id, v.title, v.url_source, v.thumb, v.use_embedded, s.title as seg_title
 	FROM videos v  JOIN recommendation_videos r ON  v.video_id = r.video_id 
	 LEFT OUTER JOIN segmentations s ON r.segmentation_id = s.segmentation_id
 	WHERE 1
	
 	ORDER BY  r.date_added DESC;";

$q = DB::query($sql);

//echo $sql;

  

?>