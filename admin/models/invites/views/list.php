

<a href="/?a=invites.edit&invite_id=0">add invite code</a>

<table id="zTable">

<thead>
	<th>ID</th>
	<th>Code</th>
	<th>Limit</th>
	<th>Count</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>

<td style="text-align:left;"><a href="/?a=invites.edit&invite_id=<?=$r['invite_id'] ?>"><?= $r['invite_id'] ?></a></td>
<td><a href="/?a=invites.edit&invite_id=<?=$r['invite_id'] ?>"><?= $r['code'] ?></a></td>
<td><?= $r['invite_limit'] ?></td>
<td><?= $r['invite_count'] ?></td>
<td>[<a href="/?a=invites.delete&invite_id=<?=$r['invite_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



