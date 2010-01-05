<div style="padding-top:70px"></div>

<? if ($video_data[0]['use_embedded'] == 2 ) {
	$_NBC_URL = "http://www.nbcolympics.com/video/modules/json/resourcedata/__ID__/index.html";
		$_url = str_replace( "__ID__", $video_data[0]['org_video_id'], $_NBC_URL );
		
		//echo $_url; die();
		$ch = curl_init ($_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$_json = curl_exec($ch);
		curl_close($ch);
		$_obj = json_decode($_json);

		$_thumb = "http://www.nbcolympics.com" . $_obj->thumbnails->medium ;
		
		//deal with the elive thing
		$_qual = isset($_REQUEST['_qual']) ? $_REQUEST['_qual'] :"high";
		
		$_stream = $_obj->streams->wmp->{$_qual} ;
		if (empty($_stream)) $_stream = $_obj->streams->sl->{$_qual} ;

		if (empty($_stream)) $_stream = $_obj->streams->sl->high ;

	?>
	
	
<div id="myplayer">the player will be placed here</div>
<div id="name">
	
	
	quality: <a href="/videos/detail/<?= $video_data[0]['video_id']  ?>?_qual=low">low</a> |
	<a href="/videos/detail/<?= $video_data[0]['video_id']  ?>?_qual=high">high</a>  -
	must have silverlight 2 beta 2 installed: <a href="http://www.microsoft.com/Silverlight/handlers/getSilverlight.ashx?v=2.0&targetplatform=macintel">mac</a> | 
	<a href="http://www.microsoft.com/Silverlight/handlers/getSilverlight.ashx?v=2.0&targetplatform=win">win</a> 
</div>
<script type="text/javascript" src="/static/sl/silverlight.js"></script>
<script type="text/javascript" src="/static/sl/wmvplayer.js"></script>
<script type="text/javascript">
	var elm = document.getElementById("myplayer");
	var src = '/static/sl/wmvplayer.xaml';
	var cfg = {
		file:'<?= $_stream ?>',
		image:'<?= $_thumb ?>',
		width:'790',
		height:'390'
	};
	var ply = new wmvplayer.Player(elm,src,cfg);
</script>

<? } else { ?>

<div style="width:800px; height: 368px; background: #000; text-align: center" id="player-holder">
	<div id="swfHolder" ><span style="color:#ffffff">Loading...</div>
</div>

<? }  ?>




<style type="text/css" media="screen">
	#watch-options
	{
		width: 800px;
		margin-top: 80px
	}
	
	#nav-watch {
		position: relative;
		width: 100%;
		height: 38px;
		background: #eae9e9;
		border-bottom: 1px solid #b1aaaa;

	}

	#nav-watch ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	#nav-watch li {
		float: left;
		height: 100%;
	
	}

	#nav-watch li a.nav-item-watch {
	line-height: 38px;
	font-size: 22px;
		height:38px;
		padding-left: 25px;
		padding-right: 25px;
		display: block;
		border-right: 1px solid #dcdce9;
		color: #999;
		text-decoration: none;
		text-align: center;
	}

	#nav-watch li a:hover {

		color: #000;

	}
	
	
	#nav-watch li.selected a {
		color: #000;
		background: #ccc
	}
	
	
	#watch-detail
	{
		padding-top: 30px
	}
	
	#watch-nowplaying
	{
		float: left;
		width: 450px
	}
	
	#watch-nowplaying-options
	{
		float: right;
		width: 220px;
	}
	
	#watch-actions
	{
		padding-top: 10px;
		padding-bottom: 10px;
		background: #eee;
		height: 25px;
	}
		.play-block
	{
		padding-top: 20px;
		padding-bottom: 20px

	}		

	.play-title
	{
		padding-top: 20px;
		margin-bottom: 5px;
		height: 26px;
		border-bottom: 1px solid #ccc;

	}
	
	.play-selected
	{
		background: #FFFFCC; 
	}
</style>

