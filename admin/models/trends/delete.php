<?


$sql = "DELETE FROM trends  
	WHERE trend_id = '${_REQUEST['trend_id']}'";

DB::query($sql , false);



header("Location: /?a=trends.list");


?>