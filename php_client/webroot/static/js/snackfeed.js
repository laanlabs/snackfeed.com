var sf = {

clipboardcopy : function(vThis,vID) {
  
  	var s = document.getElementById(vID).value;

  	vThis.focus();vThis.select();
  
  if ( window.clipboardData && clipboardData.setData ) {
    clipboardData.setData("Text", s);
   } else {
     var flashcopier = $('flashcopier');
   if(flashcopier == undefined) {
     flashcopier = new Element("div", {"id": "flashcopier"});
   document.body.appendChild(flashcopier);
   }
  flashcopier.innerHTML = '';
    var divinfo = '<embed src="/static/swfs/clipboard.swf" FlashVars="clipboard='+encodeURIComponent(s)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    flashcopier.innerHTML = divinfo;
  }
},


form_update : function(vID, rID){
  // do the same with a callback:
  $(vID).request({
    onComplete: function(transport)
      { 
        var response = transport.responseText || "no response text";
        //alert(response) 
        $(rID).update(response);
      }
  })
},


//use updates -- NOT ThiS ONE	
update : function(vID, vURL)
{
	$(vID).update('busy..');
	new Ajax.Request(vURL,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      var response = transport.responseText || "no response text";
		$(vID).href = '#';
		$(vID).update('saved');
	      //alert("Success! \n\n" + response);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });


},

updates : function(vID, vURL)
{

	new Ajax.Request(vURL,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      var response = transport.responseText || "no response text";
		$(vID).href = '#';
		$(vID).update(response);
		$(vID).addClassName('btnSelected')
	      //alert("Success! \n\n" + response);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });


},

clearPlaylist : function()
{
	vID = 'playlist-play';
	vURL = '/videos/playlist_clear?rem_group_id=0&plain=1';
	$(vID).update('busy...');
	$('playlist-clear').update('');

	new Ajax.Request(vURL,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      var response = transport.responseText || "error";
		$(vID).href = '#';
		$(vID).update(response);
		

		$('playlist_count').update(0);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });


},



addPlay : function(vID, vURL)
{
	$(vID).update('busy...');
	//$(vID).removeClassName('feed-add-button');
  //$(vID).addClassName('feed-add-button-busy');
  
	new Ajax.Request(vURL,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      var response = transport.responseText || "error";
		$(vID).href = '#';
		$(vID).update(response);
		//$(vID).removeClassName('feed-add-button-busy');
		//$(vID).addClassName('feed-add-button-added');
		
		var vCount = $('playlist_count').innerHTML;
		vCount = vCount*1 + 1;
		$('playlist_count').update(vCount);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });


},

addPlayPublicFeed : function(vID, vURL)
{
	//$(vID).update('busy...');
	$(vID).removeClassName('feed-add-button');
  $(vID).addClassName('feed-add-button-busy');
  
	new Ajax.Request(vURL,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      var response = transport.responseText || "error";
		$(vID).href = '#';
		//$(vID).update(response);
		$(vID).removeClassName('feed-add-button-busy');
		$(vID).addClassName('feed-add-button-added');
		
		var vCount = $('playlist_count').innerHTML;
		vCount = vCount*1 + 1;
		$('playlist_count').update(vCount);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });


},



bodyLoaded : function () {
  
  
  //sf.addLinkListeners();
  
  if ( $("feed-flash-message") )
  Effect.Pulsate('feed-flash-message' , { pulses: 1, duration: 1 , from: 0.3 } );
  
  //if ( $("voice-bubble") ) {
  //  setTimeout( function() { Effect.Appear("voice-bubble",{ duration: 3.0  }) } , 3000 );
  //}
  
},

addLinkListeners : function () {
  
  $$('.status_updates').each( function(s) {
    s.observe('mouseover', mouseOverLink );
    s.observe('mouseout', mouseOutLink );
    });
    
  $$('.video-link').each( function(s) {
    s.observe('mouseover', mouseOverLink );
    s.observe('mouseout', mouseOutLink );
    });
  
  
  if ( $("feed-mouse-over") ) {
    $("feed-mouse-over").observe('mouseover', mouseOverPopup );
    $("feed-mouse-over").observe('mouseout', mouseOutPopup );
  }
  
},


createAutoComplete : function() {
  new Ajax.Autocompleter("search_box", "autocomplete_choices" , "/shows/autocomplete" , {
	  afterUpdateElement : getSelectionId,
		indicator : "search_indicator"
	});
  
}
	
	
	
}

var showOption = {
	
	active : false,
	activeID : null,
	timeout: null,
	
	initOption : function(activeID)
	{
		
		showOption.activeID = activeID;
		showOption._clearTimeout(showOption.timeout);
		if (!showOption.active) $(showOption.activeID).show();
		
	},
	
	offOption : function ()
	{
		showOption.timeout = window.setTimeout(showOption.closeOption, 1000);
	},
	
	closeOption : function ()
	{
		$(showOption.activeID).hide();		
	},
	
	_clearTimeout: function(timer) {
		clearTimeout(timer);
		clearInterval(timer);
		return null;
	}
	
	
}


var mouseTimer;
var currentElement;
var popOpen = false;

function mouseOverPopup( event ) {
  
  if ( mouseTimer ) clearTimeout( mouseTimer );
  
}

function mouseOutPopup( event ) {
  
  if ( mouseTimer ) clearTimeout( mouseTimer );
  
  if ( popOpen ) {
    mouseTimer = setTimeout( displayPop , 500 );
  }
  
}

