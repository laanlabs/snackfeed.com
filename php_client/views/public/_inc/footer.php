		<div style="margin-top: 30px; font-family: Helvetica Neue, Arial; color: #8e8e8e; font-size: 13px;" >
			
			
			<a href="/public/rss"><img class="icon-offset" src="/static/images/splash/rss.png"></a>
			<a href="/public/rss">RSS for this feed!</a>
			
			<br/><br/>
			Twitterbot for this feed  <a href="http://twitter.com/snackfeedme" class="blue-link">@snackfeedme</a>
			
			<br/><br/>
			
			Follow us on twitter <a href="http://twitter.com/snackfeed" class="blue-link">@snackfeed</a>, or check out our <a href="http://cheese.snackfeed.com" class="blue-link">tumblr</a> or <a href="http://labs.laan.com/blog" class="blue-link">blog</a>.
			
			
			
			<? if (User::$user_id != '0' ){ ?>
				<br/>
				<div style="position:relative; padding-top: 25px">
			<a onmouseover="if ($('playlist_count').innerHTML > 0) {showOption.initOption ('playlist-playnow');}" onmouseout="if ($('playlist_count').innerHTML > 0) {showOption.offOption ();}" href="/users/playlists/<?= User::$user_id ?>"   class="blue-link" style="font-size: 19px;" >playlist (<span id="playlist_count"><?= Video::playlist_count() ?></span>)</a>
					<div id="playlist-playnow" style="display:none" onmouseover="showOption.initOption ('playlist-playnow');" onmouseout="showOption.offOption ();">
						<a id="playlist-play" href="/users/playlists?play=true">play now</a><a id="playlist-clear" style="" href="javascript:sf.clearPlaylist()">[x]</a>
					</div>
				</div>	
			<? } ?>		
			
		</div>