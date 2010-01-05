

<table id="zTable">
<form   action="/?a=users.shows_submit" method="post" name="form_edit" >
	<input type="hidden" name="_user_id" value="<?= $_user_id ?>" />	
<thead>
	<th>Include</th>
	<th>Title</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td>	<input type="checkbox" name="_show_ids[]" <? if ($r['count'] > 0) echo 'CHECKED'  ?> value="<?= $r['show_id'] ?>" ></td>
<td style="text-align:left;"><a href="/?a=shows.edit&show_id=<?=$r['show_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>

</tr>
<? 
}

?>
<tfoot>
	<tr>
		<td colspan="2">
		<a id="bSubmit" href="javascript:document.form_edit.submit()">save</a>
		</td>
	</tr>
</tfoot>
</tbody>

</form>
</table>