<script type="text/javascript" charset="utf-8">
	var lastDiv = 'next';
	
	function toggleWatch(id)
	{
		$('watch-' + lastDiv ).hide();
		$('watch-nav-' + lastDiv).removeClassName('selected')
		
		$('watch-' + id ).show();
		$('watch-nav-' + id).addClassName('selected')
		lastDiv = id;
		
		
	}
</script>


<div id="video-countdown" style="position: absolute; background: #000; width: 350px; height: 200px; left: 200px; top: 100px; display: none;">
<div style='padding-top:40px; font-size: 22px;color: #ffffff; line-height: 30px'>next video will automatically start in <span id='nextCounter'>5</span> seconds<br/>
<a style=' font-size: 22px;color: #ffffff' href='javascript:snackWatcher.goNext()'>start next video now</a>
<br/> or <br/>
<a style=' font-size: 22px;color: #ffffff' href='javascript:snackWatcher.cancelNext()'>cancel auto advance</a>

</div>

</div>



<? if ($video_data[0]['use_embedded'] == 0 ) {?>



<div id="watch-actions" >
	
	<div style="float: left; width: 50px;  text-align: center">
	<a id="btnPause" href="javascript:snackWatcher.togglePause();"><img id="imgPlayPause" src="/static/images/icons/btnPause.png"  border="0"/></a>
	</div>
	
	<div style="float: left; width: 50px;  text-align: center">
	<a id="btnNext" style="width: 90px;" href="javascript:snackWatcher.goNext();"><img src="/static/images/icons/btnNext.png" style="position:relative; top: 4px" border="0"/></a>
	</div>
	
	

	
	<div style="float: right; width: 50px;  text-align: center; padding-right: 25px">
	<a id="btnMute" href="javascript:snackWatcher.toggleMute();"><img id="imgVolume" src="/static/images/icons/btnMute.png"  border="0"/></a>
	</div>
	
	
</div>
<? } ?>

<div id="watch-detail">
	
	<div id="watch-nowplaying">
		
		
		<img class="img_left" src="<?= $video_data[0]['thumb']  ?>"/>
		<h3>NOW PLAYING: <?= stripslashes($video_data[0]['title']) ?></h3>
		from:  <a href='/shows/detail/<?= $show_data[0]['show_id'] ?>'><?= stripslashes($show_data[0]['show_title']) ?></a> <br/>

		<?= stripslashes( $video_data[0]['detail'] ) ?>
		
		<br/>
	
		
		
		<br/>
		<?
			 if ( count($_video_history) > 0 ) {
				foreach( $_video_history as $viewer ) {
					if ( $r ) {?>&raquo;<?}
					?> 
						<span style="color: #888844; margin-right: 10px">
						<?= $viewer["nickname"] ?>
						</span>
						
					<?
					$r = 1;
				}
			}
		?>
		
		
	</div>
	

	<div id="watch-nowplaying-options">
		
			<? if (User::$user_id != '0' ){ ?>
				<div class="button-gradient-light"> <a href="javascript:if ($('share_comment').value=='optional comment') $('share_comment').value='';var share_comment=$('share_comment').value; sf.update('follow_video','/users/flag_video?rating=5&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&plain=1&comment=' + share_comment )" id="follow_video" ><img src="/static/images/icons/feed_like_icon.png" border="none" alt="I like this video" >I like this video ( goes in feed )</a></div>
				
				<input style="background: #f4f4f4; width:215px; font-size: 13px; color: #555; height: 20px;" type="text" value="optional comment" id="share_comment" onclick="if ($('share_comment').value=='optional comment') $('share_comment').value='';"/>
				
			<? } ?>
		<div style="padding-top: 15px; color:#666; ">
			
				<input style="float:left;"  style="width:90px;" type="text" value="http://snfd.tv/<?= TinyHelper::decimal_to_base($video_data[0]['video_iid'], 62 )  ?>" id="link_code_tiny" onclick="javascript:sf.clipboardcopy(this,'link_code_tiny');" readonly  />
				
				<a class="no-bg" style="padding-left: 6px; float: left; color:#666;" href="http://twitter.com/home?status=watching%20http://snfd.tv/<?= TinyHelper::decimal_to_base($video_data[0]['video_iid'], 62)  ?>%20<?= urlencode(substr(stripslashes($video_data[0]['title']), 0, 120)) ?>" target="_new"> <img src="/static/images/icons/twitter.png" style="position: relative; top: 2px; border:none; outline: none; "> tweet!</a>
		
		</div>
		
		<? if (User::$user_id != '0') { ?>
		<br clear="both"/>	
		 <div style="padding-top: 10px">
		   <a style="text-decoration:none; font-weight: normal; color: #888; font-size: 12px" href="javascript:sf.addPlay('add_video_1','/videos/playlist_add/?video_id=<?= $video_data[0]['video_id']  ?>')" id="add_video_1" >+ playlist</a>	
		 </div>
		<?		}    ?>
		
	</div>

	
	
	
