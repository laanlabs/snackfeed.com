<div class="two-column-left">
	
	
	<div class="header-big">
		options
	</div>
	<div class="indent-column">
		
<?  if ( strlen($_REQUEST['id'] ) == 36 ) { ?>
	

		
			
		<ul class="side-options" >
			<li><a href="/channels/edit/<?= $_REQUEST['id'] ?>">edit channel detils</a></li>
			<li><a href="/channels/edit_images/<?= $_REQUEST['id']  ?>">edit channel images</a></li>
			<li><a href="/channels/edit_pro/<?= $_REQUEST['id']  ?>">pro channel options</a></li>
			<li><a href="/channels/invite/<?= $_REQUEST['id']  ?>">invite friends to this channel</a></li>
		</ul>	
<? }  else { ?>		
		options availble after create
<? }   ?>				
		
	</div>
	
	
</div>