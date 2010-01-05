

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
<td><a href="/?a=uvideos.edit&uvideo_id=<?=$r['uvideo_id'] ?>"><?=$r['uvideo_id'] ?></a></td>
<td style="text-align:left;"><?= stripslashes(htmlspecialchars($r['title'])) ?></td>
<td>[<a href="/?a=uvideos.delete&uvideo_id=<?=$r['uvideo_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



