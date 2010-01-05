<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=shows.tag_submit" method="post" name="form_edit" >	
<input type="hidden" name="_tag_id" value="<?= $_tag_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_tag_id ?></td>
	</tr>
	<tr>
		<td class="fTitle"> Name:</td>
		<td><input type="text" name="_name" value="<?= $_name ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle">Parent:</td>
		<td>
			<select name="_parent_id" >
				<option value="0">none</option>
			<?  foreach ($q1 as $r) {	?>	
				<option value="<?= $r['tag_id'] ?>" <? if ($_parent_id == $r['tag_id']) {echo 'SELECTED';} ?>  ><?= $r['name'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>

	<tr>
		<td class="fTitle">Tag Type:</td>
		<td>
			<select name="_tag_type_id" >
			<?  foreach ($q2 as $r) {	?>	
				<option value="<?= $r['tag_type_id'] ?>" <? if ($_tag_type_id == $r['tag_type_id']) {echo 'SELECTED';} ?>  ><?= $r['tag_type'] ?> - <?= $r['tag_type_detail'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Show In Nav:</td>
		<td> 
			<select name="_show_in_nav" >
				<option value="1" <?php if ($_show_in_nav==1) {echo 'SELECTED';} ?>  >Yes</option>
				<option value="0" <?php if ($_show_in_nav==0) {echo 'SELECTED';} ?>  >No</option>						
			</select>
		</td>
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