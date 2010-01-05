<?


$server_time_url = "http://asfix.adultswim.com/asfix-svc/services/getServerTime";
$segment_id = "8a25c392161eb6420116200688450078";


$segment_id = isset($_REQUEST['segment_id']) ? $_REQUEST['segment_id'] : '8a25c392161eb6420116200688450078';



$server_time = simplexml_load_file($server_time_url);



$k_K = "-22rE=w@k4raNA";
$key =  $server_time . "-" . MD5($server_time . $segment_id . $k_K);

//echo $key;

//die();

$test_url = "http://asfix.adultswim.com/asfix-svc/episodeservices/getVideoPlaylist?id=" . $segment_id ."&rnd" . $server_time;


$headers = array(
   
    "Content-type: text/xml;charset=\"utf-8\"",
    "Accept: text/xml",
	"x-prefect-token: " . $key   
);

//print_r($headers);



	//httpTest.headers = {"x-prefect-token": getKey(videoItem["id"]).toString()};

	$ch = curl_init($test_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($ch);

echo $response;




?>