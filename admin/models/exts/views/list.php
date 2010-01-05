


<a href="/?a=exts.edit&ext_id=0">Add an External Source</a>

<a href="/?a=exts.cron">cron</a>

<table id="zTable">

<thead>
	<th>Code</th>
	<th>Name</th>
	<th>Users</th>
	<th>Process</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td><?=$r['ext_code'] ?></td>	
<td style="text-align:left;"><a href="/?a=exts.edit&ext_id=<?=$r['ext_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td><a href="/?a=exts.users&ext_id=<?=$r['ext_id'] ?>">users</a></td>
<td><a href="/?a=exts.cron&ext_id=<?=$r['ext_id'] ?>">process</a></td>
<td>[<a href="/?a=exts.delete&ext_id=<?=$r['ext_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



