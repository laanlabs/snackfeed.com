
<div id="main-content" >
<!-- <div style="padding-top:70px"></div> -->
<div style="color: #888; font-size: 11px; float: right; padding-right: 45px;"><!-- 10 mins ago --></div>

<div style="height: 105px; text-align: left; padding-left: 44px; padding-top:8px;">
<? if (1 || rand(1, 10)>4) { ?>
	
	<? if ( 1 || rand(1, 10)>6 ) { ?>
		<!--><a href='http://bit.ly/sonarad' target='_blank'><img src='/static/images/ads/sonar_ad.png'/></a>-->
		<!--><a href='http://bit.ly/bgramad' target='_blank'><img src='/static/images/ads/bgram_ad.png'/></a>-->
		<a href='http://bit.ly/timelapsead' target='_blank'><img src='/static/images/ads/timelapse_ad.jpg'/></a>
		<? } else if ( rand(1, 8)>5  ) {?>
	<a href='http://click.linksynergy.com/fs-bin/stat?id=cavRWSU5H/Y&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=http%253A%252F%252Fitunes.apple.com%252FWebObjects%252FMZStore.woa%252Fwa%252FviewSoftware%253Fid%253D302862486%2526mt%253D8%2526uo%253D6%2526partnerId%253D30' target='_blank'><img src='/static/images/ads/wotd_ad.png'/></a>
	<? } else { ?><a href="http://click.linksynergy.com/fs-bin/stat?id=cavRWSU5H/Y&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=http%253A%252F%252Fitunes.apple.com%252FWebObjects%252FMZStore.woa%252Fwa%252FviewSoftware%253Fid%253D324623142%2526mt%253D8%2526uo%253D6%2526partnerId%253D30" target='_blank'><img src='/static/images/ads/compass_ad.png'/></a>
	<? } ?>
	
<? } else { ?>	
	<script type="text/javascript"><!--
	google_ad_client = "pub-9135472005992663";
	/* 728x90, created 7/24/09 */
	google_ad_slot = "1727751714";
	google_ad_width = 728;
	google_ad_height = 90;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	
	<? } ?>	
</div>

<div style="height: 20px; text-align: left; padding-left: 44px; font-weight: bold; font-size: 13px; color: #77797d;"><?= stripslashes($video_data[0]['title']) ?></div>

<div id="rewind-button">
</div>

<div id="ffwd-button" onclick="javascript: snackWatcher.goNext(); return false;" >
</div>

<div style="margin-top: 2px; width: 100%; text-align: center;">
<div style="" id="player-holder">
	<!-- <div style="position:absolute; padding-top: 10px; color:#222; font-size: 29px; text-transform: uppercase;">Loading...</div> -->
	<div class="player-corner" id="player-top-right-corner">
	</div>
	<div class="player-corner" id="player-bottom-right-corner">
	</div>
	<div class="player-corner" id="player-bottom-left-corner">
	</div>

	<div id="swfHolder">Loading...
	</div>
</div>
</div>



<div id="video-countdown" style="position: absolute; background: #000; width: 350px; height: 200px; left: 200px; top: 100px; display: none;">
<div style='padding-top:40px; font-size: 22px;color: #ffffff; line-height: 30px'>next video will automatically start in <span id='nextCounter'>5</span> seconds<br/>
<a style=' font-size: 22px;color: #ffffff' href='javascript:snackWatcher.goNext()'>start next video now</a>
<br/> or <br/>
<a style=' font-size: 22px;color: #ffffff' href='javascript:snackWatcher.cancelNext()'>cancel auto advance</a>

</div>

</div>


<div id="video-player-bottom" >