</div>

<br clear="both" />

<div id="watch-options">
	
	<div id="nav-watch">
	<ul>
		<li id="watch-nav-next" class="selected"><a href="javascript:toggleWatch('next')" class="nav-item-watch" >up next</a></li>
		<li id="watch-nav-show"><a href="javascript:toggleWatch('show')" class="nav-item-watch" >more videos</a></li>
		<? if (User::$user_id != '0' ){ ?><li id="watch-nav-comment"><a href="javascript:toggleWatch('comment')" class="nav-item-watch" >message</a></li><? } ?>	
		<li id="watch-nav-share"><a href="javascript:toggleWatch('share')" class="nav-item-watch" >share</a></li>	
		<? if (User::$user_su == '1') { ?>	
			<li id="watch-nav-admin"><a href="javascript:toggleWatch('admin')" class="nav-item-watch" >admin</a></li>
		<? } ?>			
	</ul>
	</div>	
	
	
	<div id="watch-next" style="">
	
		<div class="indent-column" style="width: 650px" >
			
		
			

<? if(!empty($playlist_data)) {?>
	
<div id="playlist-block" class="play-block">
<div class="play-title">
	
	<div style="float:left; font-size: 22px">
		your playlist
	</div>
	<div style="float:right">
		clear | <a href="javascript:snackWatcher.goNext()">play next</a>
	</div>
</div>
<br clear="both"/>	

<? 	for ($i = 0 ; $i < count($playlist_data) ; $i++) { 
	$play_selected = ($video_data[0]['video_id'] == $playlist_data[$i]['video_id']) ? "play-selected" : "";
	?>

		<div class="result-item <?= $play_selected ?>" >
			<img class="img_left" src="<?= $playlist_data[$i]['thumb']  ?>"/>
			<a  href="/videos/detail/<?= $playlist_data[$i]['video_id'] ?>?pl=<?= $i ?>&group_id=<?= $playlist_data[$i]['group_id'] ?>"><?= stripslashes($playlist_data[$i]['title']) ?></a><br/>
			 <?= substr($playlist_data[$i]['detail'], 0, 120) ?> 
			

		</div>
<?		}  ?>	
			
</div>
<? } ?>			
			
			
		<div id="upnext-block" class="play-block">			
		<div class="play-title">
			
			<div style="float:left; font-size: 22px">
				<?= $next_title ?>
			</div>
			<div style="float:right">
				
			</div>
		</div>
		<br clear="both"/>		

			
		<div class="result-item" >
			<img class="img_left" src="<?= $next_video[0]["thumb"] ?>" />
			<a href="/videos/detail/<?= $next_video[0]["video_id"] ?><?= $next_params ?>"><?= stripslashes($next_video[0]["title"]) ?></a><br/>
			
			<?= substr(stripslashes($next_video[0]["detail"]), 0, 220) ?><br/>
		
			<div style="position: absolute; bottom: 5px; right: 10px; padding-left: 10px; padding-right: 10px;"  class="button-gradient-light"> 
					<a href="/videos/detail/<?= $next_video[0]["video_id"] ?><?= $next_params ?>">play now</a>
			</div>
		
		</div>
		</div>
		
		
		</div>
		
	</div>
		
		

	
	<div id="watch-show" style="display:none">
	
		
		<div class="indent-column" style="width: 600px" >
			
		
			<div style="margin-bottom: 15px; margin-top: 20px"><h3>similar videos from this show:</h3></div>
			<div style="position:relative">
			
				<div style="width: 400px; float: left">
				<img class="img-left-big" src="<?= $show_data[0]['show_thumb'] ?>"> 
				
				<a href="/shows/detail/<?= $show_data[0]['show_id'] ?>"><?=  $show_data[0]['show_title']  ?></a><br/>
				<?= $show_data[0]["show_detail"] ?><br/>
				</div>
			
				<div style="float:right; width: 175px" class="button-gradient-light" > 
					 <a href="javascript:sf.update('follow_show2','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $video_data[0]['show_id']  ?>&plain=1')" id="follow_show2" >follow this show</a> 
				</div>	 
		
			</div>
			<br clear="both" />
			
			
			<div class="indent-column" style="padding-top: 30px" >
	
			<? for ($j = 0 ; $j < min(4 , count( $show_data )); $j++){ ?>	
				
				
			
				<div class="result-item" >	
					<img class="img_left"  src="<?= $show_data[$j]["thumb"] ?>">
					<a href="/videos/detail/<?= $show_data[$j]["video_id"] ?>"><?= stripslashes($show_data[$j]["title"]) ?></a><br/>
					<?= substr(stripslashes($show_data[$j]['detail']), 0, 180) ?> 
					<br/><a href="/videos/detail/<?= $show_data[$j]["video_id"] ?>">play now</a>
				</div>	
				
			<?  } ?>
			
			</div>		
		</div>
	</div>
		
		
		
		
		


	<div id="watch-comment" style="display:none">
		<div class="indent-column" style="padding-top: 30px;" >
		<form name="form_message" id="form_message" action="/users/send_message" action="post">
		<input type="hidden" name="video_id" value="<?= $video_data[0]['video_id'] ?>" />
		<input type="hidden" name="video_title" value="<?= $video_data[0]['title'] ?>" />
		
		<input type="hidden" name="s_user_id" value="<?= User::$user_id ?>" />
		
	
		<div style="width: 300px; float: left;">
			<h3  style="padding-bottom: 20px">your message:</h3>
			<textarea name="message_body" style="width: 250px; border: 1px solid #ccc">message here</textarea>
		</div>
		
		
		<div style="width: 300px; float: left;">
			<h3 style="padding-bottom: 20px">to your friends:</h3>
			<?
				$rec = User::get_related_users(array());
				for ($i=0; $i < count($rec); $i++) { ?>
				<div style="width: 100%; padding: 3px; border-bottom: 1px solid #ccc;">
					<input type="checkbox" name="r_user_ids[]" value="<?= $rec[$i]['user_id'] ?>" /> <?= $rec[$i]['nickname'] ?><br/>
				</div>
				
				<? } ?>
			
			
		</div>
		<br clear="both">
		<div style="width: 175px" class="button-gradient-light" > 
		<a href="javascript:sf.form_update('form_message','message_response')">send message</a>
		</div>
		<div id="message_response" style="padding-top: 10px">
			
		</div>
		
		</form>
		</div>
		
	</div>		
	
	<div id="watch-share" style="display:none">
	
		
	 <div class="indent-column" style="padding-top: 30px" >
	


	

	 	
	 	
		<div class="form-message">		
			<div class="button-gradient-light" style="width: 240px;" ><a href="#" onclick="window.open('/users/send_to_friend?&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&_t=plain','mywindow','width=720,height=500')"><img src="/static/images/icons/sendToFriend.png" width="21" height="12" border="none" alt="SendToFriend" >send to friend</a></div>
		</div>
		
		<div class="form-message">		
			<div class="button-gradient-light" style="width: 240px;" ><a href="http://www.facebook.com/sharer.php?u=http%3a%2f%2fwww.snackfeed.com%2fvideos%2fdetail%2f<?= $video_data[0]['video_id'] ?>" target="_new"><img src="/static/images/icons/sendToFriend.png" width="21" height="12" border="none" alt="facebook" >send to facebook</a></div>
		</div>		
		
		<? if ($video_data[0]['use_embedded'] != 2 ) {?>
		<div class="form-message">		
		<div class="button-gradient-light" style="width: 240px;"><a href="#" onclick="window.open('/users/send_to_tumblr?&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&_t=plain','mywindow','width=720,height=500')"><img src="/static/images/icons/sendToTumblr.png" width="19" height="18" border="none" alt="send to tumblr" >send to tumblr</a></div>
		</div>	
		<? } ?>
			<div style="height:20px"></div>
	 	
 		<label for="input_from" class="nForm" >video link:</label> 
			<input class="nForm" type="text" value="<?= $video_data['escaped_link'] ?>" id="link_code" onclick="javascript:sf.clipboardcopy(this,'link_code');" readonly  /><br clear="left"/>
			<div class="field-message small-detail">will auto copy to your clipboard on click</div><br clear="left" />
	
		<? if ($video_data[0]['use_embedded'] != 2 ) {?>
		<label for="input_from" class="nForm" >embed code: </label> 
			<input class="nForm" type="text" id="embed_code" value='<?= $video_data['embed_code'] ?>' onclick="javascript:sf.clipboardcopy(this,'embed_code');"   /><br clear="left"/>
			<div class="field-message small-detail">will auto copy to your clipboard on click</div><br clear="left" />
		<? } ?>
		
		


			
			
			
				<? if (count($channel_data) > 0 ) {?>
			
				<div style="height: 20px"></div>
			<div class="form-message">	
				<div class="header-light">
					add to channel:
				</div>
				<div class="indent-column">
			
						<div class="side-options">
							
						<? for ($i = 0 ; $i < count($channel_data) ; $i++){ ?>	
						<dd >
							<a href="javascript:sf.update('add_channel_<?= $i ?>','/videos/add_to_channel/<?= $video_data[0]['video_id'] ?>?channel_id=<?= $channel_data[$i]['channel_id'] ?>')" id="add_channel_<?= $i ?>" ><?= $channel_data[$i]['title'] ?></a>
						
						</dd>
					
						<?  } ?>
						</div>
			
				</div>
				</div>
				<? } ?>




		</div>

		
	</div>		
		
