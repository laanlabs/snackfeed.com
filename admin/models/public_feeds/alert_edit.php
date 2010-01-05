<?

$_public_id = isset($_REQUEST['public_id']) ? $_REQUEST['public_id'] : '0';





$win_title = "Alert Edit for Public Feed: " ;

$_title = 'news title';
$_detail = 'news/alert detail';
$_thumb = '';
$_link = '';
$_weight = '50';


if ($_public_id !=0 ) {

$sql = " SELECT *
		FROM feed_publics
		WHERE public_id = '{$_public_id}';";
$q = DB::query($sql);

foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = stripslashes($field_value);
}


}






?>