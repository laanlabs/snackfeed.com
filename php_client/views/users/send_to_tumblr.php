
<? if ($processed) { ?>
	
	<h3>sent to tumblr</h3>
	
	<a href="javascript:window.close();">close window</a>
	
<? } else { ?>

<div style="padding: 10px">
<form enctype="multipart/form-data"  action="/users/send_to_tumblr" method="post" id="form_edit" name="form_edit" >	
<input type="hidden" name="_t" value="plain" />
<input type="hidden" name="_send_tumblr" value="1" />
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />
<input type="hidden" name="_video_id" value="<?= $_video_id ?>" />
<input type="hidden" name="_detail" value="<?= $_detail ?>" />
<input type="hidden" name="_link" value="<?= $_link ?>" />

<input type="hidden" name="_url_source" value="<?= $_url_source ?>" />
<input type="hidden" name="_use_embedded" value="<?= $_use_embedded ?>" />


	<div class="leftCol">
	 	EMAIL:
	</div>
	<div class="rightCol">
		<input type="text" name="_email" value="<?= $_email ?>"size="20" max="150" style="border: 1px solid #000; width: 300px; height:20px" />	
	</div>
	<br clear="all" />
	<div class="leftCol">
	 	PASSWORD:
	</div>
	<div class="rightCol">
		<input type="password" name="_tumblr_password" value="<?= $_tumblr_password ?>" size="20" max="150" style="border: 1px solid #000; width: 300px; height:20px" />	
	</div>
	<br clear="all" />
	<div class="leftCol">
	</div>
	<div class="rightCol" style="height:20px;">
		<input type="checkbox" name="_save_tumblr_password" value="1"  /> save your password	
	</div>
	<br clear="all" />
	<div class="leftCol">
	 	TITLE:
	</div>
	<div class="rightCol">
			<input type="text" name="_title" value="<?= $_title ?>" size="20" max="150" style="border: 1px solid #000; width: 300px; height:20px" />	
	</div>
	<br clear="all"  />
	<div class="leftCol">
	 	CAPTION:
	</div>
	<div class="rightCol">
		<textarea name="_email_message" style="border: 1px solid #000; width: 300px; height: 90px"><?= $_email_message ?></textarea>
	</div>
	<br clear="all"  />
	<div class="leftCol">
		&nbsp;
	</div>
	<div class="rightCol" style="padding-top: 30px">
		<a class="genericBtn" id="bSubmit" href="javascript:saveForm()">Send This to tumblr</a>	
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
	
function saveForm() {
	var f = document.form_edit;
	var strEmail = f.elements['_email'].value
	var strPass = f.elements['_tumblr_password'].value
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	 
	   

	if ( (reg.test(strEmail) == false) || (strPass.length < 1))
	{
		
		alert('you must enter a email address');
	
		
	} else {
		
		document.form_edit.submit();
	}
	
	
	
}
</script>

<? } ?>
