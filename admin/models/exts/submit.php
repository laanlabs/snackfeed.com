<?

//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "ext";

$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}


//$_debug = true;


include LIB."/calls/db_submit.php";





header("Location: /?a=exts.list");
?>