
<a id="bSubmit" href="/?a=shows.tag_edit&tag_id=0">add new tag</a> 

<h1>Flag Tags</h1>

<table id="zTable">

<thead>
	<th>Tag</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;">

	<a href="/?a=shows.tag_edit&tag_id=<?=$r['tag_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td>[<a href="/?a=shows.tag_del&tag_id=<?=$r['tag_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>

<h1>Genre Tags</h1>

<table id="zTable">

<thead>
	<th>Tag</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q1 as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;">
		<? if ($r['depth'] > 0 )  echo "---";  ?>
	<a href="/?a=shows.tag_edit&tag_id=<?=$r['tag_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td>[<a href="/?a=shows.tag_del&tag_id=<?=$r['tag_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>