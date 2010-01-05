

<? include "_inc/edit.php" ?>


<div class="two-column-right">
	<div class="header-big">
		invite people to:  <?= $data[0]['title']?> <span class="small-detail"> </span>
	</div>


	<div class="indent-column">
	
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
<form action="/channels/invite/<?= $data[0]['channel_id'] ?>" method="post" accept-charset="utf-8" name="edit_form" id="edit_form">
		<input type="hidden" name="_channel_id" value="<?= $_channel_id ?>" />	
		<input type="hidden" name="channel_invite" value="1" />
	
		<label for="email" class="nForm" >email:</label> 
			<input class="nForm" type="text" name="email" id="email" value=""  /><br clear="left"/>
			<div class="field-message small-detail">email of person </div><br clear="left" />	

			<label for="name_first" class="nForm" >purpose:</label> 
	
			<select name="channel_role"  class="nForm">		
				<? for ($i=0; $i < count($channel_roles) ; $i++) { ?>
					<option value="<?= $channel_roles[$i]['channel_role'] ?>"><?= $channel_roles[$i]['channel_role_desc'] ?></option>
				<? } ?>
			
			</select>
				
				<br clear="left"/>
				<div class="field-message small-detail">what you want them to do with this channel</div><br clear="left" />

	<label for="message" class="nForm" >message:</label> 
			<textarea class="nForm" name="message" id="message" style="height: 150px;"></textarea><br clear="left"/>
			<div class="field-message small-detail" style="top:0px">give them a fun reason to join this channel - everybody likes to have fun</div><br clear="left" />	
	

	
							
			
		
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.edit_form.submit();">send invite</a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	


</form>
	
	



</div>

</div>
