
<? 

$vMsg = "";

$send_email = isset($_POST['send_email']) ? $_POST['send_email'] : '0';
if ($send_email == 1 ) {

	$valid = true;
	$_r_email = $_POST['r_email'];
	$_r_name = $_POST['r_name'];

 

	if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $_r_email))
	{
		$vMsg = "please enter a valid email address";
		$valid = false;	
	}

if($valid){
$user_data = array("user_ids" => User::$user_id);
$_sender_email = $user_data[0]['email'];
$_nickname = User::$username;

$_subject = "your friend has invited you to test out snackfeed.com";

$content = "";
$content .= <<<EOT
	

	I am testing out snackfeed.com and I thought this might be an interesting site for you to try as well. 
	Snackfeed is a tool that lets you track your favorite videos and watch what your friends are watching.
	<p/>\r\r
	Snackfeed is invite only right now and your invite code is “snacktastic”
	Click the link below to sign up
	<p/>\r\r
	<a href="http://www.snackfeed.com/users/register?invite=snacktastic">http://www.snackfeed.com/users/register?invite=snacktastic</a>
	<p/>\r\r

	see you on snackfeed  and remember to track me as a friend...
	<p/>\r\r
	{$_nickname}

EOT;

	
	/* EMAIL HEADERS */
	$sender = "hello@snackfeed.com";
	$headers = "From: " . $_nickname . "<" . $_sender_email . ">\n";
	$headers .= "Reply-To: " . $_nickname ." <" . $_sender_email . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html\n";
						  
	mail($_r_email, $_subject,      $content,      $headers);		
	
	$vMsg = "your invite has been sent ...invite another ;)";

}
}		
	
	
	
	
	
	
	
	


?>


	

<div  style="width:525px;  margin: 0 auto; padding-top: 30px ">
	<div class="header-big">
		invite a friend <span class="small-detail"> get more people on the cheese </span>
	</div>
	
	<div class="indent-column" style="font-size: 12px; line-height: 22px; padding-top: 25px" >
			<form method="post" action="/main/content/invite" name="form_email">
				<input type="hidden" name="send_email" value="1"/>
	
		<div class="form-message"><?= $vMsg ?></div>
	
	
        
			<label for="r_name" class="nForm" >friend's name:</label> 
				<input class="nForm" type="text" name="r_name" id="r_name" value=""  /><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />

			<label for="r_email" class="nForm" >friend's email:</label> 
				<input class="nForm" type="text" name="r_email" id="r_email" value=""  /><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />



			<div class="field-message small-detail"></div><br clear="left" />


				<br clear="left"/>	
				<div id="button-submit" class="button-form" ><a href="javascript:document.form_email.submit();">invite</a></div>	
				<br clear="left"/>	
				<br clear="left"/>


	</div>

</div>	
