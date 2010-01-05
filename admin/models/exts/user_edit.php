<?




$_base_table = "ext_user";

$win_title= " Item Edit";

$_fields = DB::field_defaults($_base_table . 's');
foreach ($_fields as $field_name => $field_value) { ${"{$field_name}"} =$field_value; }


$_user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0 ;
$_ext_id = $_REQUEST['ext_id'];
$_action = "0";

if ( $_user_id != '0') 
{

$_action = "1";
$rowcount = 0;
$sql = " SELECT  *  FROM ext_users 
	WHERE 1
	AND user_id = '{$_user_id}'
	AND ext_id = '{$_ext_id}';";



$q = DB::query($sql);


foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = stripslashes($field_value);
}


}





?>