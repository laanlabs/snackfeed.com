<?

$_source_id = isset($_GET['source_id']) ? $_GET['source_id'] : '0';



$rowcount = 0;
$sql = " SELECT * ";
$sql .= " FROM sources WHERE source_id = '" . $_source_id . "';";
$q = DB::query($sql);

//stripslashes

	foreach ($q[0] as $field_name => $field_value)
	{
		${"_{$field_name}"} = stripslashes($field_value);
	}









//include the custom lib
$_process_file = "process_libs/" . $_process_lib . ".php";
require $_process_file;


?>