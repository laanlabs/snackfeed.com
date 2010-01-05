<?




?>


<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=exts.user_submit" method="post" name="form_edit" >	
<input type="hidden" name="_action" value="<?= $_action ?>" />

<tr>
	<td class="fTitle">  user id:</td>
	<td>
				<input type="text" name="_user_id" value="<?= $_user_id ?>" size="50" max="150" class="cell" />
			</td>
</tr>



<tr>
	<td class="fTitle">  ext id:</td>

	<td>
				<input type="text" name="_ext_id" value="<?= $_ext_id ?>" size="50" max="150" class="cell" />
			</td>
</tr>


<tr>
	<td class="fTitle">  username:</td>
	<td>
				<input type="text" name="_username" value="<?= $_username ?>" size="50" max="150" class="cell" />

			</td>
</tr>



<tr>
	<td class="fTitle">  param 1:</td>
	<td>
				<input type="text" name="_param_1" value="<?= $_param_1 ?>" size="50" max="150" class="cell" />
			</td>

</tr>



<tr>
	<td class="fTitle">  process hour interval:</td>
	<td>
				<input type="text" name="_process_hour_interval" value="<?= $_process_hour_interval ?>" size="50" max="150" class="cell" />
			</td>
</tr>


<tr>
	<td class="fTitle">  process date last:</td>
	<td>
				<input type="text" name="_process_date_last" value="<?= $_process_date_last ?>" size="50" max="150" class="cell" />
			</td>
</tr>



<tr>
	<td class="fTitle">  process date next:</td>
	<td>
				<input type="text" name="_process_date_next" value="<?= $_process_date_next ?>" size="50" max="150" class="cell" />
			</td>
</tr>



<tr>
	<td class="fTitle">  status:</td>

	<td>
				<input type="text" name="_status" value="<?= $_status ?>" size="50" max="150" class="cell" />
			</td>
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