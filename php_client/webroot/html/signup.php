<? 

	$vMSG = "";

	$send_email = isset($_POST['send_email']) ? $_POST['send_email'] : '0';
	if ($send_email == 1 ) {


	$mBODY = "<html><body>";
		$mBODY .= "SIGNUPS<br/>\r\n";
	$mBODY .= "FROM: " . $_POST['input_from'] . "<br/>\r\n";
	$mBODY .= "EMAIL: " . $_POST['input_email'] . "<br/><br/>\r\n";	
	$mBODY .= "HULU: " . $_POST['hulu'] . "<br/><br/>\r\n";		
	$mBODY .= "twitter: " . $_POST['twitter'] . "<br/><br/>\r\n";	
	$mBODY .= "friendfeed: " . $_POST['friendfeed'] . "<br/><br/>\r\n";			
	$mBODY .= "</body></html>";

	
	/* EMAIL HEADERS */
	$sender = "hello@snackfeed.com";
	$headers = "From: " . $sender . "<" . $sender . ">\n";
	$headers .= "Reply-To: " . $sender ." <" . $sender . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html\n";
						  
	mail("hello@snackfeed.com", "SITE MESSAGE: " . $_POST['input_reason'],      $mBODY,      $headers);		
	
	echo "your request has been sent ...";
	die();

	}		
	
	
	
	
	
	
	
	


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<!--
      ___           ___           ___           ___           ___     
     /\  \         /\__\         /\  \         /\  \         /\__\    
    /::\  \       /::|  |       /::\  \       /::\  \       /:/  /    
   /:/\ \  \     /:|:|  |      /:/\:\  \     /:/\:\  \     /:/__/     
  _\:\~\ \  \   /:/|:|  |__   /::\~\:\  \   /:/  \:\  \   /::\__\____ 
 /\ \:\ \ \__\ /:/ |:| /\__\ /:/\:\ \:\__\ /:/__/ \:\__\ /:/\:::::\__\
 \:\ \:\ \/__/ \/__|:|/:/  / \/__\:\/:/  / \:\  \  \/__/ \/_|:|~~|~   
  \:\ \:\__\       |:/:/  /       \::/  /   \:\  \          |:|  |    
   \:\/:/  /       |::/  /        /:/  /     \:\  \         |:|  |    
    \::/  /        /:/  /        /:/  /       \:\__\        |:|  |    
     \/__/         \/__/         \/__/         \/__/         \|__|    
      ___           ___           ___           ___     
     /\  \         /\  \         /\  \         /\  \    
    /::\  \       /::\  \       /::\  \       /::\  \   
   /:/\:\  \     /:/\:\  \     /:/\:\  \     /:/\:\  \  
  /::\~\:\  \   /::\~\:\  \   /::\~\:\  \   /:/  \:\__\ 
 /:/\:\ \:\__\ /:/\:\ \:\__\ /:/\:\ \:\__\ /:/__/ \:|__|
 \/__\:\ \/__/ \:\~\:\ \/__/ \:\~\:\ \/__/ \:\  \ /:/  /
      \:\__\    \:\ \:\__\    \:\ \:\__\    \:\  /:/  / 
       \/__/     \:\ \/__/     \:\ \/__/     \:\/:/  /  
                  \:\__\        \:\__\        \::/__/   
                   \/__/         \/__/         ~~       


-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>
		
				
		Snackfeed
		
				
	</title>
	
	<link rel="stylesheet" href="/static/css/v2/default.css" type="text/css" media="screen"  charset="utf-8">
	<link rel="icon" type="image/png" href="/static/cheese.png"/>
	<link rel="Shortcut Icon" href="/static/favicon.ico" />
	<script src="/static/js/prototype.js" type="text/javascript"></script>


	
	<link rel="stylesheet" href="/static/css/v2/feed_view.css" type="text/css" media="screen"  charset="utf-8">	
