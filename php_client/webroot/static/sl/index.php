<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>index</title>

</head>


<body id="index" >
	
<div id="myplayer">the player will be placed here</div>
<script type="text/javascript" src="/static/sl/silverlight.js"></script>
<script type="text/javascript" src="/static/sl/wmvplayer.js"></script>
<script type="text/javascript">
	var elm = document.getElementById("myplayer");
	var src = '/static/sl/wmvplayer.xaml';
	var cfg = {
		file:'http://wmp.olympics.video.msn.com/msftolympics/nbcs/wmp/STAMFORD_Prdxn_Content/BEJ_SWM_TRIALS_M1500M_FINAL_080706-650.wmv?e=1217901610&h=40e59043aab53650131483bb7e6d8274&token=c3RhcnRfdGltZT0yMDA4MDgwNTAxNTAxMCZlbmRfdGltZT0yMDA4MDgwNTAyMDAxMCZkaWdlc3Q9MmE5ZjgyYjhlM2UwMDNiZmE4NDAwNzA5YjUyODBmNmY=',
		image:'preview.jpg',
		width:'790',
		height:'390'
	};
	var ply = new wmvplayer.Player(elm,src,cfg);
</script>
	
</body>
</html>