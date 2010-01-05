<?
$_channel_id = $_REQUEST['channel_id'];
$sql = "DELETE FROM channels  ";
$sql .= " WHERE channel_id = '" . $_channel_id . "'";


DB::query($sql , false);

header("Location: /?a=channels.list");

?>