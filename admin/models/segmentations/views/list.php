

<a href="/?a=segmentations.edit&segmentations_id=0">add segmentation</a>

<table id="zTable">

<thead>
	<th>ID</th>
	<th>title</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>

<td style="text-align:left;"><a href="/?a=segmentations.edit&segmentation_id=<?=$r['segmentation_id'] ?>"><?= $r['segmentation_id'] ?></a></td>
<td><?= $r['title'] ?></td>
<td>[<a href="/?a=segmentations.delete&segmentation_id=<?=$r['segmentation_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



