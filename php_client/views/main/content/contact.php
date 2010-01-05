
<? 

	$vMSG = "";

	$send_email = isset($_POST['send_email']) ? $_POST['send_email'] : '0';
	if ($send_email == 1 ) {


	$mBODY = "<html><body>";
	$mBODY .= "FROM: " . $_POST['input_from'] . "<br/>\r\n";
	$mBODY .= "EMAIL: " . $_POST['input_email'] . "<br/><br/>\r\n";	
	$mBODY .= "MESSAGE: " . $_POST['input_message'] . "\r\n";	
	$mBODY .= "</body></html>";

	
	/* EMAIL HEADERS */
	$sender = "hello@snackfeed.com";
	$headers = "From: " . $sender . "<" . $sender . ">\n";
	$headers .= "Reply-To: " . $sender ." <" . $sender . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html\n";
						  
	mail("hello@snackfeed.com", "SITE MESSAGE: " . $_POST['input_reason'],      $mBODY,      $headers);		
	
	$vMSG = "your email has been sent ...";

	}		
	
	
	
	
	
	
	
	


?>


	

<div  style="width:525px;  margin: 0 auto; padding-top: 30px ">
	<div class="header-big">
		contact us <span class="small-detail"> say hello / bitch/ compliment ... </span>
	</div>
	
	<div class="indent-column" style="font-size: 12px; line-height: 22px; padding-top: 25px" >
			<form method="post" action="/main/content/contact" name="form_email">
				<input type="hidden" name="send_email" value="1"/>
	
		<div class="form-message"><?= $vMSG ?></div>
	
	
        
			<label for="input_from" class="nForm" >your name:</label> 
				<input class="nForm" type="text" name="input_from" id="input_from" value="<?= User::$username ?>"  /><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />

			<label for="input_email" class="nForm" >your email:</label> 
				<input class="nForm" type="text" name="input_email" id="input_email" value=""  /><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />

			<label for="input_message" class="nForm" >message:</label> 
			<textarea class="nForm" name="input_message" cols="35" rows="6"></textarea><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />


			<label for="input_reason" class="nForm" >message:</label> 
			<select name="input_reason" class="nForm">
				<option value="general">say hello</option>
				<option value="invite">want an invite code</option>				
				<option value="product">bug (dont panic)</option>
				<option value="product">product feedback</option>
				<option value="other">other</option>
			</select>
			<br clear="left"/>
			<div class="field-message small-detail"></div><br clear="left" />


				<br clear="left"/>	
				<div id="button-submit" class="button-form" ><a href="javascript:document.form_email.submit();">send</a></div>	
				<br clear="left"/>	
				<br clear="left"/>


	</div>

</div>	
