
<style type="text/css" media="screen">
	.tile-list
	{
		position: relative;
		float: left;
		padding-left: 25px;
		width: 170px;
		height: 140px;
	}
	
	.tile-list img {
		border: 1px solid #ccc;
		display: block;
		width: 145px;
		height: 80px;
	}
	
	.tile-title a {
		font-size: 12px;
		color: #999;
		text-decoration: none;
		padding-bottom: 2px;
		display: block;
	}
	
	.tile-action {
		
		margin-top: 4px;
		text-align: right;
		width: 145px;
	}
	
	.tile-action a
	{
		font-size: 12px;
		color: #666;
		text-decoration: none;
	}
	
	.tile-action a:hover
	{
	
		background: #666;
		color: #fff;
	}
	
	.header-detail
	{
		text-align:right; font-size: 12px; position: absolute; right: 0px; top:12px
	}
	
	.header-detail a
	{
		text-decoration: none;
		color: #666;
	}
	
	.tile-followers
	{
		position: absolute;
		top: 65px;
		height: 20px;
		width: 147px;
		background: #555;
		color: #fff;
		padding-top: 3px;
		text-align: center;
		opacity:.65;filter: alpha(opacity=65); -moz-opacity: 0.65;
	}
	
	.tile-followers:hover
	{
	background: #000;
	color: #fff;
	opacity:1.0;filter: alpha(opacity=100); -moz-opacity: 1.0;	
	}
</style>

<div style="height:20px"></div>	

<div class="header-big" >
	Highlighted 2008 Olympics 
	<span class="small-detail">Follow Shows from the Beijing Olympics</span>
		<div class="header-detail small-detail"><a href="/shows/ls">Search all shows</a></div>
</div>

<div style="padding-top: 20px">
	

<? for ($i=0; $i < count($data_similar); $i++) { ?>

<div class="tile-list">
	<div class="tile-title"><a href="/shows/detail/<?= $data_similar[$i]['show_id'] ?>"><?= substr(stripslashes($data_similar[$i]['title']), 0,26) ?></a></div>
	<a href="/shows/detail/<?= $data_similar[$i]['show_id'] ?>" title="<?= $data_similar[$i]['user_count'] ?> followers"><img src="<?= $data_similar[$i]['thumb'] ?>" /></a>	
	
	<div class="tile-followers">
		<?= $data_similar[$i]['user_count'] ?> followers
	</div>
	
	<? if (User::$user_id != '0') {  //START GUEST OFF ?>
	<div class="tile-action">
		<? if ($data_similar[$i]['following'] == 0){ ?>
		<a href="javascript:sf.update('show_follow_<?= $i ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $data_similar[$i]['show_id'] ?>&plain=1')" id="show_follow_<?= $i ?>" >follow</a>
		<? } else { ?>
			<a href="javascript:if (confirm('Are you sure you want to stop following\nthis show - it will no longer appear in your\nfeed!') ){sf.update('show_unfollow_<?= $i ?>','/users/remove_show_from_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $data_similar[$i]['show_id'] ?>&plain=1')}" id="show_unfollow_<?= $i ?>" >stop following</a>
		<? } ?>	
	</div>
	<? } ?>	
</div>

<? } ?>
</div>	
<br clear="both" />
<div style="height:20px"></div>	

	

