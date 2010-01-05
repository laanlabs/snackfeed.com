
<form name="form_search" method="get" action="/search" >
<div id="nav-bar-wrapper">
	<div id="nav-bar-blue" >
		<div id="logo" style="position:relative; left: 10px; float:left; padding-right: 10px" ><a href="/"><img src="/static/images/v3/nav/logo_slant.png" width="159" height="30" alt="" /></a></div>
		
			<div id="nav-menu">
			<ul>
			<? if (User::$user_id == '0' ){ ?>	
				<li class=" selected<?= $_nav_public ?> "><a href="/public" class="nav-item" >feed</a></li>
				<li class=" selected<?= $_nav_shows ?>"><a href="/shows" class="nav-item" >shows</a></li>
				<li class=" selected<?= $_nav_channel ?>"><a href="/channels" class="nav-item" >popular</a></li>				
			<? } else { ?>
				<li class=" selected<?= $_nav_feed ?> "><a href="/feed" class="nav-item" >feed</a></li>
				<li class=" selected<?= $_nav_shows ?>"><a href="/shows" class="nav-item" >shows</a></li>
				<li class=" selected<?= $_nav_playlist ?> "><a href="/users/playlists/<?= User::$user_id ?>" class="nav-item" >playlist</a></li>
				<li class=" selected<?= $_nav_profile ?> "><a href="/users/profile/<?= User::$user_id ?>" class="nav-item" >profile</a></li>		
			<?  }?>		
			</ul>
			</div>
			
			
		</div>
		<div id="nav-bar-blue-end"></div>

		<div id="nav-bar-right">
			
			
			<div id="user-bar">
			<ul>
			<? if (User::$user_id == '0' ){ ?>
			<li><a href="/users/register">register</a></li> 
			<li><a href="/users/login">login</a></li> 
			<? } else { ?>
			<li><a href="/users/edit/<?= User::$user_id ?>" title="edit my user settings" >account</a>
			<li><a href="/users/logout">logout</a></li> 
			<?  }?>
			</ul>
		</div>
				
				
			
			
			
			
				<div id="search-holder">
						<span id="search_indicator" style="display: none; padding-top: 2px; margin-right: 4px;">
						  <img style="border:none;" src="/static/images/v2/ajax-loader.gif" alt="Working..." />
						</span>
						<input type="text" name="q" value="search videos" id="search_box" onblur="resetText('search_box', 'search videos');" onfocus="javascript:clearText('search_box','search videos');" autocomplete="off"  /> 
					</div>
					<div id="search-btn">	
						<a href="javascript:document.form_search.submit();" style=""><img src="/static/images/v3/nav/btn_search.png" width="23" height="23" border="0" alt="search for videos" /></a>
					</div>			
			
			
			
			
		</div>
</div>
</form>