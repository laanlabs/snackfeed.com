


<a href="/?a=blogs.edit&blog_id=0">Add a Blog</a>

<a href="/?a=blogs.publish">run pub cron</a>

<table id="zTable">

<thead>
	<th></th>
	<th>Title</th>
	<th>Url</th>	
	<th></th>
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
$rowcount++;	
?>


<tr>
	
<td style="text-align:left;"><a href="/?a=blogs.edit&blog_id=<?=$r['blog_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td><?=$r['url'] ?></td>
<td><a href="/?a=blogs.publish&blog_id=<?=$r['blog_id'] ?>">pub</a></td>
<td>[<a href="/?a=blogs.delete&blog_id=<?=$r['blog_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>



