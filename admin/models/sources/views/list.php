<a id="bSubmit" href="/?a=sources.edit&feed_id=0">add new source</a> 

<table id="zTable">

<thead>
	<th>Title</th>
	<th>Details</th>	
	<th>Process</th>	
	
	<th>X</th>	
</thead>
<tbody>




<?

foreach ($q as $r)  {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;"><a href="/?a=sources.edit&source_id=<?=$r['source_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td><?= $r['detail_____'] ?></td>
<td>[<a href="/?a=sources.getShows&source_id=<?=$r['source_id'] ?>">process</a>]</td>
<td>[<a href="/?a=sources.delete&source_id=<?=$r['source_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



