


<div  style="width:525px;  margin: 0 auto; padding-top: 90px ">
	<div class="header-big">
		Login <span class="small-detail"> or <a href="/users/register">sign up</a> with an invite code.</span>
	</div>
	
	
	

<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
	
<form action="/users/login" method="post" accept-charset="utf-8" name="login_form" id="login_form">
		<input type="hidden" name="user_where" value="<?= $_REQUEST['reffer'] ?>" />
	
		<label for="email" class="nForm" >email:</label> 
			<input class="nForm" type="text" name="email" id="email" value="<?= $email ?>" onkeyup="if(event.keyCode==13)document.login_form.password.focus();" /><br clear="left"/>
			<div class="field-message small-detail"></div><br clear="left" />	
			
			
		<label for="password" class="nForm">password:</label> 
			<input class="nForm" type="password" name="password" id="password" onkeyup="if(event.keyCode==13)document.login_form.submit();" /><br clear="left" />
			<div class="field-message small-detail"></div><br clear="left" />	
			
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.login_form.submit();">login</a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	
		<div class="field-message "><a href="/users/forgot">forgot your password?</a></div>

</form>

</div>

</div>	

<script>
	//put the cursor in username when the page loads
	window.load = setTimeout("document.login_form.email.focus()",300);
</script>