<? if (User::$user_id != '0' ){ ?>
	
	<span id="share-video-info" style="width:290px; float: left;">Post this video to your public feed: &nbsp;</span>

	<div style="width: 58px; text-align: center; text-transform: uppercase; background-position: center center; background-repeat: no-repeat; background-image: url('/static/images/v3/buttons/post_bg.png'); float: right; margin-top: 2px; margin-left: 10px; ">
		<a style="width: 100%;  letter-spacing: 1px; color: #777777; font-size: 10px; " onclick="postComment();" href="#" id="follow_video" >POST</a></div>
	
	<input style="float: right; background: #f4f4f4; width:190px; font-size: 13px; color: #555; height: 20px;" type="text" value="optional comment" id="share_comment" onclick="if ($('share_comment').value=='optional comment') $('share_comment').value='';"/>
	
	<?
		//render_partial("small_button", array("text" => "POST") );
	?>
	
	<div id="share-video-icons-container" >
		
		
		<div class="emoticon_holder active" id="icon-laughing"><img title="laughing" id="emoticon1" src="/static/images/v3/emoticons/laughing.png" border="none" alt="I like this video" ></div>
			<div class="emoticon_holder" id="icon-like"><img title="like"  src="/static/images/v3/emoticons/content.png" border="0" alt="I like this video" ></div>
			<div class="emoticon_holder" id="icon-weird"><img title="weird"  src="/static/images/v3/emoticons/weird.png" border="0" alt="I like this video" ></div>
			<div class="emoticon_holder"  id="icon-despair"><img title="despair" src="/static/images/v3/emoticons/despair.png" border="0" alt="I like this video" ></div>
			<div class="emoticon_holder" id="icon-wtf" ><img title="wtf"  src="/static/images/v3/emoticons/wtf.png" border="0" alt="I like this video" ></div>

	</div>
	
	
	<script>
		var current_share_icon = "laughing";
		//var current_share_element = null;
		
		
		
	  function postComment() {
		
		if ($('share_comment').value=='optional comment')
		$('share_comment').value='';
		
		var share_comment = $('share_comment').value;
		var post_url = '/users/flag_video?action_icon='+ current_share_icon + '&rating=5&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&plain=1&comment=' + share_comment
		sf.update('follow_video', post_url );
		return false;
		
		}
		//Element.extend()
		//var nodes  = $A($("share-video-icons-container").getElementsByTagName('img')).map(Element.extend);
		var nodes = $("share-video-icons-container").select('img');
		
		//alert("Ef");
		//var node3 = $("emoticon1");
		//nodes2[0].observe('click', respondToClick);
		
	 for (var i=0; i<nodes.length; i++) {
	 		nodes[i].observe('click', respondToClick);
	 }
		
		function respondToClick(event) {
				
			var element = Event.element(event);
			//current_share_element = element;
			
			if ( element.hasClassName("active") ) {
				postComment();
				element.removeClassName("active");
				//element.parentNode.removeClassName("active");
				return;
			}	
			
			 for (var i=0; i<nodes.length; i++) {
			 		nodes[i].removeClassName('active');
			 }
			
			  $('icon-'+current_share_icon).removeClassName('active');
			 
			 
			  element.addClassName('active');
			   $('icon-'+element.title).addClassName('active');
		  
			
		  //$('share_comment').setAttribute("value" , "neat" + element.title );
		  current_share_icon = element.title;
			//$('share-video-info').update("Click the face again to quickly post with no comment");
			//Effect.Pulsate('share-video-info', { from: .5, pulses: 2, duration: 1.5 });
			//new Effect.Highlight( $('share-video-info') , { duration: .85, startcolor: '#ffff99',	endcolor: '#ffffff' });
		}
		
		
		
		//Event.observe( $('share_comment'), 'keydown' , onShareKeydown );
		$('share_comment').observe( 'keydown' , onShareKeydown );
		
		
		function onShareKeydown( event ) {
			
		//	console.log( "yio" +  event.keyCode );
			
			
			if ( event.keyCode == 13 ) {
				
				if ($('share_comment').value=='') return false;
				
				//Event.extend(event);
				//event.preventDefault();
				//event.stopPropagation();
				//event.stopped = true; 
				
				postComment();
				
			}
		}
		
		
	</script>
	
	
<? } ?>


</div>

<div id="watch-more-videos">
</div>


<div id="watch-more-videos-tabs-body">

