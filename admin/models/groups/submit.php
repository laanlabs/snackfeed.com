<?

//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "group";

$key_org_id = $_POST['_' .$key_table .'_id'];
//get ID if its an insert




include LIB."/calls/db_submit.php";



header("Location: /?a=groups.list");
?>