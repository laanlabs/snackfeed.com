<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=public_feeds.program_submit" method="post" name="form_edit" >	
<input type="hidden" name="_feed_program_id" value="<?= $_feed_program_id ?>" />

	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_feed_program_id ?></td>
	</tr>
		

	<tr>
		<td class="fTitle">Show:</td>
		<td>
			<select name="_show_id" >
			<? foreach ($q2 as $r) {	?>
			<option value="<?=$r['show_id'] ?>" <?php if ($_show_id == $r['show_id'] ) {echo 'SELECTED';} ?>  ><?= stripslashes(htmlspecialchars($r['title'])) ?> </option>
		
			<? } ?>
			</select>
		</td>
	</tr>
			

	

	
	<tr>
		<td class="fTitle">video count:</td>
		<td><input type="text" name="_video_count" value="<?= $_video_count ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Date Offset:</td>
		<td><input type="text" name="_video_date_offset" value="<?= $_video_date_offset ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Video Type Ids:</td>
		<td><input type="text" name="_video_type_ids" value="<?= $_video_type_ids ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle">Filters:</td>
		<td><textarea name="_video_filters" cols="55" rows="3" class="cell"><?= $_video_filters ?></textarea></td>
	</tr>	
	<tr>
		<td class="fTitle">preserve grouping:</td>
		<td><input type="text" name="_video_grouping" value="<?= $_video_grouping ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">video fill status:</td>
		<td><input type="text" name="_video_fill_status" value="<?= $_video_fill_status ?>" size="50" max="150" class="cell" /></td>
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