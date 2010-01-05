<a href="/?a=notifications.edit&notification_id=0">add</a>

<table id="zTable">

<thead>
	<th>Title</th>
	<th>Details</th>	
	<th>Date Start</th>	
	<th>Date End</th>			
	<th>X</th>
</thead>
<tbody>

<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;"><a href="/?a=notifications.edit&notification_id=<?=$r['notification_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td>
	<td><?=$r['date_start'] ?></td>
	<td><?=$r['date_end'] ?></td>
<td>[<a href="/?a=notifications.delete&notification_id=<?=$r[0] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



