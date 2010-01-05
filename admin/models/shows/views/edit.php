<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=shows.submit" method="post" name="form_edit" >	
<input type="hidden" name="_show_id" value="<?= $_show_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_show_id ?></td>
	</tr>
	<tr>
		<td class="fTitle"> Type:</td>
		<td>
			<select name="_show_type_id" >
			<?  foreach ($q4 as $r) {	?>	
				<option value="<?= $r['show_type_id'] ?>" <? if ($_show_type_id == $r['show_type_id']) {echo 'SELECTED';} ?>  ><?= $r['show_type_name'] ?></option>
			<? } ?>				
			</select>
		</td>	
	</tr>	
	<tr>
		<td class="fTitle"> Title:</td>
		<td><input type="text" name="_title" value="<?= $_title ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle"> Detail:</td>
		<td><textarea name="_detail" cols="55" rows="3" class="cell"><?= $_detail ?></textarea></td>
	</tr>		
		

	<tr>
		<td class="fTitle">Tags:</td>
		<td><textarea name="_tags" cols="55" rows="3" class="cell"><?= $_tags ?></textarea></td>
	</tr>
	
	<tr>
		<td class="fTitle">Thumb:</td>
		<td><img src="<?= PUBLIC_URL . $_thumb   ?>" ><br/>
			<input type="text" name="_thumb" value="<?= $_thumb ?>" size="50" max="150" class="cell" /><br/>
			UPLOAD:<input name="file" type="file" /></td>
	</tr>
	<tr>
		<td class="fTitle">Title Prefix:</td>
		<td><input type="text" name="_title_prefix" value="<?= $_title_prefix ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Video Type IDs:</td>
		<td><input type="text" name="_video_type_ids" value="<?= $_video_type_ids ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	
	<tr>
		<td class="fTitle">Date Air Start:</td>
		<td><input type="text" name="_date_air_start" value="<?= $_date_air_start ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Date Air End:</td>
		<td><input type="text" name="_date_air_end" value="<?= $_date_air_end ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Air Status:</td>
		<td>
			<select name="_air_status_id" >
			<?    foreach ($q2 as $r) {	?>	
				<option value="<?= $r['air_status_id'] ?>" <? if ($_air_status_id== $r['air_status_id']) {echo 'SELECTED';} ?>  ><?= $r['air_status'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Source:</td>
		<td>
			<select name="_source_id" >
				<option value="0">none</option>
			<?  foreach ($q1 as $r) {	?>	
				<option value="<?= $r['source_id'] ?>" <? if ($_source_id == $r['source_id']) {echo 'SELECTED';} ?>  ><?= $r['name'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>	
	
		

	<tr>
		<td class="fTitle">Source Params:</td>
		<td><input type="text" name="_source_params" value="<?= $_source_params ?>" size="50" max="150" class="cell" /></td>
	</tr>	

	<tr>
		<td class="fTitle">Source Params 2:</td>
		<td><input type="text" name="_source_params_2" value="<?= $_source_params_2 ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Source Params 3:</td>
		<td><input type="text" name="_source_params_3" value="<?= $_source_params_3 ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Source Params 4:</td>
		<td><input type="text" name="_source_params_4" value="<?= $_source_params_4 ?>" size="50" max="150" class="cell" /></td>
	</tr>		


	<tr>
		<td class="fTitle">Process Show:</td>
		<td>
			<select name="_show_process_type_id" >
			<?    foreach ($q3 as $r) {	?>	
				<option value="<?= $r['show_process_type_id'] ?>" <? if ($_show_process_type_id== $r['show_process_type_id']) {echo 'SELECTED';} ?>  ><?= $r['show_process_type'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Days:</td>
		<td>
			<? for ( $i = 0; $i <= 6; $i ++) { ?>
				<input type="checkbox" name="_show_process_days[]" <? if (substr_count($_show_process_days, $i) > 0) echo 'CHECKED'  ?> value="<?= $i ?>" ><?= $days[$i] ?>&nbsp;&nbsp;
			<? } ?>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Process Start Hour:</td>
		<td>
			<select name="_show_process_hour_base" >
			<? for ( $i = 0; $i <= 23; $i ++) { ?>
				<option value="<?= $i ?>" <? if ($_show_process_hour_base== $i) {echo 'SELECTED';} ?> ><?= $i ?>:00 </option>
			<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Interval:</td>
		<td>
			<select name="_show_process_hour_interval" >
				<option value="-1">No Daily Repeat</option>
			<? for ( $i = 1; $i <= 12; $i ++) { ?>
				<option value="<?= $i ?>"  <? if ($_show_process_hour_interval== $i) {echo 'SELECTED';} ?> >Each <?= $i ?> Hour(s) </option>
			<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Retry:</td>
		<td>
			<select name="_show_process_hour_retry" >
				<option value="-1">No Retry</option>
			<? for ( $i = 1; $i <= 12; $i ++) { ?>
				<option value="<?= $i ?>"  <? if ($_show_process_hour_retry== $i) {echo 'SELECTED';} ?> >Each <?= $i ?> Hour(s) </option>
			<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Clear on Process:</td>
		<td>
					<select name="_show_process_clear" >
					<? for ( $i = 0; $i <= 1; $i ++) { ?>
						<option value="<?= $i ?>" <? if ($_show_process_clear== $i) {echo 'SELECTED';} ?> ><?= $i ?> </option>
					<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process date last:</td>
		<td><input type="text" name="_process_date_last" value="<?= $_process_date_last ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">Process date next:</td>
		<td><input type="text" name="_process_date_next" value="<?= $_process_date_next ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">Popularity:</td>
		<td><input type="text" name="_popularity" value="<?= $_popularity ?>" size="50" max="150" class="cell" /></td>
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