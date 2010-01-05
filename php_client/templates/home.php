<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<!--
      ___           ___           ___           ___           ___     
     /\  \         /\__\         /\  \         /\  \         /\__\    
    /::\  \       /::|  |       /::\  \       /::\  \       /:/  /    
   /:/\ \  \     /:|:|  |      /:/\:\  \     /:/\:\  \     /:/__/     
  _\:\~\ \  \   /:/|:|  |__   /::\~\:\  \   /:/  \:\  \   /::\__\____ 
 /\ \:\ \ \__\ /:/ |:| /\__\ /:/\:\ \:\__\ /:/__/ \:\__\ /:/\:::::\__\
 \:\ \:\ \/__/ \/__|:|/:/  / \/__\:\/:/  / \:\  \  \/__/ \/_|:|~~|~   
  \:\ \:\__\       |:/:/  /       \::/  /   \:\  \          |:|  |    
   \:\/:/  /       |::/  /        /:/  /     \:\  \         |:|  |    
    \::/  /        /:/  /        /:/  /       \:\__\        |:|  |    
     \/__/         \/__/         \/__/         \/__/         \|__|    
      ___           ___           ___           ___     
     /\  \         /\  \         /\  \         /\  \    
    /::\  \       /::\  \       /::\  \       /::\  \   
   /:/\:\  \     /:/\:\  \     /:/\:\  \     /:/\:\  \  
  /::\~\:\  \   /::\~\:\  \   /::\~\:\  \   /:/  \:\__\ 
 /:/\:\ \:\__\ /:/\:\ \:\__\ /:/\:\ \:\__\ /:/__/ \:|__|
 \/__\:\ \/__/ \:\~\:\ \/__/ \:\~\:\ \/__/ \:\  \ /:/  /
      \:\__\    \:\ \:\__\    \:\ \:\__\    \:\  /:/  / 
       \/__/     \:\ \/__/     \:\ \/__/     \:\/:/  /  
                  \:\__\        \:\__\        \::/__/   
                   \/__/         \/__/         ~~       


-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<title>
		Snackfeed
	</title>
	
	<link rel="stylesheet" href="/static/css/v2/default.css" type="text/css" media="screen"  charset="utf-8">
	<link rel="icon" type="image/png" href="/static/cheese.png"/>
	<link rel="Shortcut Icon" href="/static/favicon.ico" />
	<script src="/static/js/prototype.js" type="text/javascript"></script>
	<script src="/static/js/scriptaculous.js" type="text/javascript"></script>
	<script src="/static/js/swfobject.js" type="text/javascript" charset="utf-8"></script>	
	<script src="/static/js/snackfeed.js" type="text/javascript" charset="utf-8"></script>	

	
	
	