</head>
<body>
	
		
<div id="main-wrapper">
	
	<div id="topbar">
		
		<!-- CC added this cheese logo, feel free to remove -->

		<div id="swfLogoHolder2" style="overflow: visible; width: 1px; height:1px; position: absolute; top:26px; left: -55px;">
			<div id="swfLogoHolder" style="">
			</div>
			<img src="/static/images/icons/cheese_guy.png">
		</div>
		
		<div id="logo">
			<a href="/" class="noHover"><img src="/static/images/v2/logo_top.png" width="243" height="35" border="0" alt="snackfeed ~ now with more cheese...." style="vertical-align:bottom;"/></a>
		</div>
		
		
		
		<div id="user-bar">

			
					
					</div>
		
		<div style="height: 15px; width: 100px; background: #ff0000; text-align: center; padding-top:3px; float:right">
			<a style="color: #fff; text-decoration: none" onclick="window.open('/help/feed/','mywindow','scrollbars=1,width=720,height=500')" href="#" title="get help / comment / contact / submit a bug / ">feedback / help</a>

		</div>
		
		
	</div>

	
		<br clear="all" />
		<div id="main-content">


<div style="padding-top: 20px; font-size: 24px; line-height: 36px; width: 625px; margin: auto">
	


	Thanks for participating in our survey! The first 25 responders will receive a free t-shirt courtesy of Snackfeed.com. Please enter your email address below:

<style type="text/css" media="screen">
	
	.question-title
	{
		font-size: 24px;
		font-weight:bold;
		padding-bottom: 35px;
	}
	
	.radioBtn
	{
		float:left;
		width: 140px;

	}

	.radio-box
	{
		padding-left: 25px;
		padding-top: 15px;
		font-weight:normal;
	}
	
	
</style>

<div class="indent-column" style="font-size: 12px; line-height: 22px; padding-top: 25px" >
		<form method="post" action="beta.php" name="form_email" id="form_email">
			<input type="hidden" name="send_email" value="1"/>

	<div id="form-message" class="form-message"></div>


<div class="question-title">
	How many times a week do you visit Hulu?
<div class="radio-box">
	<div class="radioBtn"><input type="radio" CHECKED value="0" name="hulu" /> never </div>     
	<div class="radioBtn"><input type="radio" value="1" name="hulu" /> 1-4 </div>    
	<div class="radioBtn"><input type="radio" value="5" name="hulu" /> 5+ </div>    
	<br clear="both" />              
</div>
</div>

<div class="question-title">
	How many times a week do you visit Twitter?
<div class="radio-box">
	<div class="radioBtn"><input type="radio" CHECKED value="0" name="twitter" /> never </div>     
	<div class="radioBtn"><input type="radio" value="1" name="twitter" /> 1-4 </div>    
	<div class="radioBtn"><input type="radio" value="5" name="twitter" /> 5+ </div>    
	<br clear="both" />              
</div>
</div>

<div class="question-title">
How many times a week to you visit Friendfeed?
<div class="radio-box">
	<div class="radioBtn"><input type="radio" CHECKED value="0" name="friendfeed" /> never </div>     
	<div class="radioBtn"><input type="radio" value="1" name="friendfeed" /> 1-4 </div>    
	<div class="radioBtn"><input type="radio" value="5" name="friendfeed" /> 5+ </div>    
	<br clear="both" />              
</div>
</div>

<div style="height: 20px">
	
</div>


		<label for="input_from" class="nForm" >your name:</label> 
			<input class="nForm" type="text" name="input_from" id="input_from" value=""  /><br clear="left"/>
			<div class="field-message small-detail"></div><br clear="left" />

		<label for="input_email" class="nForm" >your email:</label> 
			<input class="nForm" type="text" name="input_email" id="input_email" value=""  /><br clear="left"/>

			<div class="field-message small-detail"></div><br clear="left" />



			<br clear="left"/>	
			<div id="button-submit" class="button-form" ><a  href="javascript:document.form_email.submit();">send</a></div>	
			<br clear="left"/>	
			<br clear="left"/>


</div>
</div>
</div></div></body></html>


