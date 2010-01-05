<?

$_channel_id = $_REQUEST['channel_id'];


$win_title  = "Video List";

$sql = " SELECT v.*  ";
$sql .= " FROM videos v, channel_videos c";
$sql .= " WHERE c.channel_id = '" . $_channel_id . "'";
$sql .= " AND c.video_id = v.video_id";
$sql .= " ORDER BY   v.date_added desc LIMIT 300;";



$q = DB::query($sql);


//override template
$_m = "videos";
$_v = "list"; 

?>