<div id="quick-share">
	
	<img src="/static/images/v3/icons/quickshare.jpg" width="69" height="20" alt="Quickshare" />

	<a title="tweet this video" href="http://twitter.com/home?status=watching%20http://snfd.tv/<?= TinyHelper::decimal_to_base($video_data[0]['video_iid'], 62)  ?>%20<?= urlencode(substr(stripslashes($video_data[0]['title']), 0, 120)) ?>" target="_new" ><img src="/static/images/v3/icons/twitter.jpg" width="20" height="20" /></a>
<a href="#" title="email to friend" onclick="window.open('/users/send_to_friend?&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&_t=plain','mywindow','width=720,height=500')" ><img src="/static/images/v3/icons/email.jpg" width="20" height="20" /></a>
<a title="share on facebook" href="http://www.facebook.com/sharer.php?u=http%3a%2f%2fwww.snackfeed.com%2fvideos%2fdetail%2f<?= $video_data[0]['video_id'] ?>" target="_new" ><img src="/static/images/v3/icons/facebook.jpg" width="20" height="20" /></a>
<a href="#" title="send this to my tumblr" onclick="window.open('/users/send_to_tumblr?&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&_t=plain','mywindow','width=720,height=500')" ><img src="/static/images/v3/icons/tumblr.jpg" width="20" height="20" /></a>	
		<input class="quick-share-field" type="text" value="http://snfd.tv/<?= TinyHelper::decimal_to_base($video_data[0]['video_iid'], 62 )  ?>" id="link_code" onclick="javascript:sf.clipboardcopy(this,'link_code');" readonly  />
</div>
	

	<div class="nav-tabs">
	<ul>
		<li id="watch-nav-next" class="selected"><div id="next-up-popup-holder"><img src="/static/images/v3/nextuppop.png"></div><a  href="javascript:toggleWatch('next')" class="nav-item-watch nav-item-left" ><?= substr($next_title, 0, 40) ?></a>
			<div class="nav-tabs-trim" ></div>
		</li>
		<li id="watch-nav-show"><a href="javascript:toggleWatch('show')" class="nav-item-watch" >about this show</a>
			<div class="nav-tabs-trim" ></div></li>
		<li id="watch-nav-related"><a href="javascript:toggleWatch('related')" class="nav-item-watch" >related </a>
			<div class="nav-tabs-trim" ></div></li>
		<? if (User::$user_id != '0' ){ ?>
		<li id="watch-nav-comment"><a href="javascript:toggleWatch('comment')" class="nav-item-watch" >message</a>
		<div class="nav-tabs-trim"></div></li>
		<? } ?>	
		<li id="watch-nav-share"><a href="javascript:toggleWatch('share')" class="nav-item-watch" >share</a>
			<div class="nav-tabs-trim"></div></li>	
				
		<? if (User::$user_su == '1'  ) { ?>	
			<li id="watch-nav-admin"><a href="javascript:toggleWatch('admin')" class="nav-item-watch" >a</a>
				<div class="nav-tabs-trim" ></div></li>
		<? } ?>
		
					
	</ul>
	</div>
	


	<div style="height:20px;"></div>
		
		
		



 <!-- UP NEXT TAB  -->
