<?

//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "user";

$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}


//OVERIDE POST VARS IF NECESSARY
$_POST['_email_days']  = empty($_POST['_email_days']) ? $_POST['_email_days'] : implode(",", $_POST['_email_days']);
$_POST['_email_hours']  = empty($_POST['_email_hours']) ? $_POST['_email_hours'] : implode(",", $_POST['_email_hours']);




include LIB."/calls/db_submit.php";



header("Location: /?a=users.list");
?>