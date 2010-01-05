<?

$_channel_id =  $_REQUEST['channel_id'];

$sql = " SELECT title 
 FROM channels 
 WHERE channel_id = '{$_channel_id}';";
$q = DB::query($sql);


$win_title = "Programs List for Channel: " . $q[0]['title'] ;


$sql = " 
 SELECT p.*, s.title,  s.thumb
 FROM programs p
	INNER JOIN shows s ON s.show_id = p.show_id
 WHERE p.channel_id = '{$_channel_id}'
 ORDER BY p.order_by DESC;";
$q = DB::query($sql);



?>