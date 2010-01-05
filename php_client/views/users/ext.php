

<? include "_inc/edit.php" ?>




<div  class="middle-column">
	
	<div class="header-big">
		external video accounts
	</div>
	
	<div class="indent-column">
		
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	

	
<form action="/users/ext" method="post" accept-charset="utf-8" name="login_form" id="login_form">
		<input type="hidden" name="ext_update" value="1" />

<? 		for ($i = 0 ; $i < count($data) ; $i++)
			{
?>
	
		<label for="email" class="nForm" ><?= $data[$i]['name'] ?>:</label> 
			<input class="nForm" type="text" name="ext_id_<?= $data[$i]['ext_id'] ?>" id="ext_id_<?= $data[$i]['ext_id'] ?>" value="<?= $data[$i]['username'] ?>"  /><br clear="left"/>
			<div class="field-message small-detail"><?= $data[$i]['detail'] ?></div><br clear="left" />	


<?		}    ?>							
			
		
		<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.login_form.submit();">update</a></div>	
		<br clear="left"/>	
		<br clear="left"/>	
			<br clear="left"/>	


</form>

</div>	
		
					
		
		
	</div>
	
	
	
	
</div>