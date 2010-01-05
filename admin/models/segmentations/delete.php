
not enabled
<?

die();
$sql = "DELETE FROM invites  
	WHERE invite_id = '${_REQUEST['invite_id']}'";

DB::query($sql , false);



header("Location: /?a=invites.list");


?>