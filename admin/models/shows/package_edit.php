<?

$_package_id = isset($_GET['package_id']) ? $_GET['package_id'] : '0';

$win_title= "Package Item Edit";


$_name = 'package Title';
$_detail = '';
$_thumb = '/images/default.jpg';
$_status = 1;
$_order_by = '5';

 

if ($_package_id != '0') 
{


$rowcount = 0;
$sql = " SELECT  * ";
$sql .= " FROM packages WHERE package_id = '" . $_package_id . "';";
$q = DB::query($sql);


foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = stripslashes($field_value);
}




}
?>