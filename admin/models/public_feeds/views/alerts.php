[<a href="/?a=public_feeds.alert_edit&public_id=0">add alert/news item</a>]

<table id="zTable">

<thead>
	<th>Date</th>
	<th>Title</th>
	<th>Detail</th>	
		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
	
?>


<tr>

	<td><?=$r['ts'] ?></td>
	<td style="text-align:left;"><a href="/?a=public_feeds.alert_edit&public_id=<?=$r['public_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
	<td><?= stripslashes(htmlspecialchars($r['detail'])) ?></td>
	<td>[<a href="/?a=public_feeds.alert_delete&public_id=<?=$r['public_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>