<? if (User::$user_su == '1') { 
	
	$sql = "SELECT * FROM segmentations ORDER BY order_by";
	$qs = DB::query($sql)
	
	
	?>	

	<div id="watch-admin" style="display:none">
		<div class="indent-column" style="padding-top: 30px; width: 600px" >
	
			<form name="video_recommend" action="/videos/recommend_video" method="POST">
			
				<input type="hidden" name="video_id" value="<?= $video_data[0]['video_id'] ?>" />
	
				recommend this video for: 
				<select name="segmentation_id">
				<? for ($i=0; $i < count($qs); $i++) { ?>
					<option value="<?= $qs[$i]['segmentation_id'] ?>" ><?= $qs[$i]['title'] ?></option>
				<? }?>				
					
				</select>
				
				<a href="javascript:document.video_recommend.submit()">recommend</a>
				
			</form>
			
			<hr style="margin-top: 20px; margin-bottom: 20px"/>
			<form name="public_recommend" id="public_recommend" action="/public/recommend_video" method="POST">
				<h3>public feed</h3>
				<input type="hidden" name="video_id" value="<?= $video_data[0]['video_id'] ?>" />
	
				add comment: <br/>
				<textarea name="comment" style="width: 250px; border: 1px solid #ccc">message here</textarea><br/>
				weight: <input type="text" value="50" name="weight"><br/>
				
				<div id="public_message_response" style="padding-top: 10px"><a href="javascript:sf.form_update('public_recommend','public_message_response')">put in public feed</a> </div>
				
		
				
			</form>		
			
		</div>
		
	</div>	

<? }  ?>	
	
