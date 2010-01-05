	
	<div align="right" style="" id="side">
		

	

		<? if ( $section == "home"  ) { ?>
			<div class="section" style="margin-bottom: 15px;">

				<div class="button-gradient" id="customize_button" style="margin: 0px 5px 0px; 5px; position: relative" >
					<a href="#" onclick="showDropDown(); stopPropagation(event)" style="font-size: 11pt; font-weight: normal;">
					<!--<span id='customize_button_icon' style='color:#aaeecc;'>+</span>-->
					<img src="/static/images/icons/drop_down.png" border="0"> Customize feed!

					</a>

					<div id="customize_dropdown" style="display: none;">
						
				
					<ul onclick="" id="customize_dropdown-li" >

							<li>
								<a href="/shows">add shows</a>
							</li>

							<li>
								<a href="/users">add people</a>
							</li>

							<li>
								<a href="/users/packages">add show groups</a>
							</li>

							<li>
								<a href="/search">add videos</a>
							</li>

							<li>
								<a href="/search/youtube">videos from youtube</a>
							</li>


					</ul>
						</div>
					</div>	


				</div>
		<? } ?>
	
	
	<? if ( 0 && ($section == "home" || $section == "profile" ) ) { ?>
	<div class="section">
		
		<span style='margin-bottom: 10px;'>
			
			<img style='background: #dddddd; float: left; min-width: 80px; height: 35px;' src='<?= $user_thumb ?>'>
			<span style='color: #999999; margin-left: 5px;'><?= $username ?></span>
		</span> 
		
	</div>
	<? } ?>
	
	<div class="section">

		<div class="section-header">

			<!--<a class="section-links" href='#'>more</a>-->
			<h1>Feed stats</h1>

		</div>

			<ul class="stats">
				<li>
					<span class="label">
						<a href="/users/profile/<?= $user_id ?>?t=following">Following </a>
					</span>
					<span><?= $follow_stats['num_following'] ?></span>
				</li>
				
				<li>
					<span class="label">
						<a href="/users/profile/<?= $user_id ?>?t=followers">Followers </a>
					</span>
					<span><?= $follow_stats['num_followers'] ?></span>
				</li>
				
				<li>
					<span class="label">
						<a href="">Views Caused By <?= ($section=="home") ? ("You") : ($username) ?></a>
					</span>
					<span><?= $follow_stats['profile_views'] ?></span>
				</li>
				
			</ul>	
			
	</div>
	
	
	<div class="section">

		<div class="section-header">
			
			<? if ( $section == "home" ) { ?>
			<span style="float: right; margin-right: 10px; ">
			&nbsp;&nbsp;<a class='mini-link'  href='/users'>add people</a> &nbsp;&nbsp;<a class='mini-link' style="border-left: 1px solid #ccc; padding-left: 8px;" href='/users/profile/<?= $user_id ?>?t=following'>edit</a>
			
			</span>
			<? } ?>
			
			<!--<a class="section-links" href='#'>Invite People</a>-->
			<h1>People</h1>

		</div>

			
		
		<div class="following">
			
			
			<?
				for ($j=0; $j < count( $follow_stats['following'] ); $j++) 
				{
					?>
					
					
					<div class="thumbnail-div">
						<a class="no-hover" title='<?= $follow_stats['following'][$j]['nickname'] ?>'  
							href='/feed?uid=<?= $follow_stats['following'][$j]['user_id']  ?>'><img style="background: #dddddd; width: 36px;" src='<?= $follow_stats['following'][$j]['thumb'] ?>'></a>
					</div>
				
					<?
				}
			?>
			
			<?
			if ( ($section == "home") && count( $follow_stats['following'] ) == 0 ) {
			?>
		<div class="mini-header flash" style="font-size: 11px; padding-bottom: 20px;">You aren't following anyone!
			
			<!--
			<div style="padding: 1px; float: right;  margin-top: 15px; margin-left: 4px;"><a class='mini-link' href='/users/ls'>find people  &raquo;</a>
			</div>-->
			
		</div> 
			<? } ?>
			
			
		</div>
		<div style="height: 20px; clear: left;"></div>
		
		<div class="section-header">
			<!--<a class="section-links" href='#'>Invite People</a>-->
			<? if ( $section == "home" ) { ?>

			<span style="float: right; margin-right: 10px; ">
			&nbsp;&nbsp;<a class='mini-link'  href='/shows'>add shows</a>
			&nbsp;&nbsp;<a class='mini-link'  style="border-left: 1px solid #ccc; padding-left: 8px;" href='/users/profile/<?= $user_id ?>?t=shows'>edit</a>
			
			</span>
			<? } ?>
			
			
			<h1>Shows</h1>
			

		</div>
		

		
		<div class="following">
			
			
			<?
				$max_shows_to_show = 20;
				for ($j=0; $j < min( $max_shows_to_show , count( $follow_stats['shows'] ) ); $j++) 
				{
					?>
					
					
					<div class="thumbnail-div">
						<a class="no-hover" title='<?= $follow_stats['shows'][$j]['title'] ?>'  
							href='/shows/detail/<?= $follow_stats['shows'][$j]['show_id']  ?>'><img style="" src='<?= $follow_stats['shows'][$j]['thumb'] ?>'></a>
					</div>
				
					<?
				}
				
				if ( count( $follow_stats['shows'] ) > $max_shows_to_show ) {
					?> 
						
						
						
						<div style="text-align: right; margin-top: 5px; clear: both">
							<a class='mini-link' href='/users/profile/<?= $user_id ?>'><?= (count( $follow_stats['shows'] ) - $max_shows_to_show) ?> more...</a>
						</div>
					<?
				}
				
			?>
			
			
			<?
			if ( ($section == "home")  && count( $follow_stats['shows'] ) == 0 ) {
			?>
		<div class="mini-header flash" style="padding-bottom: 20px;">You aren't following any shows!
			<!--<div style="padding: 1px; float: right; margin-top: 15px; margin-left: 4px;"><a class='mini-link' href='/shows'>find shows  &raquo;</a></div>-->
		</div> 
			<? } ?>
			
			
		</div>


	</div>

	


	</div>
	
	<!--
	<div class="header-light" style="margin-top: 90px; float: right; width: 200px;">
		<span style="float: right;">You are following</span>
	</div>
-->