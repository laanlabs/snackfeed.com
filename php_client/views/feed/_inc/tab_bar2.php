<div class="feed-tab-holder">
	<!--	
	<span class="feed-tab">
		<a href='?only=messages' style='color: #ffffff; background: #aa3344; padding: 0px 3px 0px 3px; margin-right: 8px; text-decoration: none; '>Messages Today: <?= $new_messages ?>
		</a>
	</span>
-->
<? if ( $section == "home" ) {  ?>
	<div class="feed-tab <?= ($sub_section == "")?("selected"):("") ?>">
		<a href="/feed">All</a>
	</div>
	
	<div class="feed-tab <?= ($sub_section == "messages")?("selected"):("") ?>">
		<a href="/feed/messages">Messages<? if ( $new_messages > 0 ) { ?><span style="padding: 0px 2px 0px 2px; margin-left: 5px; margin-right: 4px; background:#ff5544; color: #ffffff;"><?= $new_messages ?></span><?}?></a>
	</div>
	
	<div class="feed-tab <?= ($sub_section == "my_activity")?("selected"):("") ?>">
		<a href="/feed/me">My Activity</a>
	</div>
	
	<div class="feed-tab <?= ($sub_section == "shows")?("selected"):("") ?>">
		<a href="/feed/shows">Shows</a>
	</div>
	
	<div class="feed-tab <?= ($sub_section == "friends")?("selected"):("") ?>">
		<a href="/feed/friends">Friends</a>
	</div>
	
	<? } else if (  $section == "profile" ) { ?>
		
		<div class="feed-tab selected">
			<a href=""><?= $username ?>'s snackfeed</a>
		</div>
		
		<div class="feed-tab">
			<a href="/feed">&laquo; Back to My Feed</a>
		</div>
		
	<? } else if (  $section == "public_timeline" ) { ?>
		
		<div class="feed-tab selected">
			<a href="/feed/all">Public Timeline</a>
		</div>
		
		<div class="feed-tab">
			<a href="/feed">&laquo; Back to My Feed</a>
		</div>
	
	<? } ?>
	
	<? if ($sub_section != "shows") { ?>
	<span style="float:right; margin-right: 10px;">
	<? if (Prefs::get("feed_view") != "thumbs" ) { ?>
		<a class="mini-link" style="color: #1010dd; text-decoration: none;" href='?feed_view=thumbs'> Show Thumbnails </a>
	<? } else { ?>
		<a class="mini-link" style="color: #1010dd; text-decoration: none;" href='?feed_view=list'> Hide Thumbs </a>
	<? } ?>
	</span>
	<? } ?>
	
</div>




<? if ( $sub_section == "XXXXXshows" ) {  ?>
	
	<div class="basic-text" style="padding: 3px; margin-top: 5px; margin-left: 10px; clear: both">
		<span style="font-weight: normal; color: #555555;">No new messages</span>
		
		<a href="?shows_timeline">timeline view</a>.
		<a href="?shows_items">item view</a>
		<span style="font-weight: bold;">item view</span>
		
	</div>
	
<? } ?>



