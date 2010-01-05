<?

//SET TABLE NAME IN SINGULAR FORM I.E. no "s"
$key_table = "package";

//get ID if its an insert
$key_org_id = $_POST['_' .$key_table .'_id'];
if ($_POST['_' .$key_table .'_id']  == '0') {
	$_POST['_' .$key_table .'_id'] =  DB::UUID();
}

//OVERIDE POST VARS IF NECESSARY
$_POST['_thumb']=  empty($_FILES["file"]["name"]) ? $_POST['_thumb'] : image_upload_jpg( PUBLIC_ROOT, "/images/{$key_table}s/", $_REQUEST['_' .$key_table .'_id'] );


include LIB."/calls/db_submit.php";



header("Location: /?a=shows.packages");

?>
  
