
<a id="bSubmit" href="/?a=shows.package_edit&package_id=0">add new package</a> 
<table id="zTable">

<thead>
	<th></th>
	<th>Name</th>
	<th>List</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td><img src="<?= PUBLIC_URL . $r['thumb']   ?>" ></td>
<td style="text-align:left;"><a href="/?a=shows.package_edit&package_id=<?=$r['package_id'] ?>"><?= stripslashes(htmlspecialchars($r['name'])) ?></a></td>
<td>[<a href="/?a=shows.package_shows&package_id=<?=$r['package_id'] ?>">list shows</a>]</td>
<td>[<a href="/?a=shows.package_del&package_id=<?=$r['package_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



