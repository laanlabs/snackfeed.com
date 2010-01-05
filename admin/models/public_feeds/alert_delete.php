<?
$_feed_program_id = $_REQUEST['feed_program_id'];
$sql = "DELETE FROM feed_programs  ";
$sql .= " WHERE feed_program_id = '" . $_feed_program_id . "'";


DB::query($sql , false);

header("Location: /?a=public_feeds.programs");

?>