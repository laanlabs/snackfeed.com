


<?

for ($i=0; $i < count($channel) ; $i++) 
{
	
?>
<div style="padding: 5px; border-bottom: 1px solid #ccc">
<img src="<?= $channel[$i]['thumb']?>" style="width: 50px; float: left; padding-right: 5px; padding-bottom; 5px;">
<a href="#?cid=<?= $channel[$i]['channel_id'] ?>"><?= $channel[$i]['title']?></a><br>
<?= $channel[$i]['detail']?>
<br clear="all">
</div>
<?

}

?>




	