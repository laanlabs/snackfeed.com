<html>
<head>
	
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>edit room</title>
	
	
	<link rel="stylesheet" href="/static/css/v2/edit_room.css" type="text/css" media="screen"  charset="utf-8">
	
	<script src="/static/js/prototype.js" type="text/javascript"></script>
	<script src="/static/js/scriptaculous.js" type="text/javascript"></script>
	<script src="/static/js/swfobject.js" type="text/javascript" charset="utf-8"></script>
	
	
</head>
<body>


<div id="headerDiv">

	

	<div style="float:left; padding-top: 5px;">
		<a href="/"><img src="/static/images/v2/back_to_sf.png"></img></a>

	</div>
	
	<div style="padding-top: 5px; padding-right: 4px; padding-left: 50px; float: left;">
		<img src="/static/images/v2/editing.png"></img>
	</div>
	
	<div id="tcnetwork" style="padding-top: 5px; float: left;">

		<div onclick="showDropDown(); stopPropagation(event)" id="tcnetwork_top" class=""><?= $current_channel['title'] ?></div>
	
		<div onclick="stopPropagation(event)" id="tcnetwork_dropdown" style="display: none;">
			<ul>

				<? for ($i = 0 ; $i < count($channel_data) ; $i++){ ?> 	
				
				<? if ( $current_channel['channel_id'] != $channel_data[$i]['channel_id'] ) {   ?>
				<li>
				<a href="/users/editRoom/<?= $channel_data[$i]['channel_id'] ?>" >
					<?= $channel_data[$i]['title'] ?>
				</a> 
				</li>

				<?	} } ?>

			</ul>
		</div>
	
	</div>
	
	
	<div id="busyDiv" style="position:relative; top:-8px; display:none; float: left; padding-left: 50px; overflow: visible; height: 1px; width:1px;">
		<img src="/static/images/v2/spinner.gif"></img>
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
	
	

	
	
	<div style="height:340px; padding-top: 10px; width: 100%; ">
	
		
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
	
		<div id="playerHolder" style="width: 180px; height: 150px; background: #000; margin: 5px" >
			<div id="swfHolder" >
			</div>
		</div>

		<div style="background: #eee; color: #fff; height: 18px;">
			
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
		
			
		
				<div id="search-container">

				<div style="padding: 5px;">
					<a id="normalSearchButton" class="selected"  href="javascript:editingRoom.setSearchType('normal');">normal</a> | 
					<a id="ytSearchButton" href="javascript:editingRoom.setSearchType('yt');">youtube</a>
				</div>

				<div id="search-wrapper">
					<form name="search_form" action="/search" method="get" id="search-form">
						<div id="search-box">
							<input type="search" value="" name="q" onkeydown="javascript:editingRoom.onSearchKey(event);" placeholder="what are you looking for?" results="10" id="search-input"/>
							</div>
						<div style="padding-top: 10px;" id="search-button">
							<div id="button-submit">
								<a href="javascript:editingRoom.onSubmit(event);">search</a>
							</div>
						</div>
						<div style="padding-left: 20px; padding-top: 15px; text-align: left;" id="search-advanced">
				<a href="">Advanced Options</a>
						</div>

					</form>
				</div>
				<br clear="all"/>

				</div>
		
			
			<a id="previousPageButton" href="javascript:SortableLists.getPage(-1);" style="display:none;">previous</a>
			<a id="nextPageButton" href="javascript:SortableLists.getPage(1);" style="display:none;">next</a>
			
			<div id="resultsInfoDiv">
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
	
	<div id='libraryTabContent' style="display:<?= $_section == "library" ? "" : "none" ?>; height: 90%;  width: 100%; ">
		
		<h1>Video Library</h1>
		
		<div style="height: 83%; overflow-y: scroll; overflow-x: hidden;">
			<ul id='favoritesList' >
			</ul>
		</div>
		
	</div>
	
	<div id='settingsTabContent' style="display:<?= $_section == "settings" ? "" : "none" ?>; height: 90%;  width: 100%;">
		Settings <br/>
		There are no settings right now. check back later.
	</div>
	
	
	
</div>



<!-- COLUMN 3 ( Channel Playlist ) -->
<div id="col3">
	

	<div style="background: #fff; color: #fff; padding-left: 3px;">
		
		<div id="channelTitleDiv">
			
			<span id="channelPlaylistTitle" >Channel Playlist </span>
			
			
			<span style="padding-left: 25px; font-size: 13px; ">
					<a style="color: #000" href="javascript:SortableLists.saveChannelsList()">save changes</a>
			</span>
			
		</div>
		
		
		
	</div>

	
	<div id='channelWrapper' style="clear: left;" >
		
		<ul id='channelList' style="width: 100%; overflow-y: scroll; overflow-x: hidden" >
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


	


	<script type="text/javascript">
	
	var drop_open = "off";
	
	function stopPropagation(event)
	{
	 if(!event)
	 var event = window.event;
	
	 if(event.stopPropagation)
	 event.stopPropagation();
	 else if(window.event.cancelBubble == false)
	 window.event.cancelBubble = true;
	}
   
	function showDropDown()
	{
	 var tcnetwork_dropdown = $('tcnetwork_dropdown');
	 var tcnetwork_top = $('tcnetwork_top');
	
	 if( drop_open == 'off')
	 {
	 
	 tcnetwork_dropdown.style.display = 'block';
	 tcnetwork_top.className = 'tcnetwork_top_on';
	 drop_open = 'on';
	 document.body.addEventListener('click',showDropDown,false);
	 }
	 else
	 {
	 tcnetwork_dropdown.style.display = 'none';
	 tcnetwork_top.className = '';
	 drop_open = 'off';
	 document.body.removeEventListener('click',showDropDown,false);
	
	 }
	}
	
	
	
	
	
	
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
			SortableLists.getUserFavorites();
			
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
		
		sizeRoomToWindow : function () {
			
			//document.viewport.getHeight() -  e.viewportOffset()[1]);
			
			//if ( flip )
			//h.style.top = ( e.viewportOffset()[1] + -document.body.viewportOffset()[1] - h.getHeight() ).toString() + "px";
			
			$("columnWrapper").style.height = (document.viewport.getHeight() -  50) + "px";
			
			$("channelList").style.height = ( parseInt($("columnWrapper").style.height) - 40) + "px";
			
			$("searchResultsDiv").style.height = ( parseInt($("columnWrapper").style.height) - 110) + "px";
			
			//searchResultsDiv
			
			// channelList
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
			
			if ( $("search-input").value != "" ) {
				
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
			
			searchTerm = $("search-input").value;
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
		
		getUserFavorites : function () {
			
			
			// http://dev.snackfeed.com/users/show_favorite_videos?json=1&user_id=sdafdsa
			var ajax_uri = SortableLists.BASE_URL + '/users/show_favorite_videos?json=1&user_id=' + SortableLists.user_id;
			
			//console.log('here this: ' + ajax_uri)
			
			editingRoom.showBusy();
			
			new Ajax.Request(ajax_uri, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					//console.log(json)
					editingRoom.hideBusy();
					
					var name = 'favoritesList';
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
		
		setInterval( editingRoom.sizeRoomToWindow , 1000 );
		
		
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