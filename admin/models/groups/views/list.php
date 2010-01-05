

<a href="/?a=groups.edit&group_id=0">add group </a>

<table id="zTable">

<thead>
	<th>ID</th>
	<th>Title</th>
	<th>start</th>
	<th>created</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>

<td style="text-align:left;"><a href="/?a=groups.edit&group_id=<?=$r['group_id'] ?>"><?= $r['group_id'] ?></a></td>
<td><a href="/?a=groups.edit&group_id=<?=$r['group_id'] ?>"><?= $r['title'] ?></a></td>
<td><?= $r['date_start'] ?></td>
<td><?= $r['date_created'] ?></td>
<td>[<a href="/?a=groups.delete&group_id=<?=$r['group_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



