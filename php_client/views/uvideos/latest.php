<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>latest</title>
	<script src="/static/js/prototype.js" type="text/javascript" charset="utf-8"></script>
	<script src="/static/js/swfobject.js" type="text/javascript" charset="utf-8"></script>
	<style type="text/css" media="screen">
		body
		{
			padding: 0px;
			margin:0px;
			background: #000;
			font-family: arial;
		}
		#wrapper
		{
			position: relative;
			width: 160px;
			height: 120px;
			border: 1px solid #ffffff;
		}
		
		#thumbHolder
		{

		}
		
		#playOverlay
		{
			position: absolute;
			top: 32px;
			left: 46px;
			
		}
		
		#playOverlay img
		{
			opacity:.80;
			filter: alpha(opacity=80); 
			-moz-opacity: 0.8
		}
		
		
		#playOverlay img:hover
		{
			opacity:1.00;
			filter: alpha(opacity=100); 
			-moz-opacity: 1.0;
		}
		
	</style>
</head>
<body id="latest" >
	<div id="wrapper">
		

	<div id="thumbHolder">
	<a href="javascript:playVid()">
	<image src="<?= $rows[0]['thumb']?>" style="border:0px" />
		<div id="playOverlay">
			<image src="/static/images/play_overlay.png" style="border:0px" />
		</div>
	</a>	
	</div>
	<div style="color: #666; font-size: 12px; padding: 5px">
	<? if (!empty($rows[0]['title']))
	{
		echo $rows[0]['title'] . "<br/>";
	}
		
	?>

	<span style="font-size: 10px"><?= date("M-d H:i", strtotime($rows[0]['date_created'])) ?></span>
	</div>


	</div>
	
	
<script type="text/javascript" charset="utf-8">
	
	function playVid()
	{
		var flashvars = {

			stage_width: 160,
			stage_height: 120

		};

		var params = {

			menu: "false",
			allowFullScreen: "true",
			allowscriptaccess : "always",
			bgcolor: "#000000",
			scale : "noorder" , 
			salign: "t"
		};

		var attributes = {
		  id: "thumbHolder", 
		  name: "thumbHolder"
		};


		var chatSwf = swfobject.embedSWF( "/static/swfs/SimpleFlvPlayer.swf?video_url=/static/flvs/<?= $rows[0]['uvideo_id']?>.flv" ,  "thumbHolder", "160", "120", "9.0.0", "/images/swf/expressInstall.swf", flashvars, params, attributes);
	}
	
</script>	
	
</body>
</html>