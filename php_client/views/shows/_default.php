
<style type="text/css" media="screen">
	.tile-list
	{
		position: relative;
		float: left;
		padding-left: 15px;
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
		text-align:right; font-size: 12px; position: absolute; right: 0px; top:8px
	}
	
	.header-detail a
	{
		text-decoration: none;
		color: #666;
		
	}
</style>


<div style="padding-top:90px">
	
</div>

<div id="search-wrapper" >
	<form id="searchForm" method="get" action="/shows/ls" name="searchForm">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" style="width: 220px" >
				<a href="javascript:document.searchForm.submit();">search for shows</a>
			</div>
		</div>
		<div style="float:right; position: relative; top: 15px">
			<a href="/shows/ls" class="blue-link" style="font-size:18px;" >&raquo; browse all shows</a>
		</div>
	</form>
</div>

<br clear="both" />
<div style="height:20px"></div>	


<? if (count($data_similar) > 0 ) { ?>

<div class="header-big" >
	shows you might like
</div>

<div style="padding-top: 20px">
	

<? for ($i=0; $i < count($data_similar); $i++) { ?>

<div class="tile-list">
	<div class="tile-title"><a href="/shows/detail/<?= $data_similar[$i]['show_id'] ?>"><?= substr(stripslashes($data_similar[$i]['title']), 0,20) ?></a></div>
	<img src="<?= $data_similar[$i]['thumb'] ?>" />	
	<div class="tile-action"><a href="javascript:sf.update('show_follow_<?= $i ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $data_similar[$i]['show_id'] ?>&plain=1')" id="show_follow_<?= $i ?>" >follow</a></div>
	
</div>

<? } ?>
</div>	
<br clear="both" />
<div style="height:20px"></div>	
<? } ?>	
	
	
<div class="header-big" >
	staff favorites
</div>

<div style="padding-top: 20px">
	

	<? for ($i=0; $i < count($data_picks); $i++) { ?>

	<div class="tile-list">
		<div class="tile-title"><a href="/shows/detail/<?= $data_picks[$i]['show_id'] ?>"><?= substr(stripslashes($data_picks[$i]['title']), 0,20) ?></a></div>
		<img src="<?= $data_picks[$i]['thumb'] ?>" />	
		<div class="tile-action"><a href="javascript:sf.update('show_follow_2<?= $i ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $data_picks[$i]['show_id'] ?>&plain=1')" id="show_follow_2<?= $i ?>" >follow</a></div>

	</div>

	<? } ?>
</div>	
