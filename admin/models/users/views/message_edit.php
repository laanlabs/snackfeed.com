<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=users.message_submit" method="post" name="form_edit" >	

<input type="hidden" name="_message_id" value="<?= $_message_id ?>" />

<tr>
	<td class="fTitle">  message id:</td>

	<td><?= $_message_id ?></td>
</tr>



<tr>
	<td class="fTitle">  sender user id:</td>
	<td><input type="text" name="_user_id" value="<?= $_user_id ?>" size="50" max="150" class="cell" /></td>
</tr>



<tr>
	<td class="fTitle"> video id:</td>
	<td><input type="text" name="_video_id" value="<?= $_video_id ?>" size="50" max="150" class="cell" />	
		</td>
</tr>

<tr>
	<td class="fTitle"> video title:</td>
	<td>
		<input type="text" name="_video_title" value="<?= $_video_title ?>" size="50" max="150" class="cell" />

			[<a href="javascript:openIDPicker(document.form_edit._video_id, document.form_edit._video_title,'videos.video_picker' )">pick video</a>]			
		</td>
</tr>

<tr>
	<td class="fTitle"> message body:</td>
	<td><textarea name="_message_body" cols="55" rows="3" class="cell"><?= $_message_body ?></textarea></td>
</tr>


<tr>
	<td class="fTitle"> Reciepients:</td>
	<td>
		<table>	


			<?

			foreach ($q1 as $r) {	
			$rowcount++;	
			?>


			<tr>
				<td>	<input type="checkbox" name="_r_user_ids[]" <? if ($r['count'] > 0) echo 'CHECKED'  ?> value="<?= $r['user_id'] ?>" ></td>
			<td style="text-align:left;"><?= stripslashes(htmlspecialchars($r['email'])) ?></td>

			</tr>
			<? 
			}

			?>

			</table>
	
</td>
</tr>


<tr>
	<td class="fTitle">  isSystem:</td>

	<td><input type="text" name="_isSystem" value="<?= $_isSystem ?>" size="50" max="150" class="cell" /></td>
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