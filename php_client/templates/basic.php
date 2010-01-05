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
	
	<title><?= $sf_title ?></title>
	<meta name="title" content="<?= $sf_meta_title ?>" />
	<meta name="description" content="<?= $sf_meta_desc ?>" />
	<meta name="keywords" content="<?= $sf_meta_keywords ?>" />	
	
	<link rel="stylesheet" href="/static/css/v2/default.css" type="text/css" media="screen"  charset="utf-8">
	<link rel="icon" type="image/png" href="/static/cheese.png"/>
	<link rel="Shortcut Icon" href="/static/favicon.ico" />
	<script src="/static/js/prototype.js" type="text/javascript"></script>
	<script src="/static/js/scriptaculous.js" type="text/javascript"></script>
	<script src="/static/js/swfobject1_5.js" type="text/javascript" charset="utf-8"></script>	
	<script src="/static/js/snackfeed.js" type="text/javascript" charset="utf-8"></script>	
	<meta name="verify-v1" content="86aEUALOf0odRxTJVDbHvTgzImspgcNafCEicXqwfro=" />

	<?=  $header_block ?>
	
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
				
				<div style="position: relative; top: 20px; margin-left: 15px; float: left;">
					<img src="/static/images/icons/cheese_guy.png">
				</div>
				
			</div>
			
		</div>
		
		<div id="logo">
			<a href="/" class="no-hover" style="text-decoration: none;"><img src="/static/images/v3/logo_sm.png" border="0" alt="snackfeed ~ now with more cheese...." style="vertical-align:bottom;"/></a>
		</div>
		
	<div id="user-bar">
			
			<a href="/users/register">register</a> <span style="padding:0px 1px 0px 1px; color: #aaa;">|</span>
			<a href="/users/login">login</a>
	
	</div>

		<!--
		<div style="height: 18px; width: 100px; background: #ff0000; text-align: center; padding-top:3px; float:right">
			<a style="color: #fff; text-decoration: none" onclick="window.open('/help/<?= $_controller ?>/<?= $_REQUEST['action'] ?>','mywindow','scrollbars=1,width=720,height=500')" href="#" title="get help / comment / contact / submit a bug / ">feedback / help</a>
		</div>
	-->
		
	</div>
	
	<br clear="all" />
	

	
	<div id="main-content">
	

		
		
		
		
<?	include VIEWS."/{$_controller}/{$_action}.php" ?>
				
	</div>	


<br clear="both" />

<div style="width: 100%; padding-top: 50px; ">
	
<div id="footer">
	
 <a class="no-hover" href="/main/content/contact">contact</a> <span style="padding:0px 1px 0px 1px; color: #ccc;">|</span>  
  <a class="no-hover" href="http://cheese.snackfeed.com">product blog</a> <span style="padding:0px 1px 0px 1px; color: #ccc;">|</span>
 <a class="no-hover" href="http://labs.laan.com/blog">company blog</a> <span style="padding:0px 1px 0px 1px; color: #ccc;">|</span>

	<a class="no-hover" style="width: 10px; padding: 0px; text-decoration: none; border:none" href="http://twitter.com/snackfeed"><img style="position:relative; top: 3px; left: 4px; padding: 0px; text-decoration: none; border: none; outline: none;" src="/static/images/icons/twitter.png"></a><a class="no-hover" style="border:none" href="http://twitter.com/snackfeed">@snackfeed</a> 	


<div style="font-size: 10px; color: #aaa; padding: 35px 5px 5px 5px;">
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


