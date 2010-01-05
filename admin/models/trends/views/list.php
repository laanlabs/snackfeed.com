

<a href="/?a=trends.edit&trend_id=0">add trend </a>

<table id="zTable">

<thead>
	<th>ID</th>
	<th>rank</th>	
	<th>Term</th>
	<th>added</th>
	<th>updated</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>

<td style="text-align:left;"><a href="/?a=trends.edit&trend_id=<?=$r['trend_id'] ?>"><?= $r['trend_id'] ?></a></td>
<td><?= $r['rank'] ?></td>
<td><a href="/?a=trends.edit&trend_id=<?=$r['trend_id'] ?>"><?= $r['term'] ?></a></td>
<td><?= $r['date_added'] ?></td>
<td><?= $r['date_updated'] ?></td>
<td>[<a href="/?a=trends.delete&trend_id=<?=$r['trend_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



