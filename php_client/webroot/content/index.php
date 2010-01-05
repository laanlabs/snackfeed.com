<?

	$_view = "login";
	$_msg = "need your email";
	$_email_default = "your email...";
	
if (isset($_COOKIE["st_user_id"])) 
{
		$_user_id = $_COOKIE["st_user_id"];
		$_view = "smoothtube";
	
} else {

	if (!empty($_POST['email'])) 
	{
		
		$_email_default = $_POST['email'];
		
		//get id by email
		$get_url ="http://v1.smoothtube.com/users/get_user_id?email=" . $_POST['email'];
		$xml = simplexml_load_file($get_url);
		
		
		$_user_id = $xml->array_item->user_id;
		
		if(!empty($_user_id))
		{
			setcookie("st_user_id", $_user_id, time()+3600);
			$_view = "smoothtube";
			
		} else {
			
			$_msg = "that email is not found";
		}
		
	
		
	}

}

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>beta on this</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="history/history.css" />
<script src="AC_OETags.js" language="javascript"></script>
<script src="history/history.js" language="javascript"></script>
<script src="smoothtube.js" language="javascript"></script>
<style type="text/css">
	@import 'default.css';
</style>

</head>

<body >

<?

//look for user_id cookie


	include $_view . ".php";

?>


<? if (isset($_COOKIE["st_user_id"]))  { ?>
<br/>
<a href="logout.php" title="<?= $_COOKIE["st_user_id"] ?>">logout</a>
<? } ?>



</body>
</html>