<div id="watch-next">
	
	<!-- 
	<? if(!empty($playlist_data)) {?>
	<div id="playlist-block" class="play-block">
	<div class="play-title">
		HEY
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

-->

		<ul id="watch-more-videos-results" style="margin-top: 10px;">

			<?
			
			//if ( $playlist_data ) 
			//global $is_playlist;
		  //if ( $playlist_data ) 
			//$is_playlist = true;
			
			if ( $playlist_data ) 
			$is_playlist = true;
			
			//echo "IS PLAYLIST? " . $is_playlist;
			//die();
			$playlist_start_id = 0;
			//$playlist_group_id = $playlist_group_id;
			
			
			$videos_data = $next_video;
			$item_width = "670px";
			
	
			$_limit = 5;		
			include VIEWS."/feed/_inc/feed_item_renderer.php"; 
			
			?>

		</ul>
		
</div>


 <!-- NEW SHOWS TAB  -->
<div id="watch-show"  style="display:none">
	
	<div id="show-info-header" style="padding-left: 0px; margin-left: 5px; margin-top: 15px;">
		
		<!-- thumb -->
		<div class="show-info-thumb" >
				<div class="show-info-thumb-div">
				<img class="show-info-thumb-img" src="<?= $show_data[0]['show_thumb']  ?>"></div>
		</div>


		<div id="show-info-meta-container">

			<div class="show-info-title">
					<a class="show-info-title-a" href="/shows/detail/<?= $show_data[0]['show_id']  ?>/<?= $item_title_dashes ?>?_s=f"><?= stripslashes($show_data[0]['show_title']) ?>
					</a>
			</div>

			<div id="show-info-description">
				Here is some information about the show
				<?= stripslashes($show_data[0]['show_detail']) ?>
			</div>

				
				<?
					if (!$following){
						$_link = "javascript:sf.update('follow_link','/users/save_show_to_favorites?user_id=" . User::$user_id . "&show_id={$shows_data[0]['show_id']}&plain=1')";
						$_text = "TRACK THIS SHOW";
						$_btn_id = "follow_link";
					} else {
						$_link = "javascript:sf.update('unfollow_link','/users/remove_show_from_favorites?user_id=" . User::$user_id . "&show_id={$shows_data[0]['show_id']}&plain=1')";
						$_text = "STOP TRACKING THIS SHOW";
						$_btn_id = "unfollow_link";
					}
					
					?> 
					
					<div style="height: 5px;"></div>
					 <?
					render_partial("small_button", array("text" => $_text, "id" => $_btn_id, "link" => $_link) );
				?>
				
		</div>

	</div>
	
<div style="border-top: 1px solid #eee; height: 2px; margin-bottom: 20px; ">
</div>
		
		<ul id="watch-more-videos-results">
			
			<? 
			
			
			
			$videos_data = $show_data;
			$item_width = "670px";
			include VIEWS."/feed/_inc/feed_item_renderer.php"; ?>

		</ul>
</div>

<!-- RELATED VIDEOS TAB  -->
<div id="watch-related"  style="display:none">
	
	
<div style="border-top: 1px solid #eee; height: 2px; margin-bottom: 20px; ">
</div>
		
		<ul id="watch-more-videos-results">

			<? 
			
			$videos_data = $show_data;
			$item_width = "670px";
			include VIEWS."/feed/_inc/feed_item_renderer.php"; ?>

		</ul>
</div>

	
	<!-- MESSAGE TAB  -->
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


<!-- SHARE TAB  -->
<div id="watch-share" style="display:none">

	
 <div class="indent-column" style="padding-top: 30px" >

	
	
	<? if ($video_data[0]['use_embedded'] != 2 ) {?>
	<div class="form-message">		
	<div class="button-gradient-light" style="width: 240px;"><a href="#" onclick="window.open('/users/send_to_tumblr?&video_id=<?= $video_data[0]['video_id'] ?>&user_id=<?= User::$user_id ?>&_t=plain','mywindow','width=720,height=500')"><img src="/static/images/icons/sendToTumblr.png" width="19" height="18" border="none" alt="send to tumblr" >send to tumblr</a></div>
	</div>	
	<? } ?>
		<div style="height:20px"></div>
 	
	<label for="input_from" class="nForm" >video link:</label> 
		<input class="nForm" type="text" value="http://snfd.tv/<?= TinyHelper::decimal_to_base($video_data[0]['video_iid'], 62 )  ?>" id="link_code" onclick="javascript:sf.clipboardcopy(this,'link_code');" readonly  /><br clear="left"/>
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
$qs = DB::query($sql);

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

&nbsp;
</div>

<div id="watch-more-videos-bottom">
</div>





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
		// this still crashes my browser, i think its ok to leave the player up for now.
		//$('player-holder').update("");
		
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





