<?
//delete the video list for this channel

$_t = "empty";

$_channel_id = $_REQUEST['channel_id'];

$rowcount = 0;
$sql = " SELECT  * FROM channels WHERE channel_id = '{$_channel_id }';";
$q = DB::query($sql);

foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = $field_value;
}




$sql = " 
 SELECT p.*, s.title,  s.thumb
 FROM programs p
	INNER JOIN shows s ON s.show_id = p.show_id
 WHERE p.channel_id = '{$_channel_id}'
 ORDER BY p.order_by DESC;";
$q = DB::query($sql);


$orderCount = 1;

foreach ($q as $r) 
{

echo "PROCESSING: " . $r['title'] . "<br>";


		//get videos based on show or
		//if(@a, @a:=@a+1, @a:=0) for row NUM in sql does not work in mysql with an orderby
		// so the inserts need to be done procedurely

		$sql = " SELECT DISTINCT  v.video_id, v.date_pub, UNIX_TIMESTAMP(v.date_pub) as uDate 
				FROM videos v
				WHERE v.show_id = '{$r['show_id'] }'
				AND v.parent_id = '0'
		 		ORDER BY date_added DESC, order_by 
		 		LIMIT  {$r['video_count']} " ;
		echo $sql.  "<br>";
		$q1 = DB::query($sql);	
		
		
	
		
		foreach ($q1 as $r)
		{
			
			$_order_by_var = $orderCount;	
			
			if ($_program_order_by_type_id == 2 )
			{
					$_order_by_var = "-".$r['uDate'];
					echo "DATE: " . $r['uDate'] .  "<br>";	
			}	
			
		
			$sql = "
				INSERT INTO channel_videos SET  
				channel_id = '{$_channel_id}',
				video_id = '{$r['video_id']}',
				source = '2',
				status = 1,
				order_by = {$_order_by_var}
				
				ON DUPLICATE KEY UPDATE status = status	
				;";		
		

			$orderCount++;
			DB::query($sql, false);
			
		}	
		
		
		
		
		

	
	
	$orderCount++;
	
 
	//echo $orderCount.  "<br>";


}



$sql = "
	UPDATE channels SET  
	
	date_updated = '" . date("Y-m-d G:i:s") . "'
	WHERE channel_id = '" . $_channel_id . "';";		


$orderCount++;
DB::query($sql, false);









?>