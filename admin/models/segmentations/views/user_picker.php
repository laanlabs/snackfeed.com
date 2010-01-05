<form enctype="multipart/form-data"  action="/?a=segmentations.user_picker_submit" method="post" name="form_edit" >	
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />

<table  id="zTable">
<thead>
	<th>Segment</th>	
	<th>X</th>
	<th>Weight</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;">

	<?= stripslashes(htmlspecialchars($r['title'])) ?></td>
<td><input type="checkbox" name="_segmentation_ids[]" value="<?=$r['segmentation_id'] ?>"   <? if ($r['count'] > 0) echo 'CHECKED'  ?>  /></td>
<td><input type="text" name="_segmentation_weight_<?=$r['segmentation_id'] ?>" value="<?=$r['weight'] ?>" size="3"></td>
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


