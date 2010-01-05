<div style="padding-top:70px"></div>

<style type="text/css" media="screen">
	.tile-list
	{
		position: relative;
		float: left;
		padding-left: 25px;
		width: 170px;
		height: 130px;
	}
	
	.tile-list img {
		border: 1px solid #ccc;
		display: block;
		width: 145px;
		height: 80px;
	}
	
	.tile-title {
		font-size: 14px;
		color: #999;
	}
	
	.tile-action {
		
		margin-top: 9px;
		text-align: right;
		width: 145px;
	}
	
	.tile-action a
	{
		padding: 5px 10px 2px 10px;
		border: 1px solid #ccc;
		color: #666;
		text-decoration: none;
		background: #eee;
	}
	
	.tile-action a:hover
	{
	
		background: #666;
		color: #fff;
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
</style>

<div id="search-wrapper" >
	<form id="searchForm" method="get" action="/users/ls" name="searchForm">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" style="width: 220px" >
				<a href="javascript:document.searchForm.submit();">search for people</a>
			</div>
		</div>

	</form>
</div>

<br clear="both" />
<div style="height:20px"></div>



<? if (count($data_know) > 0 ) { ?>

<div class="header-big" >
	people you might know
	<div class="header-detail" 	><a href="/users/ls">search all users</a></div>
</div>

<div style="padding-top: 20px">
	

<? for ($i=0; $i < count($data_know); $i++) { ?>

<div class="tile-list">
	<div class="tile-title"><?= $data_know[$i]['nickname'] ?></div>
	<img src="<?= $data_know[$i]['thumb'] ?>" />	
	<div class="tile-action"><a href="javascript:sf.update('user_follow_<?= $i ?>','/users/follow/<?= $data_know[$i]['user_id'] ?>?&plain=1')" id="user_follow_<?= $i ?>" >follow</a></div>
	
</div>

<? } ?>
</div>	
<br clear="both" />
<div style="height:20px"></div>	
<? } ?>	
	
	
<div class="header-big" >
	people similar to you
	<div class="header-detail" 	><a href="/users/ls">search all users</a></div>
</div>

<div style="padding-top: 20px">
	

<? for ($i=0; $i < count($data_similar); $i++) { ?>

<div class="tile-list">
	<div class="tile-title"><?= $data_similar[$i]['nickname'] ?></div>
	<img src="<?= $data_similar[$i]['thumb'] ?>" />	
	<div class="tile-action"><a href="javascript:sf.update('user_follow_2<?= $i ?>','/users/follow/<?= $data_similar[$i]['user_id'] ?>?&plain=1')" id="user_follow_2<?= $i ?>" >follow</a></div>
	
</div>

<? } ?>
</div>	
	