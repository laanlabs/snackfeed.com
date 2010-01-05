




<script >
	function goNext(dir)
	{
		document.form_filter.o.value = document.form_filter.o.value*1 + dir;
		document.form_filter.submit();
		
	}
	
	function goFilter()
	{
		document.form_filter.o.value = 0;
		document.form_filter.submit();
		
		
	}
	
</script>

<div style="float:right; padding-right: 10px">
	<a href="/?a=users.edit&user_id=0" >Add User</a>	
</div>

<form name="form_filter" action="/?a=users.list" method="POST">
	
<table width="80%">
	<tr>
		<td>
		
	<input type="hidden" name="o" value="<?= $_offset ?>">



	&nbsp;&nbsp;&nbsp;
	<input type="text" name="_filter" value="<?= $_REQUEST['_filter'] ?>" size="20" / >

	
	[<a href="javascript:goFilter()">filter</a>]
	</td>
	<td align="right">
	
	[<a href="javascript:goNext(-<?= $_page_size ?>)">prev</a>]
	[<a href="javascript:goNext(<?= $_page_size ?>)">next</a>]
	
	
	</td>
	</tr>
</table>

	
	
</form>

<table id="zTable">

<thead>
	<th>nickname</th>
	<th>email</th>
	<th>Favorites</th>
	<th>Segments</th>	
	<th>Messages</th>
	<th>Newsletter</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;"><a href="/?a=users.edit&user_id=<?=$r['user_id'] ?>"><?= stripslashes(htmlspecialchars($r['nickname'])) ?></a></td>
<td style="text-align:left;"><a href="/?a=users.edit&user_id=<?=$r['user_id'] ?>"><?= stripslashes(htmlspecialchars($r['email'])) ?></a></td>
<td>[<a href="/?a=users.shows&user_id=<?=$r['user_id'] ?>">shows</a>]</td>
<td>[<a href="javascript:openIDPicker(null,null,'segmentations.user_picker&user_id=<?=$r['user_id'] ?>')">segs</a>]</td>
<td>[<a href="/?a=users.messages&user_id=<?=$r['user_id'] ?>">in</a>][<a href="/?a=users.message_edit&message_id=0&user_id=<?=$r['user_id'] ?>">send</a>]</td>
<td>[<a href="/?a=users.email_edit&user_id=<?=$r['user_id'] ?>">email</a>]</td>
<td>[<a href="/?a=users.delete&user_id=<?=$r['user_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



