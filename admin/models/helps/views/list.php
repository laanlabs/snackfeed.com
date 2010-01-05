

<a href="/?a=helps.edit&help_id=0">add help code</a>

<table id="zTable">

<thead>
	<th>ID</th>
	<th>controller/action</th>
	<th>title</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>

<td style="text-align:left;"><a href="/?a=helps.edit&help_id=<?=$r['help_id'] ?>"><?= $r['help_id'] ?></a></td>
<td><?= $r['controller'] ?>/<?= $r['action'] ?></a></td>
<td><?= $r['title'] ?></td>
<td>[<a href="/?a=helps.delete&help_id=<?=$r['help_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



