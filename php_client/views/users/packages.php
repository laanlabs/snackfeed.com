<? include "_inc/edit.php" ?>




<div  class="middle-column ">
	<div class="header-big">
		follow shows <span class="small-detail"> here are some groups of shows you might be interested in.</span>
	</div>

<? 		if (!$results) {?>


	
	<div style="padding-top: 20px; padding-bottom: 10px; font-size: 14px; border-bottom: 1px solid #ccc;">
		to get started choose a few groups of shows -- you can always add them individually later.
		
	</div>	
	


	<div class="indent-column" style="padding-top: 20px">
<form action="/users/packages" method="post" accept-charset="utf-8" name="edit_form" id="edit_form">
	<input type="hidden" name="package_update" value="1" />
		
<? 		for ($i = 0 ; $i < count($data) ; $i++)
			{
?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $data[$i]['thumb']  ?>"/>
		<div class="item-header"><?= stripslashes($data[$i]['name']) ?></div>
			
		 <?= $data[$i]['detail'] ?> -
		 <?= $data[$i]['shows_count'] ?> shows including: 
		 <?= $data[$i]['shows_list'] ?> 
		 <div style="position: absolute; bottom: 3px; left: 160px; font-size: 14px; ">
		 	<input type="checkbox" name="_package_ids[]" value="<?= $data[$i]['package_id']  ?>" id="check_<?= $data[$i]['package_id']  ?>" /> <a href="javascript:checkBox('check_<?= $data[$i]['package_id']  ?>')">follow these shows</a>
		 </div>
	</div>

<?		}    ?>
	
	

		<br clear="left"/>	
			<br clear="left"/>	
		<div id="button-submit" class="button-form" ><a href="javascript:document.edit_form.submit();">add shows</a></div>	

</form>



</div>




<? } else { ?>
	
	<div class="indent-column" style="padding-top: 20px; font-size: 14px">
	you are now following <?= $shows_count ?> shows -- goto your <a href="/users">home</a> to see updates or <a href="/shows">browse</a> for more shows to follow.
	
	<br/>
	<br/>
	remember, you can alsways go to your <a href="/users/profile/<?= User::$user_id ?> ">dashboard</a> to manage the shows you are following.
	
	</div>
	
<? } ?>	


</div>

<script type="text/javascript" charset="utf-8">
	
	function checkBox(id)
	{
		if ($(id).checked) { $(id).checked = false; } else {$(id).checked = true;}
		
	}

</script>
