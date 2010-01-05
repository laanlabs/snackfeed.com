


<a href="/?a=exts.user_edit&ext_id=<?= $_ext_id ?>&user_id=0">Add User</a>

<table id="zTable">

<thead>
	<th>Email</th>
	<th>Username</th>
	<th>URL</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
<td style="text-align:left;"><a href="/?a=exts.user_edit&user_id=<?=$r['user_id'] ?>&ext_id=<?=$r['ext_id'] ?>"><?= stripslashes(htmlspecialchars($r['email'])) ?></a></td>
<td><?=$r['username'] ?></td>
<td>[<a href="/?a=exts.cron&user_id=<?=$r['user_id'] ?>&ext_id=<?=$r['ext_id'] ?>">process</a>]</td>
<td>[<a href="/?a=exts.user_delete&user_id=<?=$r['user_id'] ?>&ext_id=<?=$r['ext_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



