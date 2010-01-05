<?

include "_inc/header.php";

?>

	<link rel="stylesheet" href="/static/css/v3/public_splash.css?2" type="text/css" media="screen"  charset="utf-8" />

</head>


<body id="body-el">
	

	<div id="main-wrapper">

		<div id="topbar">

			<div id="top-tab">
				<div id="top-tab-left">
					
				</div>
				
			<div id="top-tab-center">
	<form name="form_search" method="get" action="/search" >
			<div id="top-tab-links">
			<? if (User::$user_id == '0' ){ ?>
			<a href="/users/register" style="color:#555; padding-right: 5px">join</a>
			<div style="color:#ccc; float: left; padding-right: 5px" >or</div> 
			<a href="/users/login" style="color:#555">login</a>
			<a href="/shows" title="browse shows" style="color:#555;" >browse shows</a>
			<? } else { ?>
			<a href="/feed/<?= User::$user_id ?>" title="my feed"  >my feed</a>
			<a href="/shows" title="browse shows" >shows</a>
			<a href="/users/edit/<?= User::$user_id ?>" title="edit my user settings" >account</a>
			<a href="/users/logout">logout</a>		
			<?  }?>
			</div>
		
			<div id="search-holder" style="float:left; padding-top: 3px">
						<span id="search_indicator" style="display: none; padding-top: 2px; margin-right: 4px;">
						  <img style="border:none;" src="/static/images/v2/ajax-loader.gif" alt="Working..." />
						</span>
						<input type="text" name="q" value="search videos" id="search_box" onblur="resetText('search_box', 'search videos');" onfocus="javascript:clearText('search_box','search videos');" autocomplete="off"  /> 
					</div>
					<div id="search-btn" style=" padding-top: 2px">	
						<a href="javascript:document.form_search.submit();" style=""><img src="/static/images/v3/nav/btn_search.png" width="23" height="23" border="0" alt="search for videos" /></a>
					</div>			
			
					
				</div>
				<div id="top-tab-right">
					
				</div>	
					
					
					
					
					
			</div>
			</form>

			<div id="logo">
				<a href="/" alt="Snackfeed tracks the best videos from all over the web!" title="Welcome to Snackfeed"><img title="Snackfeed feeds you the best web video!" alt="Snackfeed" src="/static/images/v3/splash/logo_med.png"></a>
			</div>
			
			<div id="big-quote">
					<a href="/" alt="Snackfeed tracks the best videos from all over the web!" title="Welcome to Snackfeed">
						<img title="Snackfeed feeds you the best web video!" alt="Snackfeed" src="/static/images/v3/splash/bubble_sm.png">
					</a>
						</div>
			
			<div id="exposed-frame">
				<a href="/" alt="Snackfeed tracks the best videos from all over the web!" title="Welcome to Snackfeed"><img title="Snackfeed feeds you the best web video!" alt="Snackfeed" src="/static/images/splash/exposed_frame3.png"></a>
			</div>

		</div>
		

		<br clear="all" />


			
			
			
		<?	include VIEWS."/{$_controller}/{$_action}.php"; ?>


	
	
	
	<br clear="both" />

		<?	include "_inc/footer.php"; ?>
		
		
	<!-- end main-wrapper -->
	</div>
	
	
	<?	include "_inc/analytics.php"; ?>
	
	
<div id="autocomplete_choices" class="autocomplete" style="display:none;">
</div>


<script>

sf.createAutoComplete();
//setTimeout( sf.createAutoComplete , 1000 );
Event.observe(window, 'load', sf.bodyLoaded );


</script>
	
	
</body>


</html>