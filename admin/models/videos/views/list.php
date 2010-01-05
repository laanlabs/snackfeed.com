

<table id="zTable">

<thead>
	<th></th>
	<th>Title</th>
	<th>URL</th>	
	<th>Pub</th>	
	<th>added</th>
	<th>products</th>			
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
<td>
	<? if ($r['use_embedded'] > 0) { ?>
		[<a href="<?=$r['url_source'] ?>" target="_new">url</a>]
	<? } else {?>
			[<a href="/lib/swf/junk.swf?url=<?=$r['url_source'] ?>" target="_new">url</a>]
	<? }?> 
	</td>
	<td><?=$r['date_pub'] ?></td>
	<td><?=$r['date_added'] ?></td>
	<td>[<a href="javascript:openIDPicker(null, null,'products.video&video_id=<?= $r['video_id'] ?>' )">products</a>]</td>
<td>[<a href="/?a=videos.delete&video_id=<?= $r['video_id'] ?>&show_id=<?= $_REQUEST['show_id'] ?>&channel_id=<?= $_REQUEST['channel_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



