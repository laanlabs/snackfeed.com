<?

for ($i=0; $i < count($video) ; $i++) 
{
	
?>
<div id="videoFavList_<?= $i ?>" style="padding: 5px; border-bottom: 1px solid #ccc">
<a href="#?sid=<?= $video[$i]['show_id']?>&vid=<?= $video[$i]['video_id']?>">
<img src="<?= $video[$i]['thumb']?>"  
	title="<?= $video[$i]['detail']?>"
	style="border: 0px; width: 50px; float: left; padding-right: 5px; padding-bottom; 5px;">
<?= $video[$i]['title']?></a>

[<a href="javascript:snackWatcher.removeFromVidsList('<?= $video[$i]['video_id']?>','videoFavList_<?= $i ?>')">remove</a>]
<br clear="all">
</div>
<?

}

?>

