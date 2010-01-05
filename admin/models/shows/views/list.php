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


<form name="form_filter" action="/?a=shows.list" method="POST">
	
<table width="80%">
	<tr>
		<td>
		
	<input type="hidden" name="o" value="<?= $_offset ?>">
SOURCES:
	<select name="_source_id" >
		<option value="">all</option>
	<?  foreach ($q1 as $r) {	?>	
		<option value="<?= $r['source_id'] ?>" <? if ($_REQUEST['_source_id'] == $r['source_id']) {echo 'SELECTED';} ?>  ><?= $r['name'] ?></option>
	<? } ?>				
	</select>

	TYPE:
		<select name="_show_type_id" >
		<?  foreach ($q2 as $r) {	?>	
			<option value="<?= $r['show_type_id'] ?>" <? if ($_show_type_id == $r['show_type_id']) {echo 'SELECTED';} ?>  ><?= $r['show_type_name'] ?></option>
		<? } ?>				
		</select>


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
	<th></th>
	<th>Title</th>
	<th>Videos</th>
	<th>Source</th>	
	<th>Process</th>
	<th>Options</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td><img src="<?= PUBLIC_URL . $r['thumb']   ?>" ></td>
<td style="text-align:left;"><a href="/?a=shows.edit&show_id=<?=$r['show_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td>
	[<a href="/?a=videos.list&show_id=<?=$r['show_id'] ?>">list videos</a>]
	[<a href="javascript:openIDPicker(null, null,'videos.clear&show_id=<?= $r['show_id'] ?>' )" >clear</a>]
	</td>
<td><a href="/?a=sources.edit&source_id=<?=$r['source_id'] ?>"><?=$r['source_name'] ?></a></td>
<td>[<a href="/?a=shows.getVideos&show_id=<?=$r['show_id'] ?>">getVideos</a>]</td>
<td>[<a href="javascript:openIDPicker(null, null,'shows.tag_picker&show_id=<?= $r['show_id'] ?>' )">tags</a>]
	[<a href="javascript:openIDPicker(null, null,'shows.users&show_id=<?= $r['show_id'] ?>' )">users</a>]
	</td>
<td>[<a href="javascript: if(confirm('Really delete this and related content?'))window.open('/?a=shows.delete&show_id=<?= $r['show_id'] ?>','_self');">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



