<?




//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "source";

$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}




//OVERIDE POST VARS IF NECESSARY
$_POST['_process_days']  = empty($_POST['_process_days']) ? $_POST['_process_days'] : implode(",", $_POST['_process_days']);


include LIB."/calls/db_submit.php";



header("Location: /?a=sources.list");
  

?>