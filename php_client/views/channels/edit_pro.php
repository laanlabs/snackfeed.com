

<? include "_inc/edit.php" ?>


<div class="two-column-right">
	<div class="header-big">
		 pro features for: <?= $data[0]['title'] ?> <span class="small-detail">give your channel that extra edge </span>
	</div>


	<div class="indent-column">
	
		<div class="form-box">
	
	<div class="form-message"><?= $vMsg ?></div>
	
	
<form action="/channels/edit/<?= $data[0]['channel_id'] ?>" method="post" accept-charset="utf-8" name="edit_form" id="edit_form">
		<input type="hidden" name="_channel_id" value="<?= $_channel_id ?>" />	
		<input type="hidden" name="channel_update" value="1" />
	
<h3>not available yet</h3>


</form>
	
	



</div>

</div>
