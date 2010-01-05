<form enctype="multipart/form-data"  action="/?a=channels.tag_picker_submit" method="post" name="form_edit" >	
<input type="hidden" name="_channel_id" value="<?= $_channel_id ?>" />

<table  id="zTable">
<thead>
	<th>Tag</th>	
	<th>X</th>
	<th>X</th>
</thead>
<tbody>
	<tr style="background-color: acacac;">
		<td colspan="3"><strong>Flag Tags</strong></td>	
	</tr>



<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;">

	<a href="/?a=channels.tag_edit&tag_id=<?=$r['tag_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td><input type="checkbox" name="_tag_ids[]" value="<?=$r['tag_id'] ?>"   <? if ($r['count'] > 0) echo 'CHECKED'  ?>  /></td>
<td><input type="text" name="_tag_weight_<?=$r['tag_id'] ?>" value="<?=$r['weight'] ?>" size="3"></td>
</tr>
<? 
}

?>



<tr style="background-color: acacac;">
	<td colspan="3"><strong>Genre Tags</strong></td>	
</tr>





<?

foreach ($q1 as $r) {	
$rowcount++;	
?>

<?
	$_check = "";
	if ( $r['parent_id'] != '0') {
		
		$_check =  'onClick="checkParent(\'' . $r["parent_id"] . '\', \'' . $r["tag_id"] . '\' )"';
		
	}

?>


<tr>
<td style="text-align:left;">
		<? if ($r['depth'] > 0 )  echo "---";  ?>
	<a href="/?a=channels.tag_edit&tag_id=<?=$r['tag_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td><input type="checkbox" name="_tag_ids[]" <? if ($r['count'] > 0) echo 'CHECKED'  ?> value="<?=$r['tag_id'] ?>" id="box_<?=$r['tag_id'] ?>" <?= $_check ?> />

	
	</td>
<td><input type="text" name="_tag_weight_<?=$r['tag_id'] ?>" value="<?=$r['weight'] ?>" size="3"></td>
</tr>
<? 
}

?>
</tbody>
	
<tfoot>
	<tr>
		<td colspan="3">
		<a id="bSubmit" href="javascript:document.form_edit.submit()">save</a>
		</td>
	</tr>
</tfoot>

</table>


<script>

function checkParent(id, tid)
{
	var id_name = 'box_' + id;
	var tid_name = 'box_' + tid;
	
	var a=document.form_edit.elements;
	var pcb = document.getElementById(id_name);
	
	var cb = document.getElementById(tid_name);
	
	if (cb.checked == true)
	{
		pcb.checked = true;	
	}
	
	if (cb.checked == false)
	{
		//pcb.checked = false;	
	}
	
	
	//cb.checked = true;
	//alert(pcb.checked);
	
	
}

</script>