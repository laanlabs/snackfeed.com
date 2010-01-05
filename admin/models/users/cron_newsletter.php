<?

$_date = date("Y-m-d G:i:s");

$sql = " SELECT *  
		FROM users 
		WHERE email_subscribe = 1
		AND email_date_next < '{$_date}' 
		LIMIT 1
		";


$q = DB::query($sql);

if (count($q) < 1 ) {

	echo "no emails to process";

	
} else {
	

foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = stripslashes($field_value);
}


echo $_email . "<br/>";

switch ($_email_param_date)
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


$sql = " SELECT s.show_id, s.title, s.thumb,
			count(v.video_id) as new_content, 
			SUM(IF(v.video_type_id = 1, 1, 0)) as new_episodes,
			SUM(IF(v.video_type_id = 2 or v.video_type_id = 0, 1, 0)) as new_clips,
			SUM(IF(v.video_type_id = 3, 1, 0)) new_movies,			
			max(v.date_added) as latest_date,
			if ( (DATEDIFF(max(v.date_added), now()) = 0), DATE_FORMAT(max(v.date_added), '%l:%i %p'), DATE_FORMAT(max(v.date_added), '%b %e') ) as date_formatted,
			LEFT(GROUP_CONCAT(DISTINCT v.title ORDER BY date_added DESC), 200) as new_titles,
			GROUP_CONCAT(DISTINCT v.video_id ) as new_ids
			FROM shows s LEFT OUTER JOIN videos v ON s.show_id=v.show_id 
			WHERE v.date_added > '{$_date}'
			AND v.parent_id = '0'
			AND v.video_id not in (SELECT uv.video_id FROM user_videos uv WHERE uv.user_id = '{$_user_id}')
			AND s.show_id in (SELECT us.show_id FROM user_shows us WHERE us.user_id = '{$_user_id}')
			GROUP BY s.show_id
			ORDER BY latest_date DESC ;
";

$q = DB::query($sql);




include "templates/basic.php";

echo "starting show process" . "<br/>\r\n";
$_now = date("Y-m-d G:i:s");
$rCount = 0;
echo "NOW: " . $_now. "<br/>\r\n";
$current_day = date("w");
$current_hour = date("G");
$next_day = "";
$next_hour = "";



/**********  START EMAIL NEXT DATE **********/
echo "DAYS LIST : " .  $_email_days . "<br/>";
echo "HOURS LIST : " .  $_email_hours. "<br/>\r\n";

//**  FIGURE OUT WHAT NEXT PROCESS TIME IS **//
$_process_days_array = explode(",", $_email_days);
$_process_hours_array = explode(",", $_email_hours);
//add the first day of the next week to array
array_push($_process_days_array, $_process_days_array[0]+7);

echo "DAY: " . $current_day . "<br/>\r\n";

foreach ($_process_days_array as &$d) {

echo "DAY: " . $d . "<br/>\r\n";
	
	//loop for the current day
	if ($d == $current_day)
	{
		//loop process hours
		 foreach ($_process_hours_array as &$h) 
		{
			echo "HOUR: " . $h . "<br/>\r\n";
			if ($h > $current_hour)
			{
				$next_day = $d;
				$next_hour = $h;
				break 2;
			}	
		}
	}
	
	
	//loop for the current day
	if ($d > $current_day)
	{
		$next_day = $d;
		$next_hour = $_process_hours_array[0];
		break;
	}	
}


$day_diff = $next_day - $current_day;
echo "NEXT DAY: " . $next_day  . "<br>";

$next_date  = mktime($next_hour, 0, 0, date("m")  , date("d")+$day_diff, date("Y"));
$_next_date =  date("Y-m-d G:i:s", $next_date);
echo "NEXT DATE: " . $_next_date . "<br/>\r\n";

echo "NEXT NOW: " .date("Y-m-d G:i:s") . "<br/>\r\n";

$sql = array (
	"email_date_last" => 		date("Y-m-d G:i:s"),
	"email_date_next" => 		$_next_date
	);

	$nSQL = "UPDATE users SET " . DB::assoc_to_sql_str($sql) . " WHERE user_id = '{$_user_id}';";
	DB::query($nSQL , false);















}


die();

?>