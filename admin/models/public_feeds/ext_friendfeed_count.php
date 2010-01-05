<?

$sql = " 
SELECT count(youtube_id) as vCount, sum(likes) as likes, sum(comments) as comments, youtube_id
FROM ext_friendfeed_youtube
GROUP BY youtube_id
ORDER BY vCount DESC, likes DESC, comments DESC ;";
$q = DB::query($sql);


?>

<table border="0" cellspacing="5" cellpadding="5">
	<tr>
		<th></th>
		<th>count</th>
		<th>likes</th>
		<th>comments</th>
		<th>link</th>
	</tr>


<?
foreach ($q as $r) {
?>

	<tr>
		<td><img src="http://i2.ytimg.com/vi/<?= $r['youtube_id'] ?>/default.jpg"/></td>
		<td><?= $r['vCount'] ?></td>
		<td><?= $r['likes'] ?></td>
		<td><?= $r['comments'] ?></td>
		<td><a href="http://youtube.com/?v=<?= $r['youtube_id'] ?>"><?= $r['youtube_id'] ?></a></td>						
	</tr>
	
	
<?	
}

die();

?>

</table>