<a href="/?a=reports.batches">all</a>
<a href="/?a=reports.batches&errors=1">only errors</a>
<a href="/?a=reports.batches&slow=1">slow</a>
<table border="1">
<tr>
	<td>status</td>
	<td>show/source</td>
	<td>videos</td>
	<td>time</td>
	<td>date</td>	
	<td>scheduled</td>			
</tr>	
<? foreach ($q as $r) { ?>


<tr>
	<td><?= $r['status'] ?></td>
	<td><?= $r['title'] ?> / <?= $r['source_name'] ?></td>
	<td><?= $r['total'] ?></td>
	<td><?= $r['millseconds'] ?></td>
	<td><?= $r['date_started'] ?></td>	
	<td><?= $r['date_scheduled'] ?></td>			
</tr>		
		

<? } ?>

</table>