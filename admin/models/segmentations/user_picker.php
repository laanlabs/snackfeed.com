<?

$win_title = "User/Video Segmenation List";


$_user_id = $_REQUEST['user_id'];

$rowcount = 0;
$sql = " SELECT s.segmentation_id, s.title, 
		if(us.segmentation_id is  null , 0, 1) as count, 
		if(us.weight is  null , 0, us.weight ) as weight
 	FROM segmentations s
 	LEFT OUTER JOIN user_segmentations us ON s.segmentation_id = us.segmentation_id
	 		AND us.user_id = '{$_user_id}'
	WHERE s.segmentation_id != '0' 		
	ORDER BY title ASC;";
$q = DB::query($sql);



  

?> 