function mouseOverLink( event ) {
  
  
  // new link moused over..
  if ( popOpen && currentElement != event.element() ) {
    currentElement = event.element();
    displayPop();
  } else {
    currentElement = event.element();
  }
  
  
  if ( mouseTimer ) clearTimeout( mouseTimer );
  
  mouseTimer = setTimeout( displayPop , 1000 );
  
  //alert( currentElement.getAttribute("uid") );
  
  if ( currentElement.hasClassName("status_updates") )
  getUserProfileData( currentElement.getAttribute("uid") );
  else if ( currentElement.hasClassName("video-link") )
  getVideoData( currentElement.getAttribute("uid") );
  
}

function mouseOutLink( event ) {
  
  if ( mouseTimer ) clearTimeout( mouseTimer );
  

  if ( popOpen ) {
    mouseTimer = setTimeout( displayPop , 500 );
  }
  
  //$("feed-mouse-over").hide();
  //var element = event.element();
  //element.removeClassName('active');
  
}

function displayPop () {
  
  if ( !currentElement ) return;
  
  if ( popOpen )  {
    
    $("feed-mouse-over").hide();
    popOpen = false;
    
  } else {
    
    Element.clonePosition( $("feed-mouse-over") , currentElement , 
      {"setWidth" : false , "setHeight" : false , "offsetTop" : 20 }
    );
    
    $("feed-mouse-over").show();
    
    popOpen = true;
    
  }
  
  
  
  
}

function getUserProfileData( userId ) {
  
  $("popup-title").update( "Loading..." );
  
  new Ajax.Request("/users/get_user_popup_info?uid="+userId ,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      
	      var response = transport.responseText || "Error broham.";
		    renderProfilePopup( response );
		    
		    
	      //alert("Success! \n\n" + response);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	  
}

function getVideoData( videoId ) {
  
  $("popup-title").update( "Loading..." );
  
  new Ajax.Request("/videos/detail/"+videoId+"?json" ,
	  {
	    method:'get',
	    onSuccess: function(transport){
	      
	      var response = transport.responseText || "Error broham.";
		    renderVideoPopup( response );
		    
		    
	      //alert("Success! \n\n" + response);
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	  
}

function renderProfilePopup( response ) {
  
  
  var jsonDecoded = response.evalJSON();
  
  $("popup-title").update( jsonDecoded.user_info.nickname );
  
  if ( jsonDecoded.youre_following == "1" ) {
    $("popup-subscribe-link").update("Unsubscribe");
  } else {
    $("popup-subscribe-link").update("Subscribe");
  }
  
  var followingText = " is not following you.";
  
  if ( jsonDecoded.following_you == "1"  )
  followingText = " is following you!";
  
  $("popup-description").update( jsonDecoded.user_info.nickname + followingText );
  $("popup-thumbnail").setAttribute("src" , jsonDecoded.user_info.thumb );
  
  return htmlStuff;
  
  
}

function renderVideoPopup( response ) {
  
  //alert(response);
  
  var jsonDecoded = response.evalJSON();
  
  $("popup-title").update( jsonDecoded.title.substring(0 , 20 ) );
  
  $("popup-subscribe-link").update("Subscribe to: " +  jsonDecoded.show_title.substring(0 , 20 ) );
  
  $("popup-description").update( "Show: " + jsonDecoded.show_title);
  
  $("popup-thumbnail").setAttribute("src" , jsonDecoded.thumb );
  
  return htmlStuff;
  
  
}


function signupAlerts( ) {
  
  //$("newsletter-button").setAttribute( "value" , "loading");
  var email = $("alert_email").value;
  
  new Ajax.Request("/users/signup_newsletter?email="+email ,
	  {
	    method:'get',
	    
	    onSuccess: function( transport ) {
	      
	      var response = transport.responseText || "Error broham.";
	      var jsonDecoded = response.evalJSON();
	      
	      
	      if ( jsonDecoded.error == "1" ){ 
		      
		      flashMessage( "<span style='color:#ff3300;'>Error:</span> " + jsonDecoded.message );
		      //$("newsletter-button").setAttribute( "value" , "Try again");
  	      
  	      
	      } else {
	        
	        flashMessage( "Thanks for signing up, we'll let you know when we launch." );
	        //$("email-alert-box").hide();
	        //$("newsletter-button").setAttribute( "value" , "Thanks");
	        
	      }
	      
	      
	    },
	    onFailure: function(){ alert('Something went wrong...') }
	  });
	  
}

var flashTimer;


function flashMessage( text ) {
  
  if ( flashTimer )  clearInterval( flashTimer );

  
  $("gmail-flash-holder").show();
   $("gmail-flash-message").update( text );
   
   flashTimer = setTimeout( function() { $("gmail-flash-holder").hide(); } , '8000' );
   
   
}


function getSelectionId(text, li) {
    //alert (li.id);
    document.location = "/shows/detail/"+li.id;
}

function resetText(vID, vText)
{
  if ( $(vID).value == '') $(vID).value = vText;
  
}

function clearText(vID,vText)
{
  $(vID).value = '';
}


flashVars = {
	height: 100
};

var params = {
	wmode: "transparent",
	menu: "false",
	allowFullScreen: "true",
	allowscriptaccess : "always",
	bgcolor: "#ffffff",
	scale : "noorder" , 
	salign: "t"
};

var attributes = {
  id: "flashLogo", 
  name: "flashLogo"
};

//setTimeout(  function() { var logoSwf = swfobject.embedSWF( "/static/swfs/SnackfeedLogo.swf" ,  "swfLogoHolder", "100", "100", "9.0.0", "/images/swf/expressInstall.swf", flashVars, params, attributes); }  , 2000 );


