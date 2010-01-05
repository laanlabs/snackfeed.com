<?

//starttime
$starttime = microtime(); $startarray = explode(" ", $starttime); $starttime = $startarray[1] + $startarray[0];


// see .htaccess if there are routing problems
// make sure all extensions that are not re-routed are in .htaccess
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
require_once "../app.php";



$endtime = microtime(); $endarray = explode(" ", $endtime); $endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime;
$totaltime = round($totaltime,5);
if (User::$user_su == '1' && $_t != 'empty')  echo "<div style='position: absolute; top: 0px; right: 0px'>$totaltime</div>";

?>
