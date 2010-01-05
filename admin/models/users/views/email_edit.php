<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=users.email_submit" method="post" name="form_edit" >	
<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />
	<tr>
		<td class="fTitle">ID:</td>
		<td><?= $_user_id ?></td>
	</tr>

	<tr>
		<td class="fTitle">Email Subscribe:</td>
		<td> 
			<select name="_email_subscribe" >
				<option value="1" <?php if ($_email_subscribe==1) {echo 'SELECTED';} ?>  >Active</option>		
				<option value="0" <?php if ($_email_subscribe==0) {echo 'SELECTED';} ?>>Inactive</option>						
			</select>
		</td>
	</tr>	
	<tr>
		<td class="fTitle">Email Days:</td>
		<td>
			<? for ( $i = 0; $i <= 6; $i ++) { ?>
				<input type="checkbox" name="_email_days[]" <? if (substr_count($_email_days, $i) > 0) echo 'CHECKED'  ?> value="<?= $i ?>" ><?= $days[$i] ?>&nbsp;&nbsp;
			<? } ?>
		</td>
	</tr>
	<tr>
		<td class="fTitle">Email Hours:</td>
		<td>
			<select name="_email_hours[]" MULTIPLE size="10">
			<? $_email_hours .= ",";
				for ( $i = 0; $i <= 23; $i ++) { ?>
				<option value="<?= $i ?>" <? if (substr_count($_email_hours, $i.",") > 0) echo 'SELECTED'  ?> ><?= $i ?>:00 </option>
			<? } ?>
		</td>
	</tr>	

	<tr>
		<td class="fTitle">Process date last:</td>
		<td><input type="text" name="_email_date_last" value="<?= $_email_date_last ?>" size="50" max="150" class="cell" /></td>
	</tr>	
	<tr>
		<td class="fTitle">Process date next:</td>
		<td><input type="text" name="_email_date_next" value="<?= $_email_date_next ?>" size="50" max="150" class="cell" /></td>
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