<?
$_ext_id = $_REQUEST['ext_id'];
$_user_id = $_REQUEST['user_id'];

$sql = "DELETE FROM ext_users  WHERE ext_id = '{$_ext_id}' AND user_id = '{$_user_id}'";


DB::query($sql , false);

header("Location: /?a=exts.users&ext_id={$_ext_id}&user_id={$_user_id}");

?>