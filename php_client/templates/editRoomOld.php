

<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>edit room</title>
	  <script src="/static/js/prototype.js" type="text/javascript"></script>
	<script src="/static/js/scriptaculous.js" type="text/javascript"></script>
	<script src="/static/js/swfobject.js" type="text/javascript" charset="utf-8"></script>

<style>
	


	html,body{
      margin:0px;
      padding:0px;
      height:100%;
      border:none;
 		min-width:600px;   
		overflow: hidden;
		font-family: arial;
		font-size: 12px;
   }
   
	a
	{
		color: #000;
	}

	a:hover
	{
		color: #ff0000;;
	}

	
	img { border:none; padding:0; margin:0; }
    
	#list {
      margin:0;
      margin-top:10px;
      padding:0;
      list-style-type: none;
      width:100%;
    }
    #list li {
      margin:0;
	  background: #fff;
      margin-bottom:4px;
      padding:5px;
      border:1px solid #888;
      cursor:move;
    }

	#col1
	{
		float: left;
		min-width: 200px;
		height: 100%; width: 33%;  background: #666; ; 
	}

	#col2
	{
		float: left;
		height: 100%; width: 34%;  background: #ccc; 
	}

	#col3
	{
		float: left;
		background: #666; 
		height: 100%; width: 33%; ;	
	}
	
	
	ul {
		list-style: none none;
		font-size: 10pt;
		margin: 0;
		padding: 0;
	}

	li {
		border: 1px solid #000000;
		margin: 0.3em;	
		padding: 0.4em;
		background: #ccc;
		display: block;

	}

	li.thumbList
	{
			background: #2cbc2c;
			height: 60px;	
	}


	li.sortable {
		cursor: move;
	 }

	.hoverList {
		background: #bc2c2c;
		cursor: move;
	}

	.img_left
	{
		float: left;
		width: 80px;
		height: 60px;
		margin-right: 3px;
		border: 1px solid #000;
	}
	
	.smallText
	{
		font-size: 9px;
	}


	#showList .btnRemove
	{
		display: none;
	}
	
	#channelList .btnRemove
	{
		display: inline;
	}
	
	#showList .btnAdd
	{
		display: inline;
	}
	
	#channelList .btnAdd
	{
		display: none;
	}
	
	

</style>
</head>
<body>



<div id="col1" style="text-align: left">
	
	<div align="center">
	<div id="playerHolder" style="width: 180px; height: 150px; border: 1px solid red; background: #999; margin: 10px" >
	 <div id="swfHolder" >	preview holder</div>
	</div>
	
	<div style="background: #ccc; color: #fff; height: 28px;">
		<div id="name">
			
			<a href="javascript:SortableLists.killSWF()">stop</a>
			
		</div>
		
	</div>
	
	</div>
	
<div style="padding: 10px">
		DEBG:
		<a href="javascript:SortableLists.loadChannelsList()">load channels</a>
		

		
		<a href="javascript:SortableLists.loadProgramsList()">load programs</a>
		<a href="javascript:SortableLists.showRecorder()">show recorder</a>
		

		
	<a href="logout.php">logout</a>
	
</div>

		<div id="name">
		<form name="user_channels" id="user_channels">	
			<select name="select_channel_id" id="select_channel_id" onchange="reloadChannel()">
		
				<? for ($i = 0 ; $i < count($channel_data) ; $i++){ ?> 	
				<option value="<?= $channel_data[$i]['channel_id'] ?>" ><?= $channel_data[$i]['title'] ?></option>

			<?	} ?>
			
			</select>
		
		<a href="javascript:reloadChannel()">get Channel</a>
		
		</form>	
			
		</div>
	
<div id='programWrapper' style="height:50%;  width: 100%; border: 1px solid #000; ">
	<div style="background: #000; color: #fff; height: 28px;  ">
		<div style="padding: 5px; float: left">
			Channel Shows 
				
		</div>
	</div>
	<ul id='programList' style="height: 100%; width: 100%; overflow-y: scroll; overflow-x: hidden ">
	</ul>
</div>

	
</div>

<div id="col2">
	
	<div style="background: #999; color: #fff; height: 5%;  ">
		<div style="padding: 5px">
			Show Videos
		</div>
	</div>
	<div id='showWrapper' style="height: 95%;  width: 100%; border: 1px solid #000; ">
		<ul id='showList' style="height: 100%; width: 100%; overflow-y: scroll; overflow-x: hidden ">
		</ul>
	</div>

