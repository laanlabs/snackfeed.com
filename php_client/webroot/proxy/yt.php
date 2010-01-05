<?
 

// $_youtube_id = $_REQUEST['i'];
// //$_youtube_id= "qX1ImnGQYcE";
// 
// $_url = "http://www.youtube.com/get_video_info?&video_id=" . $_youtube_id; 
//  
//  	$ch = curl_init($_url);
// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// 	curl_setopt($ch, CURLOPT_HEADER, 1);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	$response = curl_exec($ch);
// 
// echo $response;
// 		$pattern =	'#\&token=(.*?)\&#i';
// 		preg_match_all($pattern, $response, $matches);
// 		//print_r($matches);
// 		$_t = $matches[1][0];
// 		header('Content-Type: text/plain'); 
// 		echo $_t;




if(empty($_GET['i'])) 
{ 
echo "No id found!"; 
}
else
{

function url_exists($url)
{
if(file_get_contents($url, FALSE, NULL, 0, 0) === false) return false;
return true;
}

$id = $_GET['i'];
$page = @file_get_contents('http://www.youtube.com/get_video_info?&video_id='.$id);
preg_match('/token=(.*?)&thumbnail_url=/', $page, $token);
$token = urldecode($token[1]);

//echo $token;

$get = $title->video_details;
$url_array = array ("http://youtube.com/get_video?video_id=".$id."&t=".$token,
"http://youtube.com/get_video?video_id=".$id."&t=".$token."");

if(url_exists($url_array[1]) === true)
{ 
$file = get_headers($url_array[1]);
}
elseif(url_exists($url_array[0]) === true)
{ 
$file = get_headers($url_array[0]);
}

//print_r($file);

$url = trim($file[19],"Location: ");

//header('Location: ' . $url );
echo $url;


//echo '<a href="'.$url.'">Download video</a>';
}
?>



