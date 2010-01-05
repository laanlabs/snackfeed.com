<?
setcookie("twitter_email", $_POST['twitter_email'], time()+60*60*24*30, "/" , ".snackfeed.com");
setcookie("twitter_password", $_POST['twitter_password'], time()+60*60*24*30, "/" , ".snackfeed.com");
?>

Twitter responded with: 

<?


$tiny_url = "";
if ($_POST['twitter_url_append'] == "1")
{
$_tURL = "http://tinyurl.com/api-create.php?url=" . $_POST['twitter_url'];  
$ch = curl_init ($_tURL);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
$tiny_url = curl_exec($ch);
curl_close($ch);
}
//echo "dsfds: " . $tiny_url;

//die();


// Set username and password
$username = $_POST['twitter_email'];
$password = $_POST['twitter_password'];



// The message you want to send
$message = stripslashes($_POST['message']) . " ". $tiny_url;
// The twitter API address
$url = 'http://twitter.com/statuses/update.xml';
// Alternative JSON version
// $url = 'http://twitter.com/statuses/update.json';
// Set up and execute the curl process
$curl_handle = curl_init();
curl_setopt($curl_handle, CURLOPT_URL, "$url");
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
curl_setopt($curl_handle, CURLOPT_USERPWD, "$username:$password");
$buffer = curl_exec($curl_handle);
$resultArray = curl_getinfo($curl_handle);
curl_close($curl_handle);


if($resultArray['http_code'] == "200"){
    echo "OK! posted to <a href='http://twitter.com/{$username}/' target='_new' >http://twitter.com/{$username}/</a><br />";
} else {
	
	switch ($resultArray['http_code'] )
	{
		case "304":
 			$vMsg = "Not Modified: there was no new data to return.";
	    case "400":
			$vMsg = "Bad Request: your request is invalid, and we'll return an error message that tells you why. This is the status code returned if you've exceeded the rate limit (see below). ";
	    case "401":
	 		$vMsg = "Not Authorized: either you need to provide authentication credentials, or the credentials provided aren't valid.";
	    case "403":
	 		$vMsg = "Forbidden: we understand your request, but are refusing to fulfill it.  An accompanying error message should explain why.";
	    case "404":
	 		$vMsg = "Not Found: either you're requesting an invalid URI or the resource in question doesn't exist (ex: no such user). ";
	    case "500":
	 		$vMsg = "Internal Server Error: we did something wrong.  Please post to the group about it and the Twitter team will investigate.";
	    case "502":
	 		$vMsg = "Bad Gateway: returned if Twitter is down or being upgraded.";
	    case "503":
	 		$vMsg = "Service Unavailable: the Twitter servers are up, but are overloaded with requests.  Try again later.";
	
	}
	
    echo $vMsg;
}


?>