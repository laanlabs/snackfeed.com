<?
$_t = "empty";
require_once(APP_ROOT . "/lib/TinyHelper.php");
require_once(APP_ROOT . "/lib/Twitter.lib.php");


// Set username and password
$username = "snackfeedme";
$password = "meatwad";


//message array...
$_status_array = array(
	"",
	"we're watching",
	"checkout",
	"new video",
	"video added",
	"watch",
	"snackfeed found",
	"liking",
	"another one ",			
	);


$random = rand( 0  , count($_status_array)-1);

//get last update_id
$sql = "SELECT last_id FROM feed_statuses WHERE feed_id = 1";
$q = DB::query($sql);
$_last_id = $q[0]['last_id'];



$sql = " SELECT f.*, s.title as show_title, s.title_prefix, v.video_iid
		 FROM feed_publics f
			LEFT OUTER JOIN shows s ON f.show_id = s.show_id
			LEFT OUTER JOIN videos v ON f.video_id = v.video_id
		 WHERE f.status = 1	
			 AND f.public_id > {$_last_id}
		 ORDER BY date_added desc
		 LIMIT 100 ";

$data = DB::query($sql);


if (count($data) > 0 )
{


//update the blog ping as well
include "blogping.php";

//take the last one 
$i = count($data) -1;

$_public_id = $data[$i]['public_id'];


//BUILD STATUS MESSAGE
$status = $_status_array[$random];

$status .= " http://snfd.tv/". TinyHelper::decimal_to_base($data[$i]['video_iid'], 62)  . " ";
		
if (!empty($data[$i]['title_prefix'])) $status .= $data[$i]['title_prefix'] . "-";
		 			
$status .=	stripslashes($data[$i]['title']) ;
		

if (strlen($status) > 140 )
{
	$status = substr($status, 0, 137) . "...";	
}


	
echo $status;




 $twitter = new Twitter($username , $password);
 $public_timeline_xml = $twitter->updateStatus($status);




$sql = "
UPDATE feed_statuses SET
last_id = {$_public_id}
WHERE  feed_id = 1
";

DB::query($sql,false);

} else {
	
	echo "no updates for bot";
	
}


?>