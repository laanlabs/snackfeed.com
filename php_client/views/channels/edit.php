

<? include "_inc/edit.php" ?>


<div class="two-column-right">
	<div class="header-big">
		<?= $_call ?>: <?= $data[0]['title']?> <span class="small-detail"> </span>
	</div>


	<div class="indent-column">
	
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
<form action="/channels/edit/<?= $data[0]['channel_id'] ?>" method="post" accept-charset="utf-8" name="edit_form" id="edit_form">
		<input type="hidden" name="_channel_id" value="<?= $_channel_id ?>" />	
		<input type="hidden" name="channel_update" value="1" />
	
		<label for="title" class="nForm" >title:</label> 
			<input class="nForm" type="text" name="title" id="email" value="<?= $data[0]['title'] ?>"  /><br clear="left"/>
			<div class="field-message small-detail"></div><br clear="left" />	

			<label for="name_first" class="nForm" >subtitle:</label> 
				<input class="nForm" type="text" name="subtitle" id="subtitle" value="<?= $data[0]['subtitle'] ?>"  /><br clear="left"/>
				<div class="field-message small-detail">optional</div><br clear="left" />

		<label for="detail" class="nForm" >details:</label> 
			<textarea class="nForm" name="detail" id="detail" style="height: 150px;"><?= $data[0]['detail'] ?></textarea><br clear="left"/>
			<div class="field-message small-detail" style="top:0px">optional</div><br clear="left" />	
	
							
			
		
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.edit_form.submit();"><?= $_call ?></a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	


</form>
	
	



</div>

</div>
