<?

//make warniong throw status error
set_error_handler("my_warning_handler", E_WARNING);

function my_warning_handler($errno, $errstr) {
echo "WARNING: " . $errstr;
global $_cron_status;
$_cron_status = "-1";
}



$_t = "blank";
$rCount = 0;
//starttime
$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];
$_show_id =  isset($_REQUEST['show_id']) ? $_REQUEST['show_id'] : '';


$_date = date("Y-m-d G:i:s");

//GET ALL PROCESSING PARAMS//////
$sql = " SELECT DISTINCT s.*, s.title as show_title, sc.* 
 FROM shows s, sources sc 
 WHERE s.source_id = sc.source_id
 AND show_id = '{$_show_id}';";


$q = DB::query($sql);


$_show_title = $q[0]['show_title'];
$_source_id = $q[0]['source_id'];
$_source_params = $q[0]['source_params'];
$_source_params_2 = $q[0]["source_params_2"];
$_source_params_3 = $q[0]["source_params_3"];
$_source_params_4 = $q[0]["source_params_4"];
$_url = $q[0]['url'];
$_params  = $q[0]['params'];
$_filters = $q[0]['filters'];
$_process_type_id = $q[0]['process_type_id'];
$_process_lib = $q[0]['process_lib'];
$_use_embedded = $q[0]["use_embedded"];	
$_use_link= $q[0]["use_link"];	
$_process_days = $q[0]['process_days'];
$_process_hour_base = $q[0]['process_hour_base'];
$_process_hour_interval = $q[0]['process_hour_interval'];
$_process_hour_retry = $q[0]['process_hour_retry'];
$_process_clear = $q[0]["process_clear"];
$_show_process_type_id = $q[0]['show_process_type_id'];
$_show_process_days = $q[0]['show_process_days'];
$_show_process_hour_base = $q[0]['show_process_hour_base'];
$_show_process_hour_interval = $q[0]['show_process_hour_interval'];
$_show_process_hour_retry = $q[0]['show_process_hour_retry'];
$_process_date_last = $q[0]['show_process_hour_retry'];
$_process_date_next = $q[0]['process_date_next'];
$_show_process_clear = $q[0]["show_process_clear"];
$_show_process_type_id = $q[0]["show_process_type_id"];

if ($_show_process_type_id == 1) $_show_process_clear = $_process_clear;


// INSERT BATCH 

$sql = "INSERT INTO batchs SET
	show_id = '{$_show_id}',
		source_id = '{$_source_id}',
		detail = '',
		clips = 0,
		episodes = 0,
		total = 0,
		date_started = '{$_date}',
		date_scheduled = '{$_process_date_next}',
		millseconds = 0,
		status = 0
	";
DB::query($sql, false);
$_batch_id = DB::insert_id();



//override	
//$_show_process_clear = 1;



//clear expired
include MODELS .'/videos/expired_clear.php';



if ($_show_process_clear == 1)
{
	//clear any entries in db from this feed
	$sql = "DELETE FROM videos WHERE show_id = '" . $_show_id ."';"; 
	DB::query($sql , false);
}



//include the custom lib
$_cron_status = 0;
try {
	$_cron_status = 1;
	$_process_file = "process_libs/" . $_process_lib . ".php";
	require $_process_file;


} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    $_error_detail = $e->getMessage();
    $_cron_status = -1;
}


$win_title = "Process Videos: " . $_show_name;

$endtime = microtime();
$endarray = explode(" ", $endtime);
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime;
$totaltime = round($totaltime,5);
echo "This page loaded in $totaltime seconds.";
  
if (empty($rCount)) $rCount = 0;

$sql = "UPDATE batchs SET
		detail = '{$_error_detail}',
		clips = 0,
		episodes = 0,
		total = {$rCount},
		millseconds = '{$totaltime}',
		status = {$_cron_status}
		WHERE batch_id = {$_batch_id}
	";
	//echo $sql;
DB::query($sql , false);


if ($rCount > 0 ){
	
	$_show_title_dashes = preg_replace('/\W/', '-', $_show_title);
	
	$ping_title = "{$_show_title} video blog";
	$ping_url = "http://snackfeed.com/shows/detail/{$_show_id}/{$_show_title_dashes}";
	$ping_rss = "http://snackfeed.com/shows/rss/{$_show_id}/{$_show_title_dashes}";

//echo $ping_title . $ping_url . $ping_rss ;
echo "<br/>";



ping_blogs($ping_title,$ping_url,$ping_rss );
	
}




?>