</head>
<body>
	
		
<div id="main-wrapper">
	
	<div id="topbar">
		
		<!-- CC added this cheese logo, feel free to remove -->
		<div id="swfLogoHolder2" style="overflow: visible; width: 1px; height:1px; position: absolute; top:5px; left: -175px;">
			<div id="swfLogoHolder" style="">
			</div>
			<?
				$catch_array = array("Hate to read?<br/>Try snackfeed!","Take a break<br/>with snackfeed!");
				$lenof = (int)(count($catch_array));
				$rndnum = round( rand() % $lenof );
				$catch_phrase = $catch_array[$rndnum];
				$rndnum2 = round(rand()%10);
			
			?>
			<div id="voice-bubble-holder" style="width: 300px; ">
				
					<div id="voice-bubble" style=" width: 105px; height: 20px; float: left; ">
						<? if ( 0 && $rndnum2 == 5 ) { ?>
						<div style="text-align: center; font-family:'Lucida Grande',sans-serif; color: #777777; left: 3px; top: 4px; padding: 4px; width: 95px; position: absolute; overflow: visible; "><?= $catch_phrase ?></div>
						<img src="/static/images/v2/voice_bubble.png">
						<? } ?>
					</div>
				
				<div style="position: relative; top: -20px; margin-left: 15px; left: -25px; float: left;">
					<img src="/static/images/icons/cheese_guy_olympics.png">
				</div>
				
			</div>
			
		</div>
		
		<div id="logo">
			<a href="/" class="no-hover" style="text-decoration: none;"><img src="/static/images/v2/logo_top.png" width="243" height="35" border="0" alt="snackfeed ~ now with more cheese...." style="vertical-align:bottom;"/></a>
		</div>
		
		
		<div id="user-bar">
			
			<? if (User::$user_id == '0' ){ ?>
			<a href="/users/login">login</a>
			<? } else { ?>
			<a href="/users/edit/<?= User::$user_id ?>" title="edit my user settings" ><?= User::$username ?></a> |
			<a href="/users/logout">logout</a>
			<?  }?>
		</div>


		
		<div style="height: 18px; width: 100px; background: #ff0000; text-align: center; padding-top:3px; float:right">
			<a style="color: #fff; text-decoration: none" onclick="window.open('/help/<?= $_controller ?>/<?= $_REQUEST['action'] ?>','mywindow','scrollbars=1,width=720,height=500')" href="#" title="get help / comment / contact / submit a bug / ">feedback / help</a>
		</div>
		
		
	</div>
	
	<br clear="all" />
	
	

		<div align="center" id="gmail-flash-holder" style="position: absolute; display: none; width:100%; text-align: center;">
			<div align="center" id="gmail-flash-message" class="gmail-error"></div>
		</div>
	
	<div id="main-content">


	<div id="olympics-modal" style="">
		<h3 style="padding: 3px 0px 3px 6px;  border-bottom: 1px solid #ccc;">Welcome to Snackfeed Olympics!</h3>
		<div style="padding-left: 6px; margin-top: 5px; color: #000; font-size: 12px">For a limited time we are featuring the latest videos from the 2008 Beijing Olympics. Register to get enhanced features or signup to receive
		email updates on all the Olympic action. &nbsp;&nbsp;<span style=" color: #777; font-style: italic;">To get to your normal feed, <a href="/users/login" >login</a></span>.</div>
		
		
		<div class="modal-button" style="top: 98px; left: 50px; width: 150px;">
			<a href="/users/register">Get More Features</a>
		</div>
		

		<div class="modal-button" style="top: 98px; left: 475px; width: 200px;">
			<a style="" href="#" onclick="$('email-alert-box').toggle();">Get Email Alerts</a>

		</div>
		
		<div id="email-alert-box" style="display: none; position: absolute; top: 130px; left: 475px; width: 350px; height: 26px;">
			
					<input id="alert_email" height="25" onkeyup="if(event.keyCode==13) signupAlerts();" type="text" name="email" style="width:150px; " value="enter e-mail">
					<input onclick="signupAlerts();" height="25" id="newsletter-button" type="submit" value="Get Alerts!">

			
		</div>
	
	
	</div>
		
		
		
		
<?	include VIEWS."/{$_controller}/{$_action}.php" ?>
				
	</div>	


	<br clear="both" />
<div style="width: 100%; padding-top: 50px; ">	
<div id="footer">
 <a href="/main/content/lowdown">about</a> | 
 <a href="/main/content/contact">contact</a> |  
  <a href="http://cheese.snackfeed.com">product blog</a> |
 <a href="http://labs.laan.com/blog">company blog</a> 


<div style="padding: 10px;">
<a style="border:none" href="http://twitter.com/snackfeed">follow us on twitter</a> 	
</div>
<div style="padding: 5px">
&copy 2008 desoto ventures, llc
</div>
  
</div>
 

</div>



</div>




<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-654321-13");
pageTracker._initData();
pageTracker._trackPageview();
</script>





<script>


//setTimeout( sf.createAutoComplete , 1000 );


</script>


</body>
</html>


