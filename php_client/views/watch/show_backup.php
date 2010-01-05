<script type="text/javascript" src="/feed/js/swfobject.js"></script>



<div id="playerWrapper" style="width: 800px;">

<div id="playerHolder" style="width: 100%; background-color: #000000; text-align: center">
<div id="swfHolder" ></div>
</div>
<div id="showInfo" style="float:left; width:260px; padding-top:30px; padding-left:10px; border: 1px solid red">
	
	<img src="<?= $show['meta']['thumb'] ?>" style=""><br/>
	<?= $show['meta']['title'] ?><?= $show['meta']['detail'] ?><br/>
	<a href="javascript:playMove(-1);">prev</a>
	<a href="javascript:playMove(1);">next</a>
	
</div>
<div id="showInfo" style="float:left; width:300px; border: 1px solid red">

<ul>
<?
$urlArray = array();
for ($i=0; $i < count($show['videos']) ; $i++) { 
	$urlArray[$i] = trim($show['videos'][$i]['url_source']);
?>

	<li>
		<a href="javascript: doPlay(<?= $i ?>)"><?=$show['videos'][$i]['title']?></a>
		<span id="playingIcon_<?= $i ?>" style="display:none; color:red">playing...</a>
	</li>

<?
}



?>		
</ul>
</div>

</div>

<? if ($show['videos'][0]['use_embedded'] == 1)
{
	$_flash_content = $show['videos'][0]['url_source'];
	
	
} else {
	$_flash_content = "/images/swf/simplePlayer.swf";
	
	
}

?>

<a href="javascript:killSWF()">kill</a>

<script>

	function killSWF()
	{
		obj = swfobject.getObjectById("flashVideoPlayer");
		//obj.innerHTML = "";
	  	var d = document.getElementById('playerHolder');
	  	var olddiv = document.getElementById("swfHolder");
		d.innerHTML = "";
	
		var ix = document.createElement('div');
		ix.id = "swfHolder"
		d.appendChild(ix);
		placePlayer()
	
	//  d.removeChild(olddiv);
		
	}
	
	

	var currentIndex = 0;
	var arrayVideos=new Array(<?= "'" . implode("','" , $urlArray) . "'" ?>);
	var lastIndex = 0;
	
	function doPlay(index)
	{
		currentIndex = index;
		playVideo();
	}
	
	
	function playMove(vDir)
	{
		
		tCount = currentIndex + vDir;
		if ((tCount >= 0) && (tCount < arrayVideos.length))
		{
			currentIndex += vDir;
			playVideo();
		}
	}
	
	
	function playVideo()
	{
	
	
		v = document.getElementById("playingIcon_" + lastIndex);
		v.style.display = 'none';
	
		v = document.getElementById("playingIcon_" + currentIndex);
		v.style.display = '';
	
		lastIndex = currentIndex;
	
		var obj = swfobject.getObjectById("flashVideoPlayer");
		if (obj) {
		  obj.flashPlayCall(arrayVideos[currentIndex]);
		}
		
	}

	
	function videoPlayStart()
	{
		//alert('from falsh');
		
	}

	function videoPlayComplete()
	{
		//alert('play complete');
		playMove(1);
	}
	
	
	function placePlayer()
	{
	var flashvars = {
	  url: arrayVideos[currentIndex]
	};
	var params = {
	  	menu: "false",
		allowFullScreen: "true",
		allowscriptaccess : "always"
		
	};
	var attributes = {
	  id: "flashVideoPlayer", 
	  name: "flashVideoPlayer"
	};
	
	
	var vSWF = swfobject.embedSWF("<?= $_flash_content ?>", "swfHolder", "790", "370", "9.0.0", "/images/swf/expressInstall.swf", flashvars, params, attributes);
	}
	
	
	placePlayer();
	vTimeout=window.setTimeout ("doPlay(0)", 1000);

	
</script>


