

<? include "_inc/edit.php" ?>




<div  class="two-column-right ">
	
	<div class="header-big">
		edit images for: <?= $data[0]['title'] ?>
	</div>
	
	<div class="indent-column">
		<div ><?= $vMsg ?></div>
	<form action="/channels/edit_images/<?= $_REQUEST['id'] ?>" method="post" enctype="multipart/form-data" name="channel_update"  >
		<input type="hidden" name="channel_update" value="1" />
		<div style="height:20px; "></div>	
		
	<h3>Upload an thubnail image for your channel</h3>
	<input name="file" type="file" /> <br/>
	<span class="small-detail">(width="140" height="80")</span>	
	<div style="height:20px; "></div>

	<h3>Upload an large preview image for your channel</h3>
	<input name="file_lg" type="file" /> <br/>
	<span class="small-detail">(width="492" height="209")	</span>
	<div style="height:20px; "></div>


		<div style="height: 30px; border-bottom: 1px solid #000">
			<h3>Or Choose a thumbnail from below</h3>
			
		</div>
		
		
<?
for ($i=0; $i < count($channel_images_thumb) ; $i++) 
{
	
?>
	<div style="padding-top:10px">
		<div style="float: left; width: 20px">
			<input type="radio" name="channel_thumb" value="<?= $channel_images_thumb[$i] ?>" <? if ($i == 0) { ?>checked<? } ?> />
		</div>
		<div style="float: left;">

			<img src="<?= $channel_images_thumb[$i] ?>" style="border: 4px solid #ccc" />
		</div>
			<br clear="both" />
	</div>
		

<? } ?>	


	<div style="height:20px; "></div>


		<div style="height: 30px; border-bottom: 1px solid #000">
			<h3>Or Choose a large preview from below</h3>
			
		</div>
		
		
<?
for ($i=0; $i < count($channel_images_thumb_lg) ; $i++) 
{
	
?>
	<div style="padding-top:10px">
		<div style="float: left; width: 20px">
			<input type="radio" name="channel_thumb_lg" value="<?= $channel_images_thumb_lg[$i] ?>" <? if ($i == 0) { ?>checked<? } ?> />
		</div>
		<div style="float: left;">

			<img src="<?= $channel_images_thumb_lg[$i] ?>" style="border: 4px solid #ccc" />
		</div>
			<br clear="both" />
	</div>
		

<? } ?>	

					
	<div style="height:20px; "></div>		

		<div id="button-submit"  ><a href="javascript:document.channel_update.submit();">update</a></div>	

		</form>	

	</div>
	
	
	
	
</div>