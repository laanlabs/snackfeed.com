

<? include "_inc/edit.php" ?>




<div  class="middle-column ">
	
	<div class="header-big">
		manage your password
	</div>
	
	<div class="indent-column">
		
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	

	
<form action="/users/password" method="post" accept-charset="utf-8" name="login_form" id="login_form">
		<input type="hidden" name="user_id" value="<?= $data[0]['user_id'] ?>" />
		<input type="hidden" name="user_update" value="1" />
	
<? if (strlen($data['password']) == 0 ) { ?>
	<div class="field-message">please create a password for your account</div><br clear="left" />	
	<input  type="hidden" name="old_password" id="old_password" value=""  />
<? } else { ?>
		<label for="old_password" class="nForm" >old password:</label> 
			<input class="nForm" type="password" name="old_password" id="old_password" value=""  /><br clear="left"/>
		<div class="field-message small-detail"></div><br clear="left" />	

<? } ?>

		<label for="new_password" class="nForm" >new password:</label> 
			<input class="nForm" type="password" name="new_password" id="new_password" value=""  /><br clear="left"/>
			<div class="field-message small-detail"></div><br clear="left" />	
	
		<label for="new_password_confirm" class="nForm" >again:</label> 
			<input class="nForm" type="password" name="new_password_confirm" id="new_password_confirm" value=""  /><br clear="left"/>
			<div class="field-message small-detail">passwords must match</div><br clear="left" />								
			
		
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.login_form.submit();">update</a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	


</form>

</div>	
		
					
		
		
	</div>
	
	
	
	
</div>