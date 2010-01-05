<?
$_ext_id = $_REQUEST['ext_id'];
$sql = "DELETE FROM exts  WHERE ext_id = '{$_ext_id}'";


DB::query($sql , false);

header("Location: /?a=exts.list");

?>