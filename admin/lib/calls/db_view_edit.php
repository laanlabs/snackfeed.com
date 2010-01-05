
<?
$_submit = isset($_submit)? $_submit : $_base_table . "s.submit" ;


?>

<table id="formTable" >
<form enctype="multipart/form-data"  action="/?a=<?= $_submit ?>" method="post" name="form_edit" >	
<?

foreach ($_fields as $field_name => $field_value)
{


?>

<tr>
	<td class="fTitle"> <?= str_replace("_", " ", $field_name) ?>:</td>
	<td>
		<? if (stristr($field_name, 'detail')) {?>
		<textarea name="<?= $field_name ?>" rows="3" cols="65" class="cell" ><?= ${$field_name} ?></textarea>	

		<? } else {?>
		<input type="text" name="<?= $field_name ?>" value="<?= ${$field_name} ?>" size="50" max="150" class="cell" />
		<? }?>
	</td>
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
</form>	
</table>