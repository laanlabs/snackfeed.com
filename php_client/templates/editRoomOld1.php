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
		color: #005500;;
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
	
	#headerDiv {
		
		padding: 0px 0px 8px 4px;
		clear: right;
		height: 40px;
		background: #fff;
		border-bottom: 8px solid #ffffff;
		
	}
	
	#columnWrapper {
		
		min-width: 1000px;
		height: 100%; width: 100%;
		
	}
	
	#col1
	{
		float: left;
		min-width: 200px;
		height: 100%; width: 20%;
		background: #fff;
	}

	#col2
	{
		float: left;
		height: 100%;
		width: 48%;
		background: #aaa; 
		padding: 5px;
	}

	#col3
	{
		float: left;
		background: #fff; 
		padding-left: 8px;
		height: 100%;
		width: 30%;
		
	}
	
	
	.sideTab {
		
		background: #fff;
		color: #000;
		height: 28px;
		font-size: 22px;
		margin-top: 5px;
		margin-bottom:5px;
		margin-left: 25px;
		border-left: 1px solid #aaa;
		border-top: 1px solid #aaa;
		border-bottom: 1px solid #aaa;
		
	}
	
	.sideTab a {
		outline: none;
		border: none;
	}
	
	.sideTab.selected {
		
		background: #aaa;
		border: 0px;
		color: #fff;
	}
	
	
	a.selected {
		background: #fff;
		color: #000;
	}
	
	
	ul {
		list-style: none none;
		font-size: 10pt;
		margin: 0;
		padding: 0;
	}

	li {
		border: 0px solid #000000;
		margin: 0.3em;	
		padding: 0.4em;
		background: #ccc;
		display: block;

	}

	li.thumbList
	{
			/*background: #2cbc2c;*/
			background: #ffffff;
			height: 60px;	
	}


	li.sortable {
		cursor: move;
	 }

	.hoverList {
		background: #eee;
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
	
	#channelList {
		
		background: #0066aa;
	}
	
	#channelList li {
		cursor:move;
	}
	
	#searchResultsDiv .btnRemove {
		display: none;
	}
	

</style>
</head>
<body>


<div id="headerDiv">
	
	
	
<div style="float: left; font-size: 18px; ">
<?= $current_channel['title'] ?> Editor 
</div>

<div id="busyDiv" style="display:none; float: left; padding-left: 50px; overflow: visible; height: 1px; width:1px;">
	<img src="/static/images/v2/spinner.gif"></img>
</div>

<div style="float:right; padding: 4px; background: #cccccc;">
	<div>
	Edit other channels: 
	<? for ($i = 0 ; $i < count($channel_data) ; $i++){ ?> 	
	
	<a href="/users/editRoom/<?= $channel_data[$i]['channel_id'] ?>" >
		<?= $channel_data[$i]['title'] ?>
	</a>  - 

	<?	} ?>
	</div>
	
</div>

<div style="float:right; padding: 0px 30px; 4px; 1px;">
	<a href="logout.php">logout</a>
</div>

<div style="clear: left; padding-top: 5px;">
	<a href="/">Back to Snackfeed.com</a>
	
</div>

</div>


<div id="columnWrapper">
	
<!-- Tab column and also has the preview player  -->
<div id="col1" style="text-align: left">
	
	<!--
	<div id='programWrapper' style="height:100%;  width: 100%; border: 1px solid #000; ">
	
		<div style="background: #000; color: #fff; height: 28px;  ">
			<div style="padding: 5px; float: left">
				Channel Shows 		
			</div>
		</div>
	
		<ul id='programList' style="height: 100%; width: 100%; overflow-y: scroll; overflow-x: hidden ">
		</ul>
	
	</div>
-->
	
	<div style="height:300px; padding-top: 10px; width: 100%; ">
	
		
		<div id="searchTab" class="sideTab <?= $_section == "search" ? "selected" : "" ?>" style="padding: 5px;">
			<a href="javascript:editingRoom.showSearch()">Search Videos</a>
		</div>
		
		
		<div id="libraryTab" class="sideTab <?= $_section == "library" ? "selected" : "" ?>" style="padding: 5px;">
			<a href="javascript:editingRoom.showLibrary()">My Video Library</a>
		</div>
		
		<div id="showsTab" class="sideTab <?= $_section == "shows" ? "selected" : "" ?>" style="padding: 5px;">
			<a href="javascript:editingRoom.showShows()">My Shows</a>
		</div>
		
		<div id="recordTab" class="sideTab <?= $_section == "record" ? "selected" : "" ?>" style="padding: 5px;">
			<a href="javascript:editingRoom.showRecord()" >Record A Video!</a>
		</div>
		
		<div id="settingsTab" class="sideTab <?= $_section == "settings" ? "selected" : "" ?>" style="padding: 5px;">
			<a href="javascript:editingRoom.showSettings()">Channel Settings</a>
		</div>
		

	
	</div>

	
	<div align="center" style="width: 100%;" >
	 Video Preview: 
	
		<div id="playerHolder" style="width: 180px; height: 150px; border: 1px solid red; background: #999; margin: 5px" >
			<div id="swfHolder" >
				
			</div>
		</div>

		<div style="background: #ccc; color: #fff; height: 18px;">
			
			<div id="name">	
				<a href="javascript:SortableLists.killSWF()" style="padding-right: 15px">stop</a>
				
				<a id="addWhatsPlayingButton" style="padding: 3px; display: none; color: #883300; font-size: 13px;" href="javascript: editingRoom.addCurrentlyPlayingVideo();">+ Add this video to channel</a>
				
			</div>
			
		</div>

	</div>

	
</div>







<!-- MIDDLE COLUMN ( TAB Contents )-->
<div id="col2">
	
	
	<!-- Search Tab Contents -->
	<div id='searchTabContent' style="display:<?= $_section == "search" ? "" : "none" ?>; height: 100%;  width: 100%;">
		
		
		
			<div id="searchSelectorDiv" style="padding: 5px; font-size: 19px;">Find Videos at: &nbsp;&nbsp;
					<a id="normalSearchButton" class="selected" href="javascript:editingRoom.setSearchType('normal');">snackfeed.com</a> | 
					<a id="ytSearchButton" href="javascript:editingRoom.setSearchType('yt');">youtube.com</a>
			</div>

		<div id="search" style="">
			
			<form id="searchForm" method="get" action="" name="searchForm">
				
				<div id="searchEntry">
					<input id="searchBox" type="search" style="width: 200px;" onkeydown="javascript:editingRoom.onSearchKey(event);" results="10" placeholder="Enter your query" name="q" value="" />
					
					<a onclick="javascript:editingRoom.onSubmit(event);" >Search</a>
					
				</div>
					
				<!-- <div id="searchButton">
								<input type="submit" value="Search" onclick="javascript:editingRoom.onSubmit();" >
							</div> -->

				<!-- <div id="searchOptionsCtrl" style="padding-left: 20px; padding-top: 10px; text-align: left">
									<a href="">Advanced Options</a>
								</div> -->
								
			</form>
			
			<a id="previousPageButton" href="javascript:SortableLists.getPage(-1);" style="display:none;">previous</a>
			<a id="nextPageButton" href="javascript:SortableLists.getPage(1);" style="display:none;">next</a>
			
			<div id="resultsInfoDiv">
			
			</div>
			
			</div>
			
			<ul id="searchResultsDiv" style="height: 75%; overflow-y: scroll; overflow-x: hidden " >
				
			</ul>
			
	</div>
	
	
	
	
	<!--  Shows you are following, and the videos in those shows -->
	<div id='showsTabContent' style="display:<?= $_section == "shows" ? "" : "none" ?>;  ">
		
		
			<div id='programWrapper' style="height: 90%; overflow-y: scroll; overflow-x: hidden" >
				
				Your Shows you are tracking: <a href="/shows" style="padding-left: 40px;"> + Add a show</a>
				<ul id='programList' >
				</ul>
				
			</div>

			<div id='showWrapper' style="display:none;">
				
				<a href="javascript:SortableLists.loadProgramsList()" style="font-size: 16px; color: #002299; ">&lt;Back</a> 
				<br/>
				Shows in this program:
				
				<div style="height: 83%; overflow-y: scroll; overflow-x: hidden;">
					<ul id='showList' >
					</ul>
				</div>
				
			</div>
	
		
	</div>
	
	
	<!-- Webcam recorder -->
	<div id='recordTabContent' style="display:<?= $_section == "record" ? "" : "none" ?>; height: 100%;  width: 100%;">
		
		<div id="recorderSwfHolder" style="width:580px; height:470px;">
			<img src="/static/images/v2/spinner.gif"></img>
		</div>
		
	</div>
	
	<div id='libraryTabContent' style="display:<?= $_section == "search" ? "" : "none" ?>; height: 90%;  width: 100%; ">
		
		<h1>Video Library</h1>
		
		This feature has not been implemented yet, for now just search for videos to add them directly into a channel.
		
	</div>
	
	<div id='settingsTabContent' style="display:<?= $_section == "settings" ? "" : "none" ?>; height: 90%;  width: 100%;">
		Settings <br/>
		There are no settings right now. check back later.
	</div>
	
	
	
</div>



<!-- COLUMN 3 ( Channel Playlist ) -->
<div id="col3">
	

	<div style="background: #fff; color: #fff; padding-left: 3px;">
		
		<div style="background: #0066aa; float: left;  margin: 5px 0px 0px 15px; padding: 5px; font-size: 18px;">
			
			<span id="channelPlaylistTitle" >Channel Playlist </span>
			
			
			<span style="padding-left: 25px; font-size: 13px; ">
					<a style="color: #fff" href="javascript:SortableLists.saveChannelsList()">save changes</a>
			</span>
			
		</div>
		
		
		
	</div>

	
	<div id='channelWrapper' style="clear: left;" >
		
		<ul id='channelList' style="height: 80%; width: 100%; overflow-y: scroll; overflow-x: hidden" >
		</ul>
		
	</div>
	
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
	
	
	var editingRoom = {
		
		showBusy : function() {
			$("busyDiv").show();
		},
		
		hideBusy : function() {
			$("busyDiv").hide();
		},
		
		
		showRecord : function () {
			
			editingRoom.hideAll();
			$('recordTabContent').show();
			$('recordTab').addClassName("selected");
			
			SortableLists.showRecorder();
			
		},
		
		showSettings : function () {
			
			editingRoom.hideAll();
			$('settingsTabContent').show();
			$('settingsTab').addClassName("selected");
		},
		
		showShows : function () {
			
			editingRoom.hideAll();
			$('showsTabContent').show();
			$('showsTab').addClassName("selected");
		},
		
		showSearch : function () {
			
			editingRoom.hideAll();
			$('searchTabContent').show();
			$('searchTab').addClassName("selected");
		},
		
		showLibrary : function () {
			
			
			
			editingRoom.hideAll();
			$('libraryTabContent').show();
			$('libraryTab').addClassName("selected");
			
			// get user favorites?
			
		},
		
		
		hideAll : function () {
			
			$('searchTabContent').hide();
			$('showsTabContent').hide();
			$('settingsTabContent').hide();
			$('recordTabContent').hide();
			$('libraryTabContent').hide();
			
			$('searchTab').removeClassName("selected");
			$('showsTab').removeClassName("selected");
			$('settingsTab').removeClassName("selected");
			$('recordTab').removeClassName("selected");
			$('libraryTab').removeClassName("selected");
			
		},
		
		onSubmit : function( event ) {
			
			
			
			
			//event.preventDefault();
			if ( event ) {
				
				Event.extend(event);
				event.preventDefault();
				event.stopPropagation();
				event.stopped = true; 
			}
			
			SortableLists.performSearch();
				
			return false;
				
		},
		
		setSearchType : function ( type ) {
			
			SortableLists.currentPage = 0;
			
			if ( type== "normal") {
				
				$('normalSearchButton').addClassName('selected');
				$('ytSearchButton').removeClassName('selected');
				SortableLists.searchType = "normal";
				
			} else {
				
				$('normalSearchButton').removeClassName('selected');
				$('ytSearchButton').addClassName('selected');
				SortableLists.searchType = "yt";
				
			}
			
			if ( $("searchBox").value != "" ) {
				
				SortableLists.performSearch();
				
			}
			
		},
		
		onSearchKey : function ( event ) {
			
		//	console.log( "yio" +  event.keyCode );
			
			if ( event.keyCode == 13 ) {
				
				
				Event.extend(event);
				event.preventDefault();
				event.stopPropagation();
				event.stopped = true; 
				
				
				SortableLists.performSearch();
				
				
				
				
			}
			
		},
		
		addCurrentlyPlayingVideo : function () {
			
			
			// addWhatsPlayingButton
			
			if ( SortableLists.currentVideoId == null ) return;
			
			SortableLists.addVideoToChannel( SortableLists.currentVideoId , SortableLists.currentVideoType )
			
			
		},
		
		channelChanged : function() {
			
			$("channelPlaylistTitle").update("* Channel Playlist")
			new Effect.Highlight( "channelPlaylistTitle" , { startcolor: '#ffffff', endcolor: '#0066aa' });
			
		}
		
	}
	
	var SortableLists = {
	
		//channel_id : '<?= $_channel_id ?>',
		channel_id : '<?= $current_channel["channel_id"] ?>',
		currentVideoId : null,
		currentVideoType : null,
		searchType: "normal",
		user_id : '<?= $_user_id ?>',
		currentPage : 0,
		itemsPerPage : 15 ,
		playerSwf : null,
		recorderSwf: null,
		flvPlayer: '/static/swfs/simplePlayer.swf',
		BASE_URL: '',
		
		
		
		performSearch: function( searchTerm , page )
		{
			
			searchTerm = $("searchBox").value;
			var pageText = "&o="+(SortableLists.currentPage*SortableLists.itemsPerPage);
			
			if ( SortableLists.searchType == "normal" ) {
			
				var ajax_uri = SortableLists.BASE_URL + '/search?json&q=' + searchTerm + pageText; 
			
			} else if ( SortableLists.searchType == "yt" ){
			
				var ajax_uri = SortableLists.BASE_URL + '/search/youtube?json&q=' + searchTerm + pageText;
			
			}
			
			
			//console.log('here this: ' + ajax_uri)
			editingRoom.showBusy();
			
			new Ajax.Request(ajax_uri, { method:'get',
				
				onSuccess: function(transport){
					
					var json = transport.responseText.evalJSON();
					
					
					editingRoom.hideBusy();
					
					var name = 'searchResultsDiv';
					var container = $(name);
					container.innerHTML = ''
					//var attrs = { id: 'program', 'class': 'sortable' };
					
					
					var attrs = { id: 'shows', 'class': 'draggable' };
					
					SortableLists.totalResults = json.total;
					
					if ( json.videos.length == 0 ) {
						
						var no_results = Builder.node('div', null , 
						[
							Builder.node('text', null, "There were no results")
						]);
						
						container.insert({ bottom: no_results });
					}
					
					for ( var t=0; t < json.videos.length; t++ ) 
					{
						
						//use template function to create element
						var result_div = SortableLists.makeLIE( json.videos[t],  SortableLists.searchType );
						container.insert({ bottom: result_div });
					}
					
					//SortableLists.createSortables('programList');
					SortableLists.renderPaginator();
				}
				
			  });
		},
		
		getPage : function ( dir ) {
			
			SortableLists.currentPage = Math.max( 0 , SortableLists.currentPage + parseInt(dir) );
			SortableLists.performSearch();
			
		},
		
		renderPaginator : function () {
			
			
			$("resultsInfoDiv").update("Showing " + (SortableLists.currentPage*SortableLists.itemsPerPage+1) + " - " + ((SortableLists.currentPage+1)*SortableLists.itemsPerPage)  + " of " + SortableLists.totalResults )
			
			if ( SortableLists.currentPage > 0 ) 
			$("previousPageButton").show();
			else
			$("previousPageButton").hide();
			
			if ( SortableLists.totalResults > ((SortableLists.currentPage+1)*SortableLists.itemsPerPage) )
			$("nextPageButton").show();
			else
			$("nextPageButton").hide();
			
		},
		
		loadProgramsList: function()
		{
			
			$('programWrapper').show();
			$('showWrapper').hide();
			
			var ajax_uri = SortableLists.BASE_URL + '/channels/get_programs?&json&channel_id=' + SortableLists.channel_id
			//console.log('here this: ' + ajax_uri)
			
			editingRoom.showBusy();
			
			new Ajax.Request(ajax_uri, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					//console.log(json)
					editingRoom.hideBusy();
					
					var name = 'programList';
					//console.log(list)
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'program', 'class': 'sortable' };
					
					
					if ( json.programs.length == 0 ) {
						
						var no_results = Builder.node('div', null , 
						[
							Builder.node('text', null, "You don't have any shows you're following, use the site to find some shows.")
						]);
						
						container.insert({ bottom: no_results });
					}
					
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
			
			$('programWrapper').hide();
			$('showWrapper').show();
			
			
			var ajax_uri = SortableLists.BASE_URL + '/channels/get_show_videos?&json&show_id=' + show_id + '&channel_id=' + SortableLists.channel_id
			//console.log('here: ' + ajax_uri)
			
			editingRoom.showBusy();
			
			new Ajax.Request(ajax_uri, { method:'get',
			
				onSuccess: function(transport){
			    	var json = transport.responseText.evalJSON();
			  		//console.log(json)
			
					editingRoom.hideBusy();
					
					var name = 'showList';
					//console.log(list)
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'shows', 'class': 'draggable' };
					
					if ( json.videos.length == 0 ) {
						
						var no_results = Builder.node('div', null , 
						[
							Builder.node('text', null, "There are no videos in this show.")
						]);
						
						container.insert({ bottom: no_results });
					}
					
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
			
			var extra = ""
			if ( type ) extra = ",'"+type+"'";
			
			
			var addClick  = "javascript:SortableLists.addVideoToChannel('" + data.video_id + "' "+extra+" )";
			var removeClick  = "javascript:SortableLists.removeVideoFromChannel('" + data.video_id + "' "+extra+" )";
			
			var playClick = "javascript:SortableLists.playVideo('" + data.video_id + "' "+extra+" )";
			
			
			var result_div = Builder.node('li', attrs, [
			
				Builder.node('a', {href: playClick }, Builder.node('img', { src: data.thumb, 'class': 'img_left'}) ),
			   Builder.node('div', {'class': 'heading'}, [
			   Builder.node('a', {href: playClick }, "_" + data.title.truncate(45))
			  ]),
			    Builder.node('text', data.date_pub),
				Builder.node('text', {'class': 'smallText'}, ' - ' + text.truncate(80) ),
				
				Builder.node('a', {id: 'add_' + data.video_id , href: addClick, 'class': 'btnAdd'  }, 'add'),
				
				Builder.node('a', {id: 'remove_' + data.video_id , href: removeClick, 'class': 'btnRemove' }, 'remove')
				
			  ]);
							
								
			return result_div;
			
		},


		removeVideoFromChannel: function(video_id)
		{
			
				var ajax_uri = SortableLists.BASE_URL + '/channels/remove_video?&nosegments&user_id=&json&channel_id=' + SortableLists.channel_id + '&video_id=' + video_id
				//console.log('here: ' + ajax_uri)
				editingRoom.showBusy();
				
				new Ajax.Request(ajax_uri, { method:'get',
				
					onSuccess: function(transport){
				    		SortableLists.loadChannelsList();
							editingRoom.hideBusy();
					}

				  });
			
			
			
			
			
		},
		
		addVideoToChannel: function( video_id  , type )
		{
		
			editingRoom.channelChanged();
			
			var container = $('channelList');
			var result_div = $('video_' + video_id)
			result_div.onclick = '';
					
			container.insert({ top: result_div });
			
			//make all sortable
			SortableLists.createSortables('channelList');
			
			
			if ( type == "yt" ) {
				
				"/videos/add_to_channel/Vkmhlge1jGU?channel_id=f45484f4-7ed9-102b-908a-00304897c9c6&t=yt&ext=1";
				
				editingRoom.showBusy();
				
				new Ajax.Request("/videos/add_to_channel/"+video_id+"?channel_id="+SortableLists.channel_id+"&t=yt&ext=1", {  
							
							method: "get",  
							
							onSuccess: function(transport){
								editingRoom.hideBusy();
								
								SortableLists.loadChannelsList();
							}
							
						})
						
						
			}
			
			
			
		},
		
		saveChannelsList: function()
		{
			
			poststring = 'channel_id=' + SortableLists.channel_id + '&';
			poststring += Sortable.serialize('channelList');
			
			//console.log(poststring)
			editingRoom.showBusy();
			
			new Ajax.Request("/channels/save_order_by", {  
						method: "post",  
						parameters: { data: poststring },
						
						onSuccess: function(transport){
							
							editingRoom.hideBusy();
							$("channelPlaylistTitle").update("Channel Playlist");
							
						}
						
					})
					
				
				
		},
		
		
		
		loadChannelsList: function()  {
			
			
			var ajax_uri =  SortableLists.BASE_URL + '/channels/get_details_and_videos_for?&nosegments&user_id=&json&channel_id=' + SortableLists.channel_id
			//console.log('here: ' + ajax_uri)
			
			editingRoom.showBusy();
			
			new Ajax.Request(ajax_uri, { method:'get',
			
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					editingRoom.hideBusy();
					var name = 'channelList';
					var container = $(name);
					container.innerHTML = ''
					var attrs = { id: 'video_', 'class': 'sortable' };
					
					if ( json.videos.length == 0 ) {
						
						var no_results = Builder.node('div', null , 
						[
							Builder.node('div', { "style" : "font-size: 14px; "}, "There are no videos in your channel! "),
							Builder.node('text', null, "To get started adding some videos, try searching for something you like, then click 'add' to put it in your channel. "),
						]);
						
						container.insert({ bottom: no_results });
					}
					
					for ( var t=0; t < json.videos.length; t++ ) 
					{
						var result_div = SortableLists.makeLIE( json.videos[t], 'video');
						container.insert({ bottom: result_div });
					}
					
					SortableLists.createSortables('channelList');
					
				}
				
			  });
			
			
		},
		
		onReArrange : function ( ) {
		
			editingRoom.channelChanged();
			
		},
		
		createSortables: function (name) {
			
			Position.includeScrollOffsets = true
				Sortable.create(name,
					{
						onUpdate: function () { SortableLists.onReArrange() } , 
						ghosting: false,
						hoverclass: 'hoverList'
					});
		
		},
		
		
		
		
		
		playVideo:function( video_id , type )
		{
			
			$('addWhatsPlayingButton').show();
			SortableLists.currentVideoType = type;
			SortableLists.currentVideoId = video_id;
			
			SortableLists.killSWF();
			
			if ( type == "yt") {
				
				// &enablejsapi=1&playerapiid=ytplayer
				_swfContent = "http://www.youtube.com/v/" + video_id + "&autoplay=1";//"&enablejsapi=1&playerapiid=ytplayer"
				
			}
			else
			_swfContent = SortableLists.flvPlayer + "?id=" + video_id
			
			var flashvars = {
				//url: _url,
				//stage_width: 180,
				//stage_height: 150
			};
			
			var params = {
				
				menu: "false",
				allowFullScreen: "true",
				allowScriptAccess : "always",
				bgcolor: "#000000"
				
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
			//$('dialogWrapper').show();
				
				
				$("recorderSwfHolder").innerHTML = '<img src="/static/images/v2/spinner.gif"></img>';
				
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
					bgcolor: "#ffffff",
					scale : "noorder" , 
					salign: "t"
					
				};
				
				var attributes = {
				  id: "flashVideoRecorder", 
				  name: "flashVideoRecorder"
				};
				
				
			//console.log(_swfContent)
				SortableLists.recorderSwf = swfobject.embedSWF( _swfContent ,  "recorderSwfHolder", "580", "470", "9.0.0", "/images/swf/expressInstall.swf", flashvars, params, attributes);
			
			
		},
		
		closeRecorder: function()
		{
			//$('dialogWrapper').hide();	
		}
		
	};

	document.observe("dom:loaded", loadList);



	function loadList(event)
	{
		//alert("tyo " )
		//SortableLists.channel_id = "<?= $current_channel['channel_id'] ?>";
		
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
	
	
	/// this is for the youtube player so we can make JS calls to it
	// its part of the API player that youtube provides.
	
	function onYouTubePlayerReady(playerId) {
		alert('ff')
		ytplayer = document.getElementById("flashVideoPlayer");
		ytplayer.playVideo();
		
	}
	

	</script>

</body>
</html>