</div>
<div id="col3">
	<div style="background: #000; color: #fff; height: 5%;  ">
		<div style="padding: 5px; float: left">
			Channel Videos 
				
		</div>
		<div style="padding: 5px; float: right">
				<a style="color: #fff" href="javascript:SortableLists.saveChannelsList()">save channel order</a>
		</div>
	</div>
	<div id='channelWrapper' style="height: 95%;  width: 100%; border: 1px solid #000; ">
		<ul id='channelList' style="height: 100%; width: 100%; overflow-y: scroll; overflow-x: hidden ">
		</ul>
	</div>
</div>

<div id="dialogWrapper" style="position:absolute; top:50px; left: 200px; width: 580px; height: 500px; border: 1px solid red; z-index: 100; display: none">
	<div style="width:100%; height: 30px; background: #ccc;">
		<div style="padding-top: 5px; padding-right: 10px; float: right">
			<a href="javascript:SortableLists.closeRecorder();">close</a>
			
		</div>
		
	</div>
	<div id="recoderSwfHolder" style="width:580px; height:470px;">
		
	</div> 

</div>


	<div id="feedback">...</div>

	<script type="text/javascript">

	var SortableLists = {
	
		channel_id : '<?= $_channel_id ?>',
		user_id : '<?= $_user_id ?>',
		playerSwf : null,
		recorderSwf: null,
		flvPlayer: '/static/swfs/simplePlayer.swf',
		BASE_URL: '',
		
		
		loadProgramsList: function()
		{
			var ajax_uri = SortableLists.BASE_URL + '/channels/get_programs?&json&channel_id=' + SortableLists.channel_id
			//console.log('here this: ' + ajax_uri)

			new Ajax.Request(ajax_uri, { method:'get',
				onSuccess: function(transport){
			    	var json = transport.responseText.evalJSON();
			  		//console.log(json)

					var name = 'programList';
					//console.log(list)
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'program', 'class': 'sortable' };

					for ( var t=0; t < json.programs.length; t++ ) 
					{
						//console.log( json.videos[t].title )
						var text = json.programs[t].title;
						//console.log(id);
						attrs.id = 'program_' + json.programs[t].show_id;
						
						
						var listClick = "javascript:SortableLists.loadShowList('" + json.programs[t].show_id + "' )";
						var updateClick = '';
						
							var result_div = Builder.node('li', attrs, [
								Builder.node('text', {'class': ''}, '' + text.truncate(80) + ' - '),
								Builder.node('a', {id: 'add_' + json.programs[t].show_id, href: listClick, 'class': ''  }, 'list '),
								Builder.node('a', {id: 'add_' + json.programs[t].show_id , href: updateClick, 'class': '' }, '')
							  ]);
						
						
						container.insert({ bottom: result_div });
					}

					SortableLists.createSortables('programList');

				}

			  });
		},
		
		
		loadShowList: function(show_id)
		{
	
	
			var ajax_uri = SortableLists.BASE_URL + '/channels/get_show_videos?&json&show_id=' + show_id + '&channel_id=' + SortableLists.channel_id
			//console.log('here: ' + ajax_uri)

			new Ajax.Request(ajax_uri, { method:'get',
				onSuccess: function(transport){
			    	var json = transport.responseText.evalJSON();
			  		//console.log(json)

					var name = 'showList';
					//console.log(list)
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'shows', 'class': 'draggable' };
					
					
				

					for ( var t=0; t < json.videos.length; t++ ) 
					{
	

						//use template function to create element
						var result_div = SortableLists.makeLIE( json.videos[t], 'show');
						container.insert({ bottom: result_div });
					}

					
				}

			  });	
	
		},
		
		makeLIE: function(data, type)
		{
			var attrs = { id: 'shows', 'class': 'thumbList' };
					
			var text = data.detail;
			attrs.id = 'video_' + data.video_id;
			
			var addClick  = "javascript:SortableLists.addVideoToChannel('" + data.video_id + "' )";
			var removeClick  = "javascript:SortableLists.removeVideoFromChannel('" + data.video_id + "' )";

			
			var playClick = "javascript:SortableLists.playVideo('" + data.video_id + "' )";

			var result_div = Builder.node('li', attrs, [
				Builder.node('img', { src: data.thumb, 'class': 'img_left'}),
			    Builder.node('div', {'class': 'heading'}, [
			      Builder.node('a', {href: playClick }, data.title.truncate(45))
			    ]),
			    Builder.node('text', data.date_pub),
				Builder.node('text', {'class': 'smallText'}, ' - ' + text.truncate(80) ),
				Builder.node('a', {id: 'add_' + data.video_id , href: addClick, 'class': 'btnAdd'  }, 'add'),
				Builder.node('a', {id: 'add_' + data.video_id , href: removeClick, 'class': 'btnRemove' }, 'remove')
			  ]);
							
								
			return result_div;
			
		},


		removeVideoFromChannel: function(video_id)
		{
			
				var ajax_uri = SortableLists.BASE_URL + '/channels/remove_video?&nosegments&user_id=&json&channel_id=' + SortableLists.channel_id + '&video_id=' + video_id
				//console.log('here: ' + ajax_uri)

				new Ajax.Request(ajax_uri, { method:'get',
					onSuccess: function(transport){
				    		SortableLists.loadChannelsList();
					}

				  });
			
			
			
			
			
		},

		addVideoToChannel: function(video_id)
		{
		
			
			var container = $('channelList');
			var result_div = $('video_' + video_id)
			result_div.onclick = '';
					
			container.insert({ top: result_div });
			
			//make all sortable
			SortableLists.createSortables('channelList');
			
			
		},

		
		saveChannelsList: function()
		{
		
			poststring = 'channel_id=' + SortableLists.channel_id + '&';
			poststring += Sortable.serialize('channelList');
			
			//console.log(poststring)
			
			new Ajax.Request("/channels/save_order_by", {  
			             method: "post",  
			             parameters: { data: poststring }  
			         })
			
			
			
		},






		loadChannelsList: function(){
			
			
			var ajax_uri =  SortableLists.BASE_URL + '/channels/get_details_and_videos_for?&nosegments&user_id=&json&channel_id=' + SortableLists.channel_id
			//console.log('here: ' + ajax_uri)

			new Ajax.Request(ajax_uri, { method:'get',
				onSuccess: function(transport){
			    	var json = transport.responseText.evalJSON();

					var name = 'channelList';
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'video_', 'class': 'sortable' };

					for ( var t=0; t < json.videos.length; t++ ) 
					{
						var result_div = SortableLists.makeLIE( json.videos[t], 'video');
						container.insert({ bottom: result_div });
					}

					SortableLists.createSortables('channelList');

				}

			  });
			
			
		},


		createSortables: function (name) {

			Position.includeScrollOffsets = true
				Sortable.create(name,
					{
						ghosting: false,
						hoverclass: 'hoverList'
					});
		
		},
		
		
		
		playVideo:function( video_id )
		{
			SortableLists.killSWF();
			
			_swfContent = SortableLists.flvPlayer + "?id=" + video_id

			var flashvars = {
				//url: _url,
				stage_width: 180,
				stage_height: 150
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
			  id: "flashVideoPlayer", 
			  name: "flashVideoPlayer"
			};

		//console.log(_swfContent)
			SortableLists.playerSwf = swfobject.embedSWF( _swfContent ,  "swfHolder", "180", "150", "9.0.0", "/images/swf/expressInstall.swf", flashvars, params, attributes);



		},
		
		
		killSWF:function()
		{
			var d = document.getElementById('playerHolder');
			//var olddiv = document.getElementById("swfHolder");
			d.innerHTML = "";
			var ix = document.createElement('div');
			ix.id = "swfHolder"
			ix.innerHTML = "loading..."
			d.appendChild(ix);

		},
		
		showRecorder:function()
		{
			$('dialogWrapper').show();
			
				_swfContent = "/static/swfs/ChannelRecorder.swf?user_id=<?= $_user_id ?>"

				var flashvars = {
					user_id: '<?= $_user_id ?>',
					stage_width: 580,
					stage_height: 470
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
				  id: "flashVideoRecorder", 
				  name: "flashVideoRecorder"
				};

			//console.log(_swfContent)
				SortableLists.recorderSwf = swfobject.embedSWF( _swfContent ,  "recoderSwfHolder", "580", "470", "9.0.0", "/images/swf/expressInstall.swf", flashvars, params, attributes);
			
			

		},
		
		closeRecorder: function()
		{
			$('dialogWrapper').hide();	
		}
		
	};

	document.observe("dom:loaded", loadList);



	function loadList(event)
	{


		SortableLists.loadChannelsList();
		SortableLists.loadProgramsList();		
	}
	

	function reloadChannel()
	{
		
		var c_id = $('select_channel_id').value
		SortableLists.channel_id = c_id ;
		
		
		$('showList').update('');
		SortableLists.loadChannelsList();
		SortableLists.loadProgramsList();
		
	}

	</script>


</body>
</html>