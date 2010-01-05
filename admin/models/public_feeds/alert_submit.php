<?


$_public_id = $_POST['_public_id'];
$_date = date("Y-m-d G:i:s");

if ($_public_id == 0) {

	$_video_id = DB::UUID();

	$sql = "INSERT INTO feed_publics SET
		video_id = '{$_video_id}',
		type = '4',
		date_added = '{$_date}',
		title = '{$_POST['_title']}',
		detail = '{$_POST['_detail']}', 
		link = '{$_POST['_link']}',
		thumb = '{$_POST['_thumb']}',
		weight = '{$_POST['_weight']}'
		";
	
} else {

	$sql = "UPDATE feed_publics SET
		title = '{$_POST['_title']}',
		detail = '{$_POST['_detail']}', 
		link = '{$_POST['_link']}',
		thumb = '{$_POST['_thumb']}',
		weight = '{$_POST['_weight']}'
		WHERE public_id = '{$_public_id}'
		";	
	
}

DB::query($sql,false);



header("Location: /?a=public_feeds.alerts");

?>
  
