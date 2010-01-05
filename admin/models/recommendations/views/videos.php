

<table id="zTable">

<thead>
	<th></th>
	<th>Title</th>
	<th>segment</th>
	<th>status</th>
	
	<th>URL</th>	
	<th>added</th>			
	<th>X</th>
</thead>
<tbody>

<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	<td><img src="<?=$r['thumb'] ?>" width="100"/></td>
<td style="text-align:left;"><a href="/?a=videos.edit&video_id=<?=$r['video_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td><?=$r['seg_title'] ?></td>
<td><?=$r['status'] ?></td>
<td>
	<? if ($r['use_embedded'] == 1) { ?>
		[<a href="<?=$r['url_source'] ?>" target="_new">url</a>]
	<? } else {?>
			[<a href="/lib/swf/junk.swf?url=<?=$r['url_source'] ?>" target="_new">url</a>]
	<? }?> 

	<td><?=$r['date_added'] ?></td>
<td>[<a href="/?a=recommendations.videos_del&recommendation_id=<?= $r['recommendation_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



