
<style>

.login-div {
	
	border: 1px dotted #ccc;
	background: #fafafa;
	color: #555555;
	text-decoration: none;
	text-align:left;
	font-size: 18px;
  padding: 14px;
	position: relative;
	display: block;
	height: 24px;
	
}

.login-div a{
	text-decoration: none;
	font-size: 24px;
	
}

.login-div a:hover {
	color: #000000;
	text-decoration: underline;
	
}

.button-email {
	
}

.text-email {

	border: none;
	
	color: #999;
	font-size: 16px;
	height: 20px;
	width: 111px;
	
	background-color: rgb(255, 255, 255);
}

.text-wrapper {
	
	border: 1px solid #ccc;
	border-top-color: #999;
	border-left-color: #999;
	margin-right: 8px;
	
}

#newsletter-button:hover {
	opacity:.7;filter: alpha(opacity=70); -moz-opacity: 0.7;
}


</style>

<div  style="width:800px; height: 200px ">
<a class="no-hover" href="/users/register">

<img src="/static/images/v2/content/welcome_small_beta.jpg" width="800" height="187" alt="Welcome" style="border: 0px">

</a>
</div>	



<div class="login-div">

	
	<!-- 	<div style="float:left">
		<a href="/users/login">Login</a> or 
		<a href="/users/register">Sign Up</a>
		</div>
		 -->
		<div style="float:right">
		<a style=" margin-top: 5px; padding-right: 3px; font-weight: bold; background: none; color: #999; font-size: 15px;" href="/main/content/lowdown">Learn a bit more about Snackfeed &raquo;</a>
		</div>
		

		<div >
			
			 <div class="text-wrapper" style=" float: left; width: 111px;">
				
				<input onclick="if(this.value=='enter email') this.value='';" onkeyup="if(event.keyCode==13) signupAlerts();" id="alert_email" class="text-email" type="text" value="enter email" title="Enter an email for us to notify you" />
			 </div>
				  
		   <!-- <input id="newsletter-button" onclick="signupAlerts();" class="button-email" type="submit" value="Let me know" title="Click to send us your contact info" /> -->
			 <div id="newsletter-button" title="Click to send us your contact info" onclick="signupAlerts();" style="position: relative; top: -1px; cursor: pointer; float: left; width: 155px; height: 24px; background:url('/static/images/v2/btn/notify.jpg');">

			 </div>
				
		 </div>
	
</div>

<div align="center" id="gmail-flash-holder" style="position: absolute; display: none; width:100%; text-align: center;">
	<div align="center" id="gmail-flash-message" class="gmail-error"></div>
</div>