</div>


<br clear="all"/>


<script type="text/javascript" charset="utf-8">

<? if ($video_data[0]['use_embedded'] == 1 ) {?>
	var _swfContent = '<?= $video_data[0]['url_source'] ?>' 
<? } else { ?>		
var video_id = '<?= $video_data[0]['video_id'] ?>';
var _swfContent = '/static/swfs/simplePlayer.swf?id=' + video_id
<? }  ?>	

<? if ($video_data[0]['use_embedded'] != 2 ) {?>
     window['flashVideoPlayer'] = new Object();
     var so = new SWFObject(_swfContent ,"flashVideoPlayer", "790", "368", "9.0.47", "#000000");
     so.addParam("allowScriptAccess", "always");
     so.addParam("allowFullScreen", "true");
     so.addParam("salign", "t");
     so.useExpressInstall("/static/swfs/expressInstall.swf");
      so.setAttribute('xiRedirectUrl', 'http://www.snackfeed.com/');
     so.write("swfHolder");

<? }  ?>
	
	
	
	var lightsOff = function() {
	  //alert("done playing hulu");
	  snackWatcher.videoPlayComplete();
	}

	var lightsOn = function() {
		snackWatcher.videoPlayComplete();
	  //alert("lights on");
	}

	var videoPlayStart = function()
	{
		//alert('from falsh');
		
	}
	var snackWatcher = {}; 
	
	snackWatcher.nextTimerId = 0;
	snackWatcher.nextTimerCount = 5;
	
	snackWatcher.videoPlayComplete = function ()
	{
		
		$('player-holder').update("");
		
		$('video-countdown').show();
		
		
		//setTimeout( function() {
		//	$('player-holder').innerHTML = vText;
		//} , 1200 
		//);
		
		
		
		
		
		snackWatcher.nextTimerId = setInterval  ( "snackWatcher.countDownNext()", 1000 );

	}
	
	snackWatcher.countDownNext = function ()
	{
		snackWatcher.nextTimerCount--;
		$('nextCounter').innerHTML = snackWatcher.nextTimerCount;
		if (snackWatcher.nextTimerCount == 0 ) 
		{
			$('video-countdown').hide();
			snackWatcher.cancelNext;
			snackWatcher.goNext();
		}
			
	}
	
	snackWatcher.goNext = function ()
	{
		
		document.location = "/videos/detail/<?= $next_video_id ?><?= $next_params ?>";
	}
	
	
	snackWatcher.cancelNext = function ()
	{
		
		clearInterval (  snackWatcher.nextTimerId );

	}
		
	
	
	snackWatcher.toggleMute = function () {
	
		var obj = $("flashVideoPlayer"); //swfobject.getObjectById("flashVideoPlayer");
		if ( obj.toggleMute ) {
		  obj.toggleMute();
		}
	
	}

	snackWatcher.togglePause = function () {
	

	var obj = $("flashVideoPlayer");
	if ( obj.togglePause ) {
	  obj.togglePause();
	}
	
	}

	snackWatcher.setViewStatePlaying = function () {
	$('imgPlayPause').src  = '/static/images/icons/btnPause.png';
	}

	snackWatcher.setViewStatePaused = function () {
	$('imgPlayPause').src  = '/static/images/icons/btnPlay.png';
	}

	snackWatcher.setViewStateUnMuted = function ( text ) {
	$('imgVolume').src  = '/static/images/icons/btnMute.png';
	}

	snackWatcher.setViewStateMuted = function ( text ) {
	$('imgVolume').src  = '/static/images/icons/btnUnmute.png';
	}



	
</script>





<?



?>