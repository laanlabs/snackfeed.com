<?

$win_title = "User/Video Segmenation List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM segmentations
	ORDER BY title ASC;";
$q = DB::query($sql);



  

?> 