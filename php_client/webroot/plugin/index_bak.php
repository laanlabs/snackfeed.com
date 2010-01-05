<?

$html =  stripslashes($_REQUEST['_body']);


$canArray = array();

$dom = new DOMDocument();
$dom->resolveExternals = false;
$dom->validateOnParse = true;
$dom->preserveWhiteSpace = true;
$dom->substituteEntities = true;
$dom->formatOutput = false;
@$dom->loadHTML($html);


$_inputs = $dom->getElementsByTagName('input');

//echo $_inputs->length.'<br />';

foreach($_inputs as $_input) { 
 $_value = $_input->getAttribute('value'); 
 
if (preg_match("/\<embed.*/im", $_value)) {

	
	//$_value = preg_replace('/width=(\"|\')([0-9]+?)(\"|\')/i', 'width="80"', $_value );
	//$_value = preg_replace('/height=(\"|\')([0-9]+?)(\"|\')/i', 'height="60"', $_value );
	array_push ($canArray, $_value);

	//echo '<div style="border:1px solid #000">';
	//echo $_value ;
	//echo '</div>';
	
}

}


/*
lets look at the

URL
_ID
EMBED
- then look for multiple



die();
$pattern ='#value=\"(.*?)\"\s*name=#i';
preg_match_all($pattern, $html, $matches);
print_r($matches);
echo stripslashes($matches[0][0]);
*/







//print_r($_REQUEST);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Admin</title>
	<style type="text/css">
		@import 'default.css';
	</style>	
	<script src="js/prototype.js" type="text/javascript" charset="utf-8"></script>
	
</head>
<body>
<div id="outerWrapper">
<ul >
	<li id="c1">	
	
<div id="topBar" >
	<div style="padding-top:5px">
	<ul>
		<li class="selected"><a href="" >videos</a></li>
		<li><a href="" >songs</a></li>
		<li><a href="" >images</a></li>
	</ul> 
	</div>
</div>	

<div style="padding-top: 10px">

Found: <?= count($canArray) ?> video(s)
<div style="height: 100%; padding-top: 10px">

  <?
   	for ($i=0; $i < count($canArray) ; $i++) { 
   		echo '<div style="border:0px solid #000; text-align: center">';
		echo $canArray[$i] ;
		echo '</div>';
   	}


  ?>
	
	

</div>
</div>

	
	</li>
	<li id="c2">
		<div id="sideBarTop">

			<div style="padding-top: 5px;">post to...</div>
		</div>		

		<div class="postOptions">
			tumblr
		</div>

		<div class="postOptions">
			Word Press
		</div>

		<div class="postOptions">
			twittr
		</div>

<div id="postBox">
	<a href="">POST</a>
</div>		
		
		
	</li>
		
</ul>	
</div>	
</body></html>