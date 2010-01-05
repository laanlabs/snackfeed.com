
<form   action="/?a=channels.users_submit" method="post" name="form_edit" >
	<input type="hidden" name="_channel_id" value="<?= $_REQUEST['channel_id'] ?>" />

<table id="zTable">

<thead>
	<th></th>
	<th>email</th>
	<th>name</th>
	<th>role</th>
	<th>status</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td>
	<input type="checkbox" name="_user_ids[]" <? if (strlen($r['cu_user_id']) > 0) echo 'CHECKED'  ?> value="<?= $r['user_id'] ?>" >
</td>
<td style="text-align:left;"><a href="/?a=users.edit&user_id=<?=$r['user_id'] ?>"><?= stripslashes(htmlspecialchars($r['email'])) ?></a></td>
<td><?=$r['name_last'] ?>, <?=$r['name_first'] ?></td>
<td><input type="text" name="_role_<?=$r['user_id'] ?>" value="<?=$r['role'] ?>" size="3" /></td>
<td><input type="text" name="_status_<?=$r['user_id'] ?>" value="<?=$r['status'] ?>" size="3" /></td>
</tr>
<? 
}

?>
</tbody>

<tfoot>
	<tr>
		<td colspan="2">
		<a id="bSubmit" href="javascript:document.form_edit.submit()">save</a>
		</td>
	</tr>
</tfoot>
</table>

</form>

