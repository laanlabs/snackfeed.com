


<table id="zTable">

<thead>
	<th></th>
	<th>Title</th>
	<th>Programs</th>
	<th>Video List</th>	
	<th>Process</th>
	<th>Users</th>	
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td><img src="<?= PUBLIC_URL . $r['thumb']   ?>" ></td>
<td style="text-align:left;"><a href="/?a=channels.edit&channel_id=<?=$r['channel_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td>[<a href="/?a=channels.programs&channel_id=<?=$r['channel_id'] ?>">programs</a>]</td>
<td><a href="/?a=channels.videos&channel_id=<?=$r['channel_id'] ?>">video</a></td>
<td>[<a href="/?a=channels.getVideos&channel_id=<?=$r['channel_id'] ?>">process</a>]</td>
<td>[<a href="/?a=channels.users&channel_id=<?=$r['channel_id'] ?>">users</a>]
	
	[<a href="javascript:openIDPicker(null, null,'channels.tag_picker&channel_id=<?= $r['channel_id'] ?>' )">tags</a>]
	
</td>
<td>[<a href="/?a=channels.delete&channel_id=<?=$r['channel_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



