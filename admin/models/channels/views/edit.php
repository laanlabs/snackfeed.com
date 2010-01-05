<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=channels.submit" method="post" name="form_edit" >	
<input type="hidden" name="_channel_id" value="<?= $_channel_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_channel_id ?></td>
	</tr>
	<tr>
		<td class="fTitle"> Channel Type:</td>
		<td><input type="text" name="_channel_type" value="<?= $_channel_type ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle"> Title:</td>
		<td><input type="text" name="_title" value="<?= $_title ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle"> Subtitle:</td>
		<td><input type="text" name="_subtitle" value="<?= $_subtitle ?>" size="50" max="150" class="cell" /></td>
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
		<td class="fTitle">Thumb Lg:</td>
		<td><input type="text" name="_thumb_lg" value="<?= $_thumb_lg ?>" size="50" max="150" class="cell" /><br/></td>
	</tr>	
	<tr>
		<td class="fTitle">URL:</td>
		<td><input type="text" name="_url" value="<?= $_url ?>" size="50" max="150" class="cell" /><br/></td>
	</tr>		
	<tr>
		<td class="fTitle">Order Videos By:</td>
		<td> 
			<select name="_program_order_by_type_id" >
				<option value="1" <?php if ($_program_order_by_type_id==1) {echo 'SELECTED';} ?>  >Show/Video Order</option>
				<option value="2" <?php if ($_program_order_by_type_id==2) {echo 'SELECTED';} ?>>Date</option>			
					
			</select>
		</td>
	</tr>
	
	<tr>
		<td class="fTitle">Date created:</td>
		<td><input type="text" name="_date_created" value="<?= $_date_created ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Date Updated:</td>
		<td><input type="text" name="_date_updated" value="<?= $_date_updated ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Process Automatically:</td>
		<td>
			<select name="_process_type_id" >
						<? for ( $i = 0; $i <= 1; $i ++) { ?>
							<option value="<?= $i ?>"  <? if ($_process_type_id== $i) {echo 'SELECTED';} ?> ><?= $i ?>  </option>
						<? } ?>			
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Days:</td>
		<td>
			<? for ( $i = 0; $i <= 6; $i ++) { ?>
				<input type="checkbox" name="_process_days[]" <? if (substr_count($_process_days, $i) > 0) echo 'CHECKED'  ?> value="<?= $i ?>" ><?= $days[$i] ?>&nbsp;&nbsp;
			<? } ?>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Process Start Hour:</td>
		<td>
			<select name="_process_hour_base" >
			<? for ( $i = 0; $i <= 23; $i ++) { ?>
				<option value="<?= $i ?>" <? if ($_process_hour_base== $i) {echo 'SELECTED';} ?> ><?= $i ?>:00 </option>
			<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Interval:</td>
		<td>
			<select name="_process_hour_interval" >
				<option value="-1">No Daily Repeat</option>
			<? for ( $i = 1; $i <= 12; $i ++) { ?>
				<option value="<?= $i ?>"  <? if ($_process_hour_interval== $i) {echo 'SELECTED';} ?> >Each <?= $i ?> Hour(s) </option>
			<? } ?>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Retry:</td>
		<td>
			<select name="_process_hour_retry" >
				<option value="-1">No Retry</option>
			<? for ( $i = 1; $i <= 12; $i ++) { ?>
				<option value="<?= $i ?>"  <? if ($_process_hour_retry== $i) {echo 'SELECTED';} ?> >Each <?= $i ?> Hour(s) </option>
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