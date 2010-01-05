<?


$sql = "DELETE FROM uvideo  
	WHERE uvideo_id = '${_REQUEST['uvideo_id']}'";

DB::query($sql , false);



header("Location: /?a=uvideos.list");


?>