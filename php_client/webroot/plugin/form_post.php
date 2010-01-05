<?
	$_url = "http://www.youtube.com/watch?v=_RAB96S7BAw";
	
	
	$ch = curl_init ($_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	$page_data = curl_exec($ch);



?>




<form name="form_edit" method="post" action="index.php">
	
	<input type="text" name="_url" value="<?= $_url?>" size="85"><br/>
	<textarea name="_body" rows="30" cols="95"><?= $page_data?></textarea> <br/>
	
	<a href="javascript:document.form_edit.submit()">send to processor</a>
	
	
	
	</form>
	