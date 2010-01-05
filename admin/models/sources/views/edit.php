<table id="formTable" >
<form action="/?a=sources.submit" method="post" name="form_edit" >	
<input type="hidden" name="_source_id" value="<?= $_source_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_source_id ?></td>
	</tr>
	<tr>
		<td class="fTitle"> Title:</td>
		<td><input type="text" name="_name" value="<?= $_name ?>" size="50" max="150" class="cell" /></td>
	</tr>

	<tr>
		<td class="fTitle"> Detail:</td>
		<td><textarea name="_detail" cols="55" rows="3" class="cell"><?= $_detail ?></textarea></td>
	</tr>		
		

	<tr>
		<td class="fTitle">URL:</td>
		<td><textarea name="_url" cols="55" rows="3" class="cell"><?= $_url ?></textarea></td>
	</tr>
	<tr>
		<td class="fTitle"> Params:</td>
		<td><input type="text" name="_params" value="<?= $_params ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle"> Filters:</td>
		<td><input type="text" name="_filters" value="<?= $_filters ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Process Type:</td>
		<td>
			<select name="_process_type_id" >
			<?  foreach ($q1 as $r) {	?>	
				<option value="<?= $r['process_type_id'] ?>" <? if ($_process_type_id== $r['process_type_id']) {echo 'SELECTED';} ?>  ><?= $r['process_type'] ?></option>
			<? } ?>				
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Process Lib:</td>
		<td><input type="text" name="_process_lib" value="<?= $_process_lib ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">Use Embedded:</td>
		<td>
					<select name="_use_embedded" >
					<? for ( $i = 0; $i <= 1; $i ++) { ?>
						<option value="<?= $i ?>" <? if ($_use_embedded== $i) {echo 'SELECTED';} ?> ><?= $i ?> </option>
					<? } ?>
		</td>
	</tr>		
	<tr>
		<td class="fTitle">Use Link:</td>
		<td>
					<select name="_use_link" >
					<? for ( $i = 0; $i <= 1; $i ++) { ?>
						<option value="<?= $i ?>" <? if ($_use_link== $i) {echo 'SELECTED';} ?> ><?= $i ?> </option>
					<? } ?>
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
				<option value="<?= $i ?>"  <? if ($_process_hour_interval== $i) {echo 'SELECTED';} ?> >Each <?= $i ?> Hour(s) </option>
			<? } ?>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Clear on Process:</td>
		<td>
					<select name="_process_clear" >
					<? for ( $i = 0; $i <= 1; $i ++) { ?>
						<option value="<?= $i ?>" <? if ($_process_clear== $i) {echo 'SELECTED';} ?> ><?= $i ?> </option>
					<? } ?>
		</td>
	</tr>		
	<tr>
		<td class="fTitle">Client Lib:</td>
		<td><input type="text" name="_client_lib" value="<?= $_client_lib ?>" size="50" max="150" class="cell" /></td>
	</tr>
	<tr>
		<td class="fTitle">Proxy URL:</td>
		<td><input type="text" name="_proxy_url" value="<?= $_proxy_url ?>" size="50" max="150" class="cell" /></td>
	</tr>			
	<tr>
		<td class="fTitle">Source Status:</td>
		<td> 
			<select name="_status" >
				<option value="1" <?php if ($_status==1) {echo 'SELECTED';} ?>  >Default</option>
				<option value="2" <?php if ($_status==2) {echo 'SELECTED';} ?>>Optional</option>			
				<option value="0" <?php if ($_status==0) {echo 'SELECTED';} ?>>Not Available</option>						
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Source Order By:</td>
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