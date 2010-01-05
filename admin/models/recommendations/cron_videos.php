<?

//DO THE EVERYONE RECOMMENDATION



$sql = "SELECT * FROM segmentations ORDER BY segmentation_id ";
$segs = DB::query($sql);

for ($i=0; $i < count($segs) ; $i++) { 
	
	$_segmentation_id = $segs[$i]['segmentation_id'];
	
	
	echo "SEGMENT: " . $segs[$i]['title'] . "<br/>";
	//get video for this segment
	$_video_id = "";
	$sql = "SELECT video_id
		FROM recommendation_videos
		WHERE 1
		AND date_added > CURDATE()
		AND segmentation_id = '{$_segmentation_id}'
		AND status = 1
		ORDER BY weight DESC
		LIMIT 1;";

	$q =  DB::query($sql);
	$_video_id = $q[0]['video_id'];

	if (!empty($_video_id))
	{
		
		echo "HAVE VIDS";
		
		
		if ($_segmentation_id != '0')
		{
			$joins = " INNER JOIN user_segmentations us ON u.user_id = us.user_id ";
			$conditions = " AND us.segmentation_id ='{$_segmentation_id}' ";
		}

		
		
		$sql = " INSERT INTO user_updates (user_id, action_id, content_type, content_id, scope, detail, date_added)
			SELECT u.user_id, 4, 0,
			v.video_id as content_id,
			0, CONCAT('recommended video: ',  v.title), now() as date_added
			FROM users u
				  LEFT OUTER JOIN  videos v on v.video_id = '{$_video_id}'
				{$joins}
			WHERE 1
			{$conditions}
			";
		$q2 =  DB::query($sql, false);
		
		
		
			$sql = "UPDATE  recommendation_videos
			SET status = 0
			WHERE video_id = '{$_video_id}'
			AND segmentation_id = '{$_segmentation_id}'";

			$q3 =  DB::query($sql, false);
		
		
		
	} else {
		
		echo "NO VIDEOS <br/>";
	}
	
	
	
	
	
	echo "<hr/>";
	
}







echo "cron ran";


die();

?>