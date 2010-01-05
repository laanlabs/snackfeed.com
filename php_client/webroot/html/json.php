<?=

phpinfo();
die();
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>JSON with Connection Manager</title>

<style type="text/css">
	@import 'css_test.css';
</style>


<!-- START LOGGER FILE --> 
<link type="text/css" rel="stylesheet" href="yui/build/logger/assets/skins/sam/logger.css"> 
<script type="text/javascript" src="yui/build/yahoo-dom-event/yahoo-dom-event.js"></script> 
<script type="text/javascript" src="yui/build/dragdrop/dragdrop-min.js"></script> 
<script type="text/javascript" src="yui/build/logger/logger-min.js"></script>
<!-- END LOGGER FILE --> 


<link rel="stylesheet" type="text/css" href="yui/build/fonts/fonts-min.css" />
<script type="text/javascript" src="yui/build/json/json.js"></script>
<script type="text/javascript" src="yui/build/connection/connection.js"></script>


<script type="text/javascript" src="yui/build/yahoo/yahoo.js"></script>
<script type="text/javascript" src="yui/build/event/event.js"></script>
<script type="text/javascript" src="yui/build/dom/dom.js"></script>

<script type="text/javascript" src="yui/build/animation/animation.js"></script>

<script type="text/javascript" src="script_test.js"></script>


</head>

<body class=" yui-skin-sam">

	<div id="boundary">

	<form action="#">
	<p id="entry"><label for="tag">Start with a word:</label>
	<input type="text" id="tag" name="tag" value="pandas" /><input type="submit" value="go shows!" /></p>
	<div id="pagination"></div>	
	<div id="results">
		</div>	
	</form>
	</div>

<div id="playlistDiv" style="width:300px; height: 400px; background-color: #ffffff;">
	<p id="entry">PLAYLIST</p>
	
	
</div>	
	


<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->



<script type="text/javascript">


this.myLogReader = new YAHOO.widget.LogReader();


YAHOO.util.Event.on(window,'load',tubeLister.init);

var dd1 = new YAHOO.util.DD("playlistDiv");


</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->


</body>
</html>
