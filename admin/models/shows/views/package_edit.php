<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=shows.package_submit" method="post" name="form_edit" >	
<input type="hidden" name="_package_id" value="<?= $_package_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_package_id ?></td>
	</tr>
	<tr>
		<td class="fTitle"> Name:</td>
		<td><input type="text" name="_name" value="<?= $_name ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle"> Detail:</td>
		<td><textarea name="_detail" cols="55" rows="3" class="cell"><?= $_detail ?></textarea></td>
	</tr>		
		
	
	<tr>
		<td class="fTitle">Thumb:</td>
		<td><img src="<?= PUBLIC_URL . $_thumb   ?>" ><br/>
			<input type="text" name="_thumb" value="<?= $_thumb ?>" size="50" max="150" class="cell" /><br/>
			UPLOAD:<input name="file" type="file" /></td>
	</tr>


	<tr>
		<td class="fTitle">Status:</td>
		<td> 
			<select name="_status" >
				<option value="1" <?php if ($_status==1) {echo 'SELECTED';} ?>  >Active</option>
				<option value="2" <?php if ($_status==2) {echo 'SELECTED';} ?>>Pending</option>			
				<option value="0" <?php if ($_status==0) {echo 'SELECTED';} ?>>Inactive</option>						
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Order By:</td>
		<td><input type="text" name="_order_by" value="<?= $_order_by ?>" size="50" max="150" class="cell" /></td>
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