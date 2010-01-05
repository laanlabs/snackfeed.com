<?


$_title = stripslashes($_REQUEST['title']);
$_detail = stripslashes($_REQUEST['message']);


if (!empty($_REQUEST['_channel_ids']))
{
	$_channel_ids = implode(",", $_REQUEST['_channel_ids']);
}



//see if we can get a clean flv
$_video_data = html_entity_decode(stripslashes($_REQUEST['channels_data']));



	preg_match_all('/src=(\"|\')(.*?)(\"|\')/i', $_video_data, $matches);
	//print_r($matches);
	$_src = $matches[2][0];

	preg_match_all('/flashvars=(\"|\')(.*?)(\"|\')/i', $_video_data, $matches);
	$_vars = $matches[2][0];



$pattern = "#^(?:[^/]+://)?([^/:]+)#";
preg_match_all($pattern , $_src, $matches2);
$_url = $matches2[1][0];
$_domain = str_replace( current(explode(".", $_url)) . "." , "" , $_url);

echo "DOMAIN: " .  $_domain . "<br>" ;


switch ($_domain)
{
	case "youtube.com" :
	 include "inc/youtube.php";
	 break;
	case "ytimg.com" :
	 include "inc/youtube.php";
	 break;
	default:
	 die("only youtube currently supported"); 	
	
	
	
}







$_url = "http://". $_SERVER['SERVER_NAME'] ."/videos/add_video";


$post_var = array(
			"org_video_id"	=>	$_org_video_id,
			"source_id"		=>	$_source_id,
			"show_id"		=> 	$_show_id,	
			"title"			=> 	$_title,	
			"detail"		=>	$_detail,	
			"url_source" 	=>	$_url_source,
			"url_link"		=> 	$_link,	
			"thumb" 		=>	$_thumb,
			"param_1"		=>  $_param_1,
			"param_2"		=>	$_param_2,
			"param_3"		=>	$_param_3,
			"channel_ids"	=>	$_channel_ids,
);







//print_r($post_var);
//die();


// Prepare POST request
$request_data = http_build_query( $post_var);

// Send the POST request (with cURL)
$c = curl_init($_url);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, $request_data);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($c);
$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
curl_close($c);

echo "<hr/>";
echo "STATUS" . $status . "<br>"; 
echo "result" . $result . "<br>";
//add video to db -- lookup source id


//add video to channel list




//print_r($_REQUEST);
//_channel_ids
//user_id

?>



posted channel
