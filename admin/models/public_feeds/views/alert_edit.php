<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=public_feeds.alert_submit" method="post" name="form_edit" >	
<input type="hidden" name="_public_id" value="<?= $_public_id ?>" />

	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_public_id ?></td>
	</tr>
		
	
	<tr>
		<td class="fTitle">Title:</td>
		<td><input type="text" name="_title" value="<?= $_title ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Thumb:</td>
		<td><input type="text" name="_thumb" value="<?= $_thumb ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle">detail:</td>
		<td><textarea name="_detail" cols="55" rows="3" class="cell"><?= $_detail ?></textarea></td>
	</tr>	
	<tr>
		<td class="fTitle">link:</td>
		<td><input type="text" name="_link" value="<?= $_link ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">weight:</td>
		<td><input type="text" name="_weight" value="<?= $_weight ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	
	

</tbody>	
<tfoot>
	<tr>
		<td colspan="2">
		<a id="bSubmit" href="javascript:document.form_edit.submit()">save</a>
		</td>
	</tr>
</tfoot>
</form>	
</table>