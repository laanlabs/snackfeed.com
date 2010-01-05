

<table id="zTable">

<thead>
	<th>Title</th>
	<th>Source</th>	
</thead>
<tbody>




<?

foreach ($q as $r) {	
	
?>


<tr>
<td style="text-align:left;"><a href="javascript:setField('<?=$r['show_id'] ?>','<?= stripslashes(htmlspecialchars($r['title'])) ?>');"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td><?=$r['source_name'] ?></td>

</tr>
<? 
}

?>
</tbody>


</table>
