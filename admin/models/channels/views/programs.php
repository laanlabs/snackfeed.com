[<a href="/?a=channels.program_edit&channel_id=<?= $_REQUEST['channel_id'] ?>&program_id=0">add program</a>]

<table id="zTable">

<thead>
	<th></th>
	<th>Title</th>
	<th>Order</th>		
	<th>X</th>
</thead>
<tbody>




<?

foreach ($q as $r) {	
	
?>


<tr>
	<?
		$_thumb = substr_count( $r['thumb'], "http") ?  $r['thumb']  :  PUBLIC_URL . $r['thumb'] ;
	
	
	?>
	<td><img src="<?= $_thumb  ?>" > </td>
<td style="text-align:left;"><a href="/?a=channels.program_edit&channel_id=<?= $_REQUEST['channel_id'] ?>&program_id=<?=$r['program_id'] ?>"><?= stripslashes(htmlspecialchars($r['title'])) ?></a></td>
<td><?=$r['order_by'] ?></td>
<td>[<a href="/?a=channels.program_delete&channel_id=<?= $_REQUEST['channel_id'] ?>&program_id=<?=$r['program_id'] ?>">del</a>]</td>
</tr>
<? 
}

?>
</tbody>


</table>

