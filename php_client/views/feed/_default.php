
<div id="main-content-left" >


<? if ($show_welcome) { ?>
<div id="feed-flash-message" style="position:relative" class="flash">

	<div style="position: absolute; right: 7px; top: 7px">
		<a style="font-size: 18px; padding: 1px 4px 1px 4px; margin-left: 10px; border: 1px dashed #cccccc; background: #ffffff; text-decoration: none; color: #999999;" href="#" onclick="Effect.BlindUp('feed-flash-message');"> <span style="color:#ff2255">X</span> close </a>
	</div>


	<div style="padding: 8px 5px 10px 8px;">
		Welcome to snackfeed!
		
		<div style="padding: 2px; margin-top: 4px; color: #777777; font-size: 15px;">
			This is your feed page, to make it interesting, try <a href="#">following some shows</a>, or <a href="#">finding some people</a>. 
		</div>
		
	</div>
	
</div>
<? } ?>




<div id="feed-container">
	
	<div class="" style="height: 10px;"></div>
	
	
	<? if ( $section == "home" || $section == "profile" ) { ?>
	
	<div style="height: 45px; ">
		
		<span style='margin-bottom: 10px;'>
			<img style='background: #dddddd; float: left; height: 35px; border: 1px solid #ccc' src='<?= $user_thumb ?>'>
			<span style='position: relative; color: #999999; margin-left: 5px; font-size: 30px'><?= $username ?>'s feed</span>
		</span>
		
	</div>
	<? } else { ?>
	
		<div style="height: 45px; ">

			<span style='margin-bottom: 10px;'>
				<span style='position: relative; color: #999999; margin-left: 5px; font-size: 30px'>Public Feed</span>
			</span>

		</div>
		
	<? } ?>

	<?
	
		include "_inc/tab_bar2.php";
	
	?>




	
<? if (count($data) == 0) {?>

<? if ($section == "home" ) { 
	
	
	if ( $sub_section == "shows" ) {
		
		?> 
		<div class="feed-warning"  >
		<h1>You aren't following any shows.</h1>
		
		<div>
		 Find some shows to follow <a href="/shows">here</a>.
		</div>
		
		
		</div>
		
		<?
		
	} else if ( $sub_section == "messages" ) {
		
		?>
		
		<div class="feed-warning"  >
			<h1>No messages.</h1>
		</div>
		
		
		<?
		
	} else if ( $sub_section == "my_activity" ) {
		
			?>
			<div class="feed-warning" >
			<h1>You are not an active person ( on this site. )</h1>
			<div> Start by <a href="/channels">watching</a> some videos.</div>
			</div>
			<?
			
	} else if (  $sub_section == "friends" ) {
		
		?>
		<div class="feed-warning"  >
		<h1>You have nothing in your snackfeed!</h1>
		<div>Try following some <a href="/shows">shows</a> you like, or find some <a href="/users">people</a> to follow.</div>
		</div>
		<?
		
	}
	
 } else { ?>

	<div class="feed-warning"  >
	<h1><?= $username ?> has nothing in their snackfeed!</h1>
	</div>

	
<? } ?>



<? } else {?>



<div style="padding: 5px; height: 20px; margin-bottom: 10px">
</div>


<? } 

if ( $sub_section == "shows" ) {
	
	include "_inc/user_blog_view.php";
	
} else {
	
	include "_inc/user_timeline_view.php";
	
}

?>




		

	</div>
	<?
	 $pop_height = 73;
	 $pop_width = 190;
	 $shadow = 5;
	
	?>
 <div id="feed-mouse-over" style="display:none; background: #eeffee; border: 1px solid #aaaaaa; position: absolute; height: <?= $pop_height ?>px; width: <?= $pop_width ?>px;">
		
		<span style="padding: 3px; color: #999999; font-weight: bold; font-size: 16px;" id="popup-title"></span>
		
		<div style="padding: 2px;">
		<img style="width: 45px;" id="popup-thumbnail">
		
		<a id="popup-subscribe-link" href="#"> Subscribe! </a>
		</div>
		
		
		<span style="padding: 2px; color: #999999; font-size: 12px;" id="popup-description"></span>
		
		
		
		<div style="position: absolute; top: <?= $shadow ?>px; left: <?= $pop_width ?>px; height: <?= $pop_height ?>px; width: <?= $shadow ?>px; background: #333333; opacity:.2;filter: alpha(opacity=20); -moz-opacity: 0.2;"></div>
		
		<div style="position: absolute; top: <?= $pop_height ?>px; left: <?= $shadow ?>px; height: <?= $shadow ?>px; width: <?= $pop_width - $shadow ?>px; background: #333333; opacity:.2;filter: alpha(opacity=20); -moz-opacity: 0.2;"></div>
		
 </div>



</div>

	<?
		if (  $section == "profile" || $section == "home"  ){
			include "_inc/sidebar.php";
		}
	?>



	<script type="text/javascript">
	
	var drop_open = "off";
	
	function stopPropagation(event)
	{
		
		Event.stop(event);
		
	 //if(!event)
	 //var event = window.event;
	 //
	 //if(event.stopPropagation)
	 //event.stopPropagation();
	 //else if(window.event.cancelBubble == false)
	 //window.event.cancelBubble = true;
	}
   
	function showDropDown( )
	{
		//Event.stop(event);
		
	 var customize_dropdown = $('customize_dropdown');
	 var customize_button = $('customize_button');
		
	 if( drop_open == 'off')
	 {
	 customize_dropdown.style.display = 'block';
	 //customize_button.className = 'tcnetwork_top_on';
	 drop_open = 'on';
	 Event.observe( document.body , 'click', showDropDown );
		//s.observe('mouseover', mouseOverLink );
	 //document.body.addEventListener('click',showDropDown,false);
		//$("customize_button_icon").update("-&nbsp;");
	 }
	 else
	 {
	 customize_dropdown.style.display = 'none';
	 //customize_button.className = '';
	 drop_open = 'off';
		Event.stopObserving( document.body , 'click', showDropDown )
	 //document.body.removeEventListener('click',showDropDown,false);
	 //$("customize_button_icon").update("+");
	 }
	}
	
</script>
