<?
$_program_id = $_REQUEST['program_id'];
$sql = "DELETE FROM programs  ";
$sql .= " WHERE program_id = '" . $_program_id . "'";


DB::query($sql , false);

header("Location: /?a=channels.programs&channel_id={$_REQUEST['channel_id']}");

?>