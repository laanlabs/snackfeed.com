
<? if ($email_sent) { ?>
	
	<h3>email sent</h3>
	
	<a href="javascript:window.close();">close window</a>
	
<? } else { ?>
<div style="padding: 10px">
<form enctype="multipart/form-data"  action="/users/send_to_friend" method="post" id="form_edit" name="form_edit" >	
<input type="hidden" name="_t" value="plain" />
<input type="hidden" name="_send_email" value="1" />
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />
<input type="hidden" name="_title" value="<?= $_title ?>" />
<input type="hidden" name="_detail" value="<?= $_detail ?>" />
<input type="hidden" name="_link" value="<?= $_link ?>" />

	<div class="leftCol">
	 	TO:
	</div>
	<div class="rightCol">
		<input type="text" name="_email_to" value="" size="20" max="150" style="border: 1px solid #000; width: 300px; height:20px" />	
	</div>
	<br clear="all" />
	<div class="leftCol">
	 	FROM:
	</div>
	<div class="rightCol">
		<input type="text" name="_email_from" value="<?= $_email ?>" size="20" max="150" style="border: 1px solid #000; width: 300px; height:20px" />	
	</div>
	<br clear="all" />
	<div class="leftCol">
	 	MESSAGE:
	</div>
	<div class="rightCol">
		<textarea name="_email_message" style="border: 1px solid #000; width: 300px; height: 150px"><?= $_email_message ?></textarea>
	</div>
	<br clear="all"  />
	<div class="leftCol">
		&nbsp;
	</div>
	<div class="rightCol" style="padding-top: 30px">
		<a class="genericBtn" id="bSubmit" href="javascript:saveForm()">Send This Video</a>	
	</div>
	<br clear="all" />
	
	<div style="position: absolute; top: 35px ; left: 500px; width: 220px">
			<img src="<?= $_thumb ?>" style="width: 120px; border:1px solid #000" /><br/>
			<span><?= $_title ?></span><br/>
			<span style="color:#ccc"><?= $_detail ?></span><br/>
	</div>
	
	
		
</form>	
</div>



<script>	
	
saveForm = function() {
	var f = document.form_edit;
	var strEmail = f.elements['_email_to'].value
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	 
	   

	if (reg.test(strEmail) == false)
	{
		
		alert('you must enter a email address');
	
		
	} else {
		
		document.form_edit.submit();
	}
	
	
	
}
</script>

<? } ?>
