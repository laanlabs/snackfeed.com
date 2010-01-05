<?

//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "video";

$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}





include LIB."/calls/db_submit.php";



header("Location: /?a=videos.list&show_id=" . $_REQUEST['_show_id']);
?>