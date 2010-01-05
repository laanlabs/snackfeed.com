

<? include "_inc/edit.php" ?>




<div  class="middle-column">
	
	<div class="header-big">
		your profile info
	</div>
	
	<div class="indent-column">
		
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	

	
<form action="/users/edit" method="post" accept-charset="utf-8" name="login_form" id="login_form">
		<input type="hidden" name="user_id" value="<?= $data['user_id'] ?>" />
		<input type="hidden" name="email_old" value="<?= $data['email'] ?>" />		
		<input type="hidden" name="user_update" value="1" />
	
		<label for="email" class="nForm" >email:</label> 
			<input class="nForm" type="text" name="email" id="email" value="<?= $data['email'] ?>"  /><br clear="left"/>
			<div class="field-message small-detail">required - or else how would we find you</div><br clear="left" />	

			<label for="name_first" class="nForm" >nickname:</label> 
				<input class="nForm" type="text" name="nickname" id="nickname" value="<?= $data['nickname'] ?>"  /><br clear="left"/>
				<div class="field-message small-detail">required</div><br clear="left" />


			<label for="location" class="nForm" >location:</label> 
				<input class="nForm" type="text" name="location" id="location" value="<?= $data['location'] ?>"  /><br clear="left"/>
				<div class="field-message small-detail">optional - where in the world are you?</div><br clear="left" />


			<label for="bio" class="nForm" >bio:</label> 
				<input class="nForm" type="text" name="bio" id="bio" value="<?= $data['bio'] ?>"  /><br clear="left"/>
				<div class="field-message small-detail">optional - what can you say about yourself in one line</div><br clear="left" />
				

			<label for="url" class="nForm" >url:</label> 
				<input class="nForm" type="text" name="url" id="url" value="<?= $data['url'] ?>"  /><br clear="left"/>
				<div class="field-message small-detail">optional - where can people find out more about you</div><br clear="left" />
				

		<label for="name_first" class="nForm" >first name:</label> 
			<input class="nForm" type="text" name="name_first" id="name_first" value="<?= $data['name_first'] ?>"  /><br clear="left"/>
			<div class="field-message small-detail">optional</div><br clear="left" />	
	
		<label for="name_last" class="nForm" >last name:</label> 
			<input class="nForm" type="text" name="name_last" id="name_last" value="<?= $data['name_last']?>" /><br clear="left"/>
			<div class="field-message small-detail">optional</div><br clear="left" />								
			
		
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.login_form.submit();">update</a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	


</form>

</div>	
		
					
		
		
	</div>
	
	
	
	
</div>