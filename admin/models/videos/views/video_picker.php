<form method="post" action="/?a=videos.video_picker&t=picker" name="form_edit">
	
	<select name="show_id" onchange="document.form_edit.submit();">
	<?    foreach ($q1 as $r) {	?>	
		<option value="<?= $r['show_id'] ?>" <? if ($_show_id== $r['show_id']) {echo 'SELECTED';} ?>  ><?= $r['title'] ?></option>
	<? } ?>				
	</select>
	
</form>

<table id="zTable">

<thead>
	<th>Title</th>
	<th>Detail</th>	
</thead>
<tbody>

<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;"><a href="javascript:setField('<?=$r['video_id'] ?>','<?= stripslashes(htmlspecialchars($r['title'])) ?>');"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td><?=$r['detail'] ?></td>

</tr>
<? 
}

?>
</tbody>


</table>


