<div class="header-light" style=" margin-left: 0px; padding-right: 3px;">
	
	<?
		if ( $section == "tl" ){
			 
				if ( $sub_section == "friends" )
				$_title_feed = 'Friends';
				else if ( $sub_section == "my" )
				$_title_feed = $username .'\'s feed';
				
		} else if ( $section == "public" ) {
			
			$_title_feed = 'Public feed';
			
		} else {
			
			$_title_feed = 'Shows';
			
		}
	
	?>
	
	
	<div style="float: left;"> 
	
		<?= $_title_feed ?>
		<!-- <br/> <span class="small-detail">updates from people and shows you're following.</span> -->
	</div>
	
	<span style="float:left; margin-left: 10px;">
	<? if (Prefs::get("feed_view") != "thumbs" ) { ?>
		<a class="mini-link" style="text-decoration: none;" href='?feed_view=thumbs'> Show Thumbnails </a>
	<? } else { ?>
		<a class="mini-link" style="text-decoration: none;" href='?feed_view=list'> Hide Thumbs </a>
	<? } ?>
	</span>
	
		<span class="basic-text" style=" float: right; margin-top: 5px;">
			

			<? if ($profile_view) { ?>
				
				<? if ( $filter == 'only_likes' ) { ?>
					
					<a href='/feed?uid=<?= $user_id ?>'> <span style='color: #ff2255;'>X</span> Show All </a>
					
				<? } else { ?>
					
					<img src='/static/images/icons/feed_like_icon.png' style='text-decoration: none; position:relative; top: -1px; padding-right: 3px; margin-left: 1px;'>
					<a href='/feed?uid=<?= $user_id ?>&only=likes'>
						Only show likes
					</a>
				<? } ?>
				
				
			<?} else {?>
				
				<? if ( $sub_section == "my" ) { ?>
					<span style="color: #666666;"> My feed </span>
				<? } else { ?>
					<a href='/feed'> My feed </a>
				<? } ?>	
				 -
				<? if ( $sub_section == "friends" ) { ?>
					<span style="color: #666666;"> Only Friends </span>
				<? } else { ?>
					<a href='/feed/friends' >Only Friends </a>
				<? } ?>
				 - 
				<? if ( $sub_section == "shows" ) { ?>
					<span style=" color: #666666;">Just Shows</span>
				<? } else { ?>
					<a href='/feed/shows'>Just Shows</a>
				<? } ?>
				
		 <?}?>
		</span>
		
	
</div>

<div style="height: 20px; background: #eeeeee; padding: 8px 0px 4px 10px; font-size: 12px; color: #999999;">
	
	
	<? if (!$profile_view && $new_messages > 0 ) { ?>
		
		
	<span style=" text-transform: uppercase;"><a href='?only=messages' style='color: #ffffff; background: #aa3344; padding: 0px 3px 0px 3px; margin-right: 8px; text-decoration: none; '>Messages Today: <?= $new_messages ?></a></span>
	
	<? if ( $filter == 'only_messages' ) { ?>
		<a href='/feed'>&lt; Back to my feed</a>
	<? } ?>
	<!--<span style="padding: 0px 3px 0px 3px; color: #ffffff; background: #33aa44; text-transform: uppercase;">Recommended: 1</span>-->
	
	<? } ?>
	
</div>