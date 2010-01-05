<div  style="width:525px;  margin: 0 auto; padding-top: 30px ">
	<div class="header-big">
		welcome to snackfeed.com <span class="small-detail">we have been expecting you.</span>
	</div>
	
	<div class="indent-column">
		
		<h3 class="h3-header" >so now what?</h3>
		
		<? $_show_count=  User::get_favorites_count(User::$user_id); 
		   if ($_show_count == 0 ) {
		?>
		<div class="message-block">
			<a href="/users/packages" class="message-title">start following shows</a> - you do not have any shows you are following - add some shows to follow with this quick <a href="/users/packages">wizard</a>.
		</div>
		
		
		<? } ?>
		
		<div class="message-block">
			<a href="/feed" class="message-title">feed</a> - follow your shows and friends on your feed.
		</div>
		
		<div class="message-block">
			<a href="/channels" class="message-title">watch</a> - browse video channels created by our users or <a href="/channels/create">create your own</a>.
		</div>	

		<div class="message-block">
			<a href="/main/content/contact" class="message-title">hello</a> - ask us a question or just say hi.
		</div>	
	
		
	</div>

	<div style="padding-top:40px">
		
		<a href="/feed" class="btn-normal">Ok, take me to my home</a>
		
	</div>


	
	<div style="padding-top:40px">
		
		<a href="/users/welcome_off">stop showing welcome message</a>
		
	</div>
	
	
</div>