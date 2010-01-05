<?

/*

	1. retrieve 1 show from db based on PROCESS_NEXT_DATE
	2. process update
	3. determin when next process time is based on params




*/
ob_start();

echo "starting show process" . "<br/>\r\n";
$_now = date("Y-m-d G:i:s");
$rCount = 0;
echo "NOW: " . $_now. "<br/>\r\n";
$current_day = date("w");
$current_hour = date("G");
$next_day = "";
$next_hour = "";


echo "current day of week: " .  $current_day . "<br/>\r\n";
echo "current hour: " . $current_hour . "<br/>\r\n";

$sql = " 
	SELECT  c.*
 	FROM channels c
	WHERE c.process_type_id > 0
	AND c.process_date_next < '" . $_now . "'
 	LIMIT 1; ";

$q = DB::query($sql);

$_channel_id = $q[0]['channel_id'];
$_REQUEST['channel_id'] = $_channel_id;
$_channel_title = $q[0]['title'];

echo "Channel id: " . $_channel_id . "<br/>\r\n";
echo "shows to process: " . count($q) . "<br/>\r\n";
echo "shows to process: " . $_channel_title . "<br/>\r\n";

//print_r($q[0]);

if (count($q) == 0)
{
	echo "NO CHANNELS TO PROCESS";
	die();
} 


foreach ($q[0] as $field_name => $field_value)
{
	${"_{$field_name}"} = $field_value;
}



//** INCLUDE PROCESS FILE **//
require "getVideos.php";

echo "Channel id: " . $_channel_id . "<br/>\r\n";

echo "NEW SHOWS ADDED: " . $orderCount . "<br>\r\n ";




echo "_process_hour_interval: " .  $_process_hour_interval . "<br/>\r\n";


//make daily hours to try array
$_process_hours_array = array();
array_push($_process_hours_array, $_process_hour_base);

//make process interval if ther are any
if ($_process_hour_interval > 0) 	
{
	$_loop_hour = $_process_hour_base;
	for ( $i = 0; $i <= 23; $i ++)
	{
		$_loop_hour = $_loop_hour + $_process_hour_interval;
		if ($_loop_hour > 23 ) break;
	
		array_push($_process_hours_array, $_loop_hour);
	
	}
}


//echo "DAYS LIST : " .  $_process_days . "<br/>";
//echo "HOURS LIST : " .  implode($_process_hours_array, ",") . "<br/>\r\n";

//**  FIGURE OUT WHAT NEXT PROCESS TIME IS **//
$_process_days_array = explode(",", $_process_days);
//add the first day of the next week to array
array_push($_process_days_array, $_process_days_array[0]+7);


foreach ($_process_days_array as &$d) {

//echo "DAY: " . $d . "<br/>\r\n";
	
	//loop for the current day
	if ($d == $current_day)
	{
		//loop process hours
		 foreach ($_process_hours_array as &$h) 
		{
			//echo "HOUR: " . $h . "<br/>\r\n";
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



$next_date  = mktime($next_hour, 0, 0, date("m")  , date("d")+$day_diff, date("Y"));
$_next_date =  date("Y-m-d G:i:s", $next_date);
echo "NEXT DATE: " . $_next_date . "<br/>\r\n";







$sql = array (
	"process_date_last" => 		$_now,
	"process_date_next" => 		$_next_date
	);

	$nSQL = "UPDATE channels SET " . DB::assoc_to_sql_str($sql) . " WHERE channel_id = '" . $_channel_id . "';";
echo $nSQL;

DB::query($nSQL , false);




$out1 = ob_get_contents();
ob_end_clean();

echo $out1;



$sender = "jason@laan.com";
$reciever = "jason@laan.com";

$mail_subject = "ST_REPORT ";
$mail_message = "CHANNEL { $_channel_title} \r\n";
$mail_message .= "" .  $out1;

// EMAIL HEADERS 
$headers = "From: " . $sender . "<" . $sender . ">\n";
$headers .= "Reply-To: " . $sender ." <" . $sender . ">\n";
$headers .= "MIME-Version: 1.0\n";	
 //echo "SENDER: " . $sender . "\r\n";

mail($reciever, $mail_subject,      $mail_message,      $headers);

echo "EMAIL SENT: " .  $reciever;






die();
?>