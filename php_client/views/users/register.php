<div  style="width:675px;  margin: 0 auto; padding-top: 90px;  ">
	
	<div style="height: 100px;">
		<img src="/static/images/v2/content/step1_t.png" />
		
	</div>
	
	
	



<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
	
<form action="/users/register" method="post" accept-charset="utf-8" name="login_form" id="login_form">
	<input type="hidden" name="new_user" value="1" />
		<label for="email" class="nForm" >email:</label> 
		<input class="nForm" type="text" name="email" id="email" value="<?= $email ?>"   />
		<br clear="left"/>
		<div class="field-message small-detail"></div>
		<br clear="left" />
	
		<label for="nickname" class="nForm" >nickname:</label> 
		<input class="nForm" type="text" name="nickname" id="nickname" value="<?= $nickname ?>"   />
		<br clear="left"/>
		<div class="field-message small-detail">something unique -- i.e. buddyguy457 - all lower case no special chars</div>
		<br clear="left" />
		
		<label for="invite" class="nForm" >invite code:</label> 
		<input class="nForm" type="text" name="invite" id="invite" value="thecode"   /><br clear="left"/>
		<div class="field-message small-detail">if you don't have one -- well its actually just right there so you can signup now.<!-- <a href="/main/content/contact"> email us</a> for one....--></div>
		<br clear="left" />
		
		<label for="password" class="nForm c-grey">password:</label> 
		<input class="nForm" type="password" name="password" id="password"  />
		<br clear="left" />
		<div class="field-message small-detail">optional - leave blank for none - you can always set this later</div>
		<br clear="left" />


		<br clear="left"/>	
		<div>
		<div id="button-submit" class="button-form" style="float:left;" ><a href="javascript:document.login_form.submit();">sign up</a></div>
		<br clear="left"/>	
				<br clear="left"/>	
				<br clear="left"/>	

		<div class="field-message ">Already have an account? <a href="/users/login"> Login </a></div>

		</div>

</form>

</div>

</div>	

<script type="text/javascript" charset="utf-8">
function clearText(id, value, pass) 
{
	var el = $(id); //document.getElementById(id);
	if (el && el.value == value)
	{
		el.value = "";
	}
}

</script>
