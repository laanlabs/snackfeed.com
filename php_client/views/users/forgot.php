<div  style="width:525px;  margin: 0 auto; padding-top: 80px ">
	<div class="header-big">
		forgot password? <span class="small-detail"> how could you forget - we don't forget you...</span>
	</div>
	
	
	
	



<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
<? if (!$email_sent) {?>
	
<form action="/users/forgot" method="post" accept-charset="utf-8" name="login_form" id="login_form">
	<input type="hidden" name="email_user" value="1" />
		<label for="email" class="nForm" >email:</label> 
		<input class="nForm" type="text" name="email" id="email" value="<?= $email ?>"   />
		<br clear="left"/>
		<div class="field-message small-detail">you will recieve an email with your password </div>
		<br clear="left" />
	


		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.login_form.submit();">sent it</a></div>	

</form>

<? } else { ?>

<h3>Your password has been mailed to you -- you should get it shortly....</h3>


<? }  ?>
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