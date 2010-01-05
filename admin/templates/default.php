<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Admin</title>
	<style type="text/css">
		@import '/lib/css/default.css';
		@import '/lib/css/new.css';		
		@import '/lib/css/tabs.css';				
		@import '/lib/css/menu.css';	
		@import '/lib/css/mktree.css';
		@import '/lib/css/dropMenu.css';			
	</style>	
</head>
<SCRIPT type="text/javascript" SRC="/lib/js/mktree.js"></SCRIPT>
<script type="text/javascript" src="/lib/js/validate.js"></script>
<script type="text/javascript" src="/lib/js/pde.js"></script>
<script type="text/javascript" src="/lib/js/dropMenu.js"></script>


<script type="text/javascript">
		var idField = null;
		var nameField = null;
		var notesField =  null;
		var tools;
		var tools = 'width=450,height=650,resizable=yes,scrollbars=yes';

		function openIDPicker(vID, vName, vLoc)
		{

		win = window.open('/?t=picker&a=' + vLoc,'file',tools);
		win.focus();
		//set the field to add the image to once it's selected
		idField = vID;
		nameField = vName;
		}
</script>

<body>


<!-- START TABS -->









<!--- start top menu bar --->
<div id="tMenu" style="position: absolute; top: 0px; width: 100%">
   <ul>
   	  <li><a href="/">home</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_users')"
	  			>users</a></li>	  
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_sources')"
	  			>sources</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_shows')"
	  			>shows</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_channels')"
	  			>channels</a></li>				
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_recommendations')"
	  			>recommendations</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_uvideos')"
	  			>user videos</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_admin')"
	  			>admin</a></li>
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_help')"
	  			>help</a></li>				
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_feed')"
	  			>public feed</a></li>	
  	 <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_groups')"
	  			>groups</a></li>		  			
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_exts')"
	  			>external</a></li>		
      <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_search')"
	  			>search</a></li>			
     <li><a href=""
 				onClick="return clickreturnvalue()" 
				onMouseover="dropdownmenu(this, event, 'm_reports')"
	  			>reports</a></li>				
				
      </ul>
</div>

<!--- end top menu bar --->




<!-- START MENUS -->
<div id="m_users" class="cDropMenu">
	<a href="/?a=users.list" >List</a>
	<a href="/?a=invites.list" >Invite Codes</a>	
	<a href="/?a=segmentations.list">segmentations</a>	
	<a href="/?a=users.cron_newsletter" >Newsletter Cron</a>	
</div>

<div id="m_sources" class="cDropMenu">
	<a href="/?a=sources.list">list</a>
	<a href="/?a=sources.edit&source_id=0">add</a>
</div>

<div id="m_shows" class="cDropMenu">
	<a href="/?a=shows.list">list</a>
	<a href="/?a=shows.edit&show_id=0">add</a>	
	<a href="/?a=shows.cron">run cron</a>	
	<a href="/?a=shows.packages">packages</a>	
	<a href="/?a=shows.tags">tags</a>	
</div>

<div id="m_channels" class="cDropMenu">
	<a href="/?a=channels.list">list</a>
	<a href="/?a=channels.edit&channel_id=0">add</a>
	<a href="/?a=channels.cron">run cron</a>	
</div>

<div id="m_recommendations" class="cDropMenu">
	<a href="/?a=recommendations.videos">list videos</a>
	<a href="/?a=recommendations.cron_videos">run videos cron</a>
</div>

<div id="m_uvideos" class="cDropMenu">
	<a href="/?a=uvideos.list">list user videos</a>
</div>


<div id="m_admin" class="cDropMenu">
	<a href="/?a=notifications.list">notifications</a>
	<a href="/?a=utils.sitemaps">sitemaps</a>
	<a href="/?a=blogs.list">blogs</a>	
	<a href="/?a=utils.blogping">blog pings</a>		
	<a href="/?a=utils.twitter">twitter</a>		
	<a href="/?a=utils.trends">trends</a>			
</div>


<div id="m_help" class="cDropMenu">
<a href="/?a=helps.list">List Help</a>
<a href="/?a=helps.edit&help_id=0">add help</a>
</div>

<div id="m_feed" class="cDropMenu">
<a href="/?a=public_feeds.programs">shows</a>
<a href="/?a=public_feeds.cron">shows cron</a>
<a href="/?a=public_feeds.videos_popular">videos popular cron</a>
<a href="/?a=public_feeds.alerts">alerts</a>
<a href="/?a=public_feeds.external">external</a>
</div>

<div id="m_groups" class="cDropMenu">
<a href="/?a=groups.list">list upcoming</a>
</div>

<div id="m_exts" class="cDropMenu">
<a href="/?a=exts.list">ext sources</a>
<a href="/?a=ext.users">ext user accounts</a>
<a href="/?a=ext.cron">cron</a>
</div>

<div id="m_search" class="cDropMenu">
<a href="/?a=search.index">index</a>

</div>

<div id="m_reports" class="cDropMenu">
<a href="/?a=reports.users">users</a>
<a href="/?a=reports.newsletters">newsletter</a>
<a href="/?a=reports.batches">batches</a>
</div>


<!-- END MENUS -->
<br/>
<br/>
<br/>
<div id="breadcrumb"> <?= $win_title ?></div>
<div id="winMain" >
<br clear="all"" />

<?
//include the view template
include MODELS."/".$_m."/views/". $_v .".php";
?>
</div>

<br/><br/><br/><br/>

<?
include "../debug.php";
?>


</body>
</html>
