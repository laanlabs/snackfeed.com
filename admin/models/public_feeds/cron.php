<?

$_t = "empty";

$rowcount = 0;
$_date = date("Y-m-d G:i:s");


$sql = " 
 SELECT p.*, s.title,  s.thumb
 FROM feed_programs p
	INNER JOIN shows s ON s.show_id = p.show_id
 ORDER BY p.order_by DESC;";
$q = DB::query($sql);


$orderCount = 1;

foreach ($q as $r) 
{

echo "PROCESSING: " . $r['title'] . "<br>";


		//get videos based on show or
		//if(@a, @a:=@a+1, @a:=0) for row NUM in sql does not work in mysql with an orderby
		// so the inserts need to be done procedurely

		$sql = " SELECT DISTINCT  v.video_id, v.show_id, v.title, v.detail, v.thumb, v.date_pub, v.date_added, UNIX_TIMESTAMP(v.date_pub) as uDate 
				FROM videos v
				WHERE v.show_id = '{$r['show_id'] }'
				AND v.parent_id = '0'
				AND v.video_type_id in ({$r['video_type_ids']})
		 		ORDER BY date_added DESC, order_by 
		 		LIMIT  {$r['video_count']} " ;
		echo $sql.  "<br>";
		$q1 = DB::query($sql);	
		
		echo count($q1);
		
		
		
		

		foreach ($q1 as $r)
		{
			
			$_order_by_var = $orderCount;	
			echo "DATE: " . $r['uDate'] .  "<br>";	
	
	
			$_title = addslashes($r['title']);
			$_detail = addslashes($r['detail']);	
			
			$sql = "
				INSERT INTO feed_publics SET  
				video_id = '{$r['video_id']}',
				show_id = '{$r['show_id'] }',
				title = '{$_title}',
				detail = '{$_detail}',
				thumb = '{$r['thumb']}',
				date_added = '{$r['date_added']}',
				type = 1,
				weight = 50

				
				ON DUPLICATE KEY UPDATE comment = comment	
				;";		
		

			$orderCount++;
			DB::query($sql, false);
			
		}	
		
		
		
		
		

	
	
	$orderCount++;
	
 
	//echo $orderCount.  "<br>";


}


$orderCount++;










?>