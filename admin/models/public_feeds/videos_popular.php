<?


$rowcount = 0;





		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-30,date("Y")) );
		$sql = "SELECT count(uv.video_id) as video_count,
		v.video_id, v.title, v.detail, v.thumb, v.show_id
		FROM user_videos uv 
			JOIN videos v ON uv.video_id = v.video_id AND v.date_added > '{$_date}'	
		GROUP BY uv.video_id
		ORDER BY video_count DESC
		LIMIT 1
			";
		
		$q1 = DB::query($sql);
		
		echo count($q1);
		
		

		

		foreach ($q1 as $r)
		{
			
			$_order_by_var = $orderCount;	
			echo "VIDEO: " . $r['title'] . " - " . $r['video_count']   . "<br>";	
	
	
			$_title = addslashes($r['title']);
			$_detail = addslashes($r['detail']);
			$_date = date("Y-m-d G:i:s");	
			
			$sql = "
				INSERT INTO feed_publics SET  
				video_id = '{$r['video_id']}',
				show_id = '{$r['show_id'] }',
				title = '{$_title}',
				detail = '{$_detail}',
				thumb = '{$r['thumb']}',
				date_added = '{$_date}',
				type = 3,
				comment = '{$r['video_count']} likes',
				weight = 50

				
				ON DUPLICATE KEY UPDATE comment = '{$r['video_count']} likes'	
				;";		
		

			$orderCount++;
			DB::query($sql, false);
			
		}	
		
		
		
		
		
die();

?>