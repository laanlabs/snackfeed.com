
<table id="zTable">

<thead>
	<th>Sent</th>
	<th>From</th>	
	<th>Message</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td><?=$r['date_added'] ?></td>
<td style="text-align:left;"><a href="/?a=users.message_edit&message_id=<?=$r['message_id'] ?>&user_id=<?=$r['user_id'] ?>"><?= stripslashes(htmlspecialchars($r['email'])) ?></a></td>
<td><?=$r['message_body'] ?></td>
<td>[<a href="/?a=users.message_delete&message_id=<?=$r['message_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>


