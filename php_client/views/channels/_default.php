
<style type="text/css" media="screen">
	.img-left-small
	{
	border:1px solid #ccc;
	float:left;
	height:40px;
	margin-right:8px;

	}
	
	.result-item-small
	{
		border-bottom:1px solid #CCCCCC;
		height:43px;
		padding:5px;
		position:relative;
	}
	
	.header-detail
	{
		text-align:right; font-size: 10px; position: absolute; right: 0px; top:8px
	}
	
	.header-detail a
	{
		text-decoration: none;
		color: #666;
		
	}
	
	div.header-big-2 {
	  position: relative;
		font-size: 18px;
		font-weight: bold;
		color: #666;
		height: 32px;
		width: 100%;
		background: #fff url('/static/images/v3/bg/bar_bk.gif') repeat-x bottom;
		clear: left;
	}
	
	
	.two-column-split
	{
		width: 385px; float:left
	}
	
</style>
<div style="height: 70px"></div>

<div class="two-column-split" style="">
	<div class="header-big-2">
		popular  shows
		<div class="header-detail" 	><a href="/shows">see all shows</a></div>
	</div>
		<div class="indent-column">
			<? for ($i=0; $i < count($show_data) ; $i++) { ?>
				<div class="result-item-small" >
					<a href="/shows/detail/<?= $show_data[$i]['show_id'] ?>"><img class="img-left-small" src="<?= $show_data[$i]['thumb']  ?>"/></a>
					<a href="/shows/detail/<?= $show_data[$i]['show_id'] ?>"><?= stripslashes($show_data[$i]['title']) ?></a><br/>
					<?= stripslashes(substr($show_data[$i]['detail'], 0, 120)) ?> 
					<div style="position: absolute; top:3px; right: 0px">
						<?= $show_data[$i]['user_count']  ?> followers
					</div>
				</div>
			<? } ?>
		</div>
</div>

<div class="two-column-split" style="margin-left: 30px">
	<div class="header-big-2">
		recent users favorite vids
				<div class="header-detail" 	><a href="/search">search all videos</a></div>
	</div>
	<div class="indent-column">
		<? for ($i=0; $i < count($fav_videos_data) ; $i++) { ?>
			<div class="result-item-small" >
				<a href="/videos/detail/<?= $fav_videos_data[$i]['video_id'] ?>?u=<?= User::$username ?>"><img class="img-left-small" src="<?= $fav_videos_data[$i]['thumb']  ?>"/></a>
				<a href="/videos/detail/<?= $fav_videos_data[$i]['video_id'] ?>?u=<?= User::$username ?>"><?= stripslashes(substr($fav_videos_data[$i]['title'], 0, 40)) ?></a><br/>
				<?= stripslashes(substr($fav_videos_data[$i]['detail'], 0, 80)) ?> 
				<div style="position: absolute; top:3px; right: 0px">
					<?= $fav_videos_data[$i]['video_count']  ?> likes
				</div>
				
			</div>
		<? } ?>
	</div>
</div>



<br clear="both"/>
<div style="height: 40px"></div>

<div class="two-column-split" style="">
<div class="header-big-2">
		top youtube videos
		<div class="header-detail" 	><a href="/search/youtube">more youtube</a></div>
	</div>
		<div class="indent-column">
		<?  for ($i = 0 ; $i < min(5,count($youtube_top_rated)) ; $i++) {    ?> 
				<div class="result-item-small" >
					<a href="/videos/ext/<?= $youtube_top_rated[$i]['video_id'] ?>?t=yt"><img class="img-left-small" src="<?= $youtube_top_rated[$i]['thumb'] ?>"/></a>
					<a href="/videos/ext/<?= $youtube_top_rated[$i]['video_id'] ?>?t=yt"><?= substr($youtube_top_rated[$i]['title'], 0 , 30) ?></a><br/>
					<?= stripslashes(substr($youtube_top_rated[$i]['detail'], 0, 90)) ?> 
					<div style="position: absolute; top:3px; right: 0px">
						<?= $youtube_top_rated[$i]['views']  ?> views
					</div>
				</div>
			<? } ?>
		</div>	
</div>

<div class="two-column-split" style="margin-left: 30px">
	<div class="header-big-2">
		most active people
				<div class="header-detail" 	><a href="/users/ls">see all people</a></div>
	</div>
	<div class="indent-column">
		<? for ($i=0; $i < count($user_data) ; $i++) { ?>
			<div class="result-item-small" >
				<a href="/users/profile/<?= $user_data[$i]['user_id'] ?>"><img class="img-left-small" src="<?= $user_data[$i]['thumb']  ?>"/></a>
				<a href="/users/profile/<?= $user_data[$i]['user_id'] ?>"><?= stripslashes($user_data[$i]['nickname']) ?></a><br/>
				<?= stripslashes($user_data[$i]['location']) ?> 
				<div style="position: absolute; top:3px; right: 0px">
					<?= $user_data[$i]['user_count']  ?> updates
				</div>
				
			</div>
		<? } ?>
	</div>
</div>

	
		
<br clear="both"/>
<div style="height: 40px"></div>

<div class="two-column-split" style="">
		<div class="header-big-2">
		popular channels
		<div class="header-detail" 	><a href="/channels/ls">see all channels</a></div>
	</div>
		<div class="indent-column">
			<? for ($i=0; $i < count($channel_data) ; $i++) { ?>
				<div class="result-item-small" >
					<a href="/channels/detail/<?= $channel_data[$i]['channel_id'] ?>"><img class="img-left-small" src="<?= $channel_data[$i]['thumb']  ?>"/></a>
					<a href="/channels/detail/<?= $channel_data[$i]['channel_id'] ?>"><?= stripslashes($channel_data[$i]['title']) ?></a><br/>
					<?= stripslashes(substr($channel_data[$i]['detail'], 0, 120)) ?> 
					<div style="position: absolute; top:3px; right: 0px">
						<?= $channel_data[$i]['user_count']  ?> followers
					</div>
				</div>
			<? } ?>
		</div>

</div>

<div class="two-column-split" style="margin-left: 30px">
	<div class="header-big-2">
		staff show picks
				<div class="header-detail" 	><a href="/shows">more shows</a></div>
	</div>
		<div class="indent-column">
			<? for ($i=0; $i < count($staff_data) ; $i++) { ?>
				<div class="result-item-small" >
					<a href="/shows/detail/<?= $staff_data[$i]['show_id'] ?>"><img class="img-left-small" src="<?= $staff_data[$i]['thumb']  ?>"/></a>
					<a href="/shows/detail/<?= $staff_data[$i]['show_id'] ?>"><?= stripslashes($staff_data[$i]['title']) ?></a><br/>
					<?= stripslashes(substr($staff_data[$i]['detail'], 0, 90)) ?> 
					<div style="position: absolute; top:3px; right: 0px">
						<?= $staff_data[$i]['user_count']  ?> followers
					</div>
				</div>
			<? } ?>
		</div>
</div>

<br clear="both"/>		
