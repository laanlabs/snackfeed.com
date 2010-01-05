<?


?>


<!-- START SIDEBAR -->
	<div id="sideBar" style="width:290px;height:498px;">


	<div class="top-left"></div><div class="top-right"></div>
	
		<div id="pContent" class="inside" style="height: 240px; width: 400px">
			

	        
					
					<div id="chatSwfHolder" style="width:100%; width: 100%; overflow: hidden; outline:none; border:none;"></div>
					
	        


		</div>
		
	<div class="bottom-left"></div><div class="bottom-right"></div>
	
	</div>

	</div>
	<!-- END SIDEBAR -->
	
	
	
<script type="text/javascript" charset="utf-8">

function startChat()
{
	//console.log("start chat")

	var flashvars = {
		
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
	  id: "chatSwf", 
	  name: "chatSwf"
	};


	var chatSwf = swfobject.embedSWF( "/static/swfs/SimpleChat.swf?room_name=groupwatch",  "chatSwfHolder", "100%", "100%", "9.0.124", "/static/swfs/expressInstall.swf", flashvars, params, attributes);

}


	setTimeout( startChat , 1000)
		
</script>	