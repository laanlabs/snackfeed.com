<?


$sql = "DELETE FROM recommendation_videos  
	WHERE recommendation_id = '${_REQUEST['recommendation_id']}'";

DB::query($sql , false);



header("Location: /?a=recommendations.videos");


?>