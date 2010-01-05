<?

$_source_id = isset($_GET['source_id']) ? $_GET['source_id'] : '0';

$win_title= "Source Item Edit";

$_name = 'Source Title';
$_detail = '';
$_url = '';
$_params = '';
$_filters = '';
$_process_type_id = 0;
$_process_lib = '';
$_process_days = '';
$_process_hour_base = '';
$_process_hour_interval = -1;
$_process_hour_retry = -1;
$_client_lib = '';
$_proxy_url = '';
$_use_embedded = 0;
$_status = 1;
$_order_by = '5';


$sql = " SELECT  process_type_id, process_type ";
$sql .= " FROM lkp_source_process_type ";
$sql .= " ORDER BY process_type_id; ";
$q1 = DB::query($sql);


if ($_source_id != '0') 
{


$rowcount = 0;
$sql = " SELECT * ";
$sql .= " FROM sources WHERE source_id = '" . $_source_id . "';";
$q = DB::query($sql);

//stripslashes

	foreach ($q[0] as $field_name => $field_value)
	{
		${"_{$field_name}"} = stripslashes($field_value);
	}




}
?>