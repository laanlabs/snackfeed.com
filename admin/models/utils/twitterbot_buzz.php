<?
$_t = "empty";
require_once(APP_ROOT . "/lib/TinyHelper.php");
require_once(APP_ROOT . "/lib/Twitter.lib.php");


// Set username and password
$username = "snackfeedbuzz";
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
$sql = "SELECT last_id FROM feed_statuses WHERE feed_id = 2";
$q = DB::query($sql);
$_last_id = $q[0]['last_id'];



//get keywords
$sql = "SELECT term
		FROM trends
			ORDER BY rank DESC, date_updated DESC
		LIMIT 10	;";
$q = DB::query($sql);

$_keywords = "";
for ($i=0; $i < count($q); $i++) { 
	$_keywords .= ' "' . addslashes($q[$i]['term']) . '"';
}

echo "LOOKING FOR: " . $_kewords . "<br>";

$sql = " SELECT v.video_iid, v.video_id, v.title, v.detail, v.thumb, s.title as show_title, s.title_prefix,
		if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'),
      	DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub
			FROM videos v INNER JOIN shows s on v.show_id = s.show_id
			WHERE MATCH( v.title, v.detail, s.title ) AGAINST ('{$_keywords}' IN BOOLEAN MODE) > 0
			AND v.parent_id = '0'
			AND v.video_iid > {$_last_id}
			ORDER BY v.video_iid DESC
			LIMIT 100 ";

$data = DB::query($sql);

echo "FOUND: " . count($data) . "<br>";

if (count($data) > 0 )
{

//take the last one 
$i = count($data) -1;


$_video_iid = $data[$i]['video_iid'];


//BUILD STATUS MESSAGE
$status = $_status_array[$random];

$status .= " http://snfd.tv/". TinyHelper::decimal_to_base($data[$i]['video_iid'], 62)  . " ";
		
if (!empty($data[$i]['title_prefix'])) $status .= $data[$i]['title_prefix'] . "-";
		 			
$status .=	stripslashes($data[$i]['title']) ;
$status .= "-" . stripslashes($data[$i]['detail']) ;		

if (strlen($status) > 140 )
{
	$status = substr($status, 0, 137) . "...";	
}


	
echo $status . "<br>";




 $twitter = new Twitter($username , $password);
 $public_timeline_xml = $twitter->updateStatus($status);




$sql = "
UPDATE feed_statuses SET
last_id = {$_video_iid}
WHERE  feed_id = 2
";

DB::query($sql,false);

} else {
	
	echo "no updates for bot";
	
}


?>