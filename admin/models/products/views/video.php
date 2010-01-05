<table id="zTable">

<thead>
	<th></th>
	<th>Name</th>
	<th>Link</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td><img src="<?=  $r['thumb']   ?>" height="20" ></td>
<td style="text-align:left;"><?= stripslashes(htmlspecialchars($r['name'])) ?></td>
<td><a href="<?=$r['link'] ?>" target="_new">link</a></td>
<td>[<a href="/?a=products.video_delete&id=<?= $r['id'] ?>&video_id=<?=$r['video_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



<form method="post" action="/?a=products.video&t=picker" name="form_edit">
	<input type="hidden" name="video_id" value="<?= $_REQUEST["video_id"] ?>" />
	<input type="hidden" name="search" value="1" />
	
	<input type="text" name="search_key" size="40" />
	<input type="submit" value="search">
</form>

<?
	if ($_REQUEST['search'])
	{
	

		include 'amazon.php';
		
	}

	
?>