<?

$_base_table_id = isset($_GET[ $_base_table . '_id']) ? $_GET[  $_base_table . '_id'] : '0';

$win_title= $_base_table . " Item Edit";

$_fields = DB::field_defaults($_base_table . 's');
foreach ($_fields as $field_name => $field_value) { ${"{$field_name}"} =$field_value; }

$_action = "0";

if ( $_base_table_id != '0') 
{

$_action = "1";
$rowcount = 0;
$sql = " SELECT  *  FROM " . $_base_table ."s WHERE " .  $_base_table ."_id = '" . $_base_table_id. "';";



$q = DB::query($sql);


foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = stripslashes($field_value);
}


}


?>