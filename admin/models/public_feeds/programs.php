<?




$win_title = "Programs List for public feed";


$sql = " 
 SELECT p.*, s.title,  s.thumb
 FROM feed_programs p
	INNER JOIN shows s ON s.show_id = p.show_id
 ORDER BY p.order_by DESC;";
$q = DB::query($sql);



?>