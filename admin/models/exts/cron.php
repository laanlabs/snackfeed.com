<?

//variables
$_t = "empty";
$_now = date("Y-m-d G:i:s");

$_user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '0' ;
$_ext_id = isset($_REQUEST['ext_id']) ? $_REQUEST['ext_id'] : '0' ;



if ($_user_id == '0')
{
//get the next user_id from DB		
if ($_ext_id != '0' ) $conditions = "AND e.ext_id = '{$_ext_id}'";

$sql = " 
	SELECT user_id, ext_id FROM ext_users e
	WHERE 1
	{$conditions}
	AND e.process_date_next < '" . $_now . "'
 	LIMIT 1; ";
	$q = DB::query($sql);		

	if (count($q) == 0)
	{
		echo "NO USER TO PROCESS ";
		die();
	} else {
		$_user_id = $q[0]['user_id'];
		$_ext_id = $q[0]['ext_id'];
	
	} 
		
}


if ($_ext_id == '0' ) 
{
	echo "no ext_id"; die();
}



$sql = " SELECT e.*, s.name as source_name 
		 FROM exts e
		 LEFT OUTER JOIN sources s ON e.source_id = s.source_id
		 WHERE 1
		 AND e.ext_id = '{$_ext_id}'
		 ORDER BY name;";

$q = DB::query($sql);
//set vars
foreach ($q[0] as $field_name => $field_value){ ${"_{$field_name}"} = stripslashes($field_value);}







$sql = " SELECT  e.*, u.nickname  
	FROM ext_users e
		LEFT OUTER JOIN users u ON u.user_id = e.user_id
	WHERE 1
	AND e.user_id = '{$_user_id}'
	AND e.ext_id = '{$_ext_id}';";
$q = DB::query($sql);
foreach ($q[0] as $field_name => $field_value){ ${"_{$field_name}"} = stripslashes($field_value);}




//include public libs an set vars
require_once "/var/www/sf-public/models/status.php";
require_once "/var/www/sf-public/models/user.php";
User::$user_id = $_user_id;
User::$username = $_nickname ;

include "libs/{$_ext_code}_user_feed.php";


$_date_try_next = date("Y-m-d G:i:s", mktime(date("G")+ $_process_hour_interval,0,0,date("m"),date("d"),date("Y")) ); 
echo "<hr>" . $_date_try_next;

$sql = " 
	UPDATE ext_users 
	SET 
	process_date_last = '{$_now}',
	process_date_next = '{$_date_try_next}'
	WHERE 1
	AND user_id = '{$_user_id}' 
	AND ext_id = '{$_ext_id}' ";
DB::query($sql, false)



?>