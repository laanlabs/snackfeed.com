
<? include "_inc/header.php"; ?>

	<link rel="stylesheet" href="/static/css/v3/legacy.css" type="text/css" media="screen"  charset="utf-8" />

</head>


<body id="default">
	

	<div id="main-wrapper">
		
	<?	include "_inc/nav_bar.php"; ?>

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


