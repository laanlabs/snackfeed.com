<div id="mainWin">
	<h1><?= $_msg ?></h1>
<div id="input-form">	
				<form id="betaForm" action="index.php" method="post">

					<div class="input-container">
						<input type="text" id="email" name="email" value="<?= $_email_default ?>" class="oversized cleardefault" />
					</div>
				
					<input type="submit" class="button" value="start feeding..." />
				</form>
</div>				
</div>

<script>
document.getElementById('email').focus();
</script>