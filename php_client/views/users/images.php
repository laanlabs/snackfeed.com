

<? include "_inc/edit.php" ?>




<div  class="middle-column ">
	
	<div class="header-big">
		profile images
	</div>
	
	<div class="indent-column">
		<div ><?= $vMsg ?></div>
	<form action="/users/images" method="post" enctype="multipart/form-data" name="user_update"  >
		<input type="hidden" name="user_update" value="1" />
		<div style="height:20px; "></div>	

	<div id="upload-file">
		
	
	<div style="float:left; width: 350px">
		
	
	<h3>Upload an image for your profile</h3>
	
	 
	<input name="file" type="file" /> <br/>
	<span class="small-detail">IMPORTANT: width="145" height="80"!!!	
	</div>
	
	<div style="float:left">
	<div id="button-submit"  ><a href="javascript:document.user_update.submit();">update</a></div>		
	</div>
	</div>

	<br clear="both" />
	<div style="height:20px; "></div>

		<div style="height: 30px; border-bottom: 1px solid #000">
			<h3>Or Choose a icon from below</h3>
			
		</div>
		
		
<?
for ($i=0; $i < count($user_images) ; $i++) 
{
	
?>
	<div style="padding-top:10px">
		<div style="float: left; width: 20px">
			<input type="radio" name="user_thumb" value="<?= $user_images[$i] ?>" <? if ($i == 3) { ?>checked<? } ?> />
		</div>
		<div style="float: left;">

			<img src="<?= $user_images[$i] ?>" style="border: 4px solid #ccc" />
		</div>
			<br clear="both" />
	</div>
		

<? } ?>	
					
	<div style="height:20px; "></div>		

		<div id="button-submit"  ><a href="javascript:document.user_update.submit();">update</a></div>	

		</form>	

	</div>
	
	
	
	
</div>