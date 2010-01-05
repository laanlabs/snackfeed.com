<?

$win_title = "User reports";

$_date_range = isset($_REQUEST["date_range"]) ?  $_REQUEST["date_range"] : "day";

switch ($_date_range)
{
	case "month" :
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
		break;
	case "week" :
			$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")) );
			break;
	 default :
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")) );
}


$rowcount = 0;
$sql = " SELECT count(u.user_id) as total_users,  
  count(u2.user_id) as new_users,
  count(u3.user_id) as recent_logins
FROM users u 
	LEFT OUTER JOIN users u2 ON u.user_id = u2.user_id AND u2.date_created >= '{$_date}'
	LEFT OUTER JOIN users u3 ON u.user_id = u3.user_id AND u3.login_last >= '{$_date}' ";
$q = DB::query($sql);

?>

