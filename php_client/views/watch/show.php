

<div id="playerWrapper" style="width: 100%; height: 100%;">

	<div id="playerHolder" style="width: 100%; background-color: #000000; text-align: center">
		<div id="swfHolder" ></div>
	</div>
	<div id="showInfo" style="float:left; width:260px; padding-top:15px; padding-left:30px; border: 0px solid red">
	
		<div id="btnDefault" >
			
			<a id="btnPrev" href="javascript:snackWatcher.playMove(-1);">prev</a>
			<a id="btnNext" href="javascript:snackWatcher.playMove(1);">next</a>
			<a id="btnPause" href="javascript:snackWatcher.togglePause();">pause</a>
			<a id="btnMute" href="javascript:snackWatcher.toggleMute();">mute</a>
			<div style="position: relative; font-size:10px; top: 7px; color: #999999;">
				<text id="playTimeText"></text>&nbsp;&nbsp;
				<text id="playerBufferingText"></text>
			</div>
		</div>
		
	
		<div style="padding: 50px 0 30px 0">
			<span style="color:#ccc"><?= $show['meta']['title'] ?><?= $show['meta']['detail'] ?></span><br/>
			<img src="<?= $show['meta']['thumb'] ?>" style="border:1px solid #ccc;"><br/>
		</div>
		 
		<div>
			<a href="javascript:welcomeView.renderSendToFriend(snackWatcher.arrayVideos[snackWatcher.currentIndex])" >send to friend</a><br/>
			<div><a href="javascript:snackFeed.formController.loadExternalForm( $('videoLike') , '/users/flag_video?like&video_id=' + snackWatcher.arrayVideos[snackWatcher.currentIndex] + '&user_id=' + userManager.userId)" >mark as like</a> <span id="videoLike"></span></div>
			<div><a href="javascript:snackFeed.formController.loadExternalForm( $('videoDislike') , '/users/flag_video?dislike&video_id=' + snackWatcher.arrayVideos[snackWatcher.currentIndex] + '&user_id=' + userManager.userId)" >mark as dislike</a> <span id="videoDislike"></span></div>
			<div><a href="javascript:snackFeed.formController.loadExternalForm( $('videoWatch') , '/users/mark_video_watched?&video_id=' + snackWatcher.arrayVideos[snackWatcher.currentIndex] + '&user_id=' + userManager.userId)" >mark as watched</a> <span id="videoWatch"></span></div>
			
		</div>


	</div>

<div id="showPlaylist" style="float:left; width:460px; border: px solid red; padding-top: 10px; border-bottom: 1px solid #ccc">

<div style="width: 100%; height: 25px; padding: 10px 5px 10px 5px; background-color: #e9e9e9">
	<div style="float:left; width:200px">Playlist (<?= count($show['videos']) ?>)</div>
	<div style="float:left; font-size: 10pt">today | week | month || unwatched</div>
</div>

<div id="watchPlayListWrapper" style="width:100%; height: 300px; overflow:auto; ">
<ul>
<?
$urlArray = array();
for ($i=0; $i < count($show['videos']) ; $i++) { 
	$urlArray[$i] = ($show['videos'][$i]['use_embedded']==1) ? trim($show['videos'][$i]['url_source']) :  trim($show['videos'][$i]['video_id'])  ;
	$typeArray[$i] = trim($show['videos'][$i]['use_embedded']);
?>

	<li>
		<div  id="playingIcon_<?= $i ?>" style="float:left; display:none; color:red; padding-right: 5px" >X</div>
		<div style=""><a href="javascript: snackWatcher.doPlay(<?= $i ?>)"><?=stripslashes($show['videos'][$i]['title'])?></a>
			<? if ($show['videos'][$i]['video_type_id'] == 1) {?>
			<span style="color: #fccc79">episode</span>
				
			<? } ?>
			
		</div>
	
	</li>

<?
}

?>		
</ul>
</div>
</div>

</div>

<? $_flash_content =  ($show['videos'][0]['use_embedded']==1) ? trim($show['videos'][0]['url_source']) : "/images/swf/simplePlayer.swf?id=" . trim($show['videos'][0]['video_id']) ;
	$vString =   !empty($urlArray) ? "'" . implode("','" , $urlArray) . "'" : "" ;
	$tString =   (count($typeArray) > 0 ) ? "'" . implode("','" , $typeArray) . "'" : "" ;

?>


<script>
	snackWatcher.arrayVideos=new Array(<?= $vString ?>);
	snackWatcher.typeArray=new Array(<?= $tString ?>);
 	snackWatcher.placePlayer('<?= $_flash_content ?>'); 
	snackWatcher.doPlay(0);
	
	

	
</script>



