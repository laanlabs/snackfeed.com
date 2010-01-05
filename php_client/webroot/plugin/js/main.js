
// div base name / is selected / is first time
var mediaArray = new Array(
			new Array('videos',1,0),
			new Array('images',0,0),
			new Array('text',0,0),
			new Array('songs',0,0)
			);


var postArray = new Array(
			new Array('tumblr',0,0),
			new Array('wordPress',0,0),
			new Array('twitter',0,0),
			new Array('blogger',0,0),
			new Array('channels',0,0)			
			);	

var currentVideo = 0;

function showVideo(i)
{
	$('video_' + currentVideo).hide();
	$('video_' + i).show();
	
	
	$('videoLink_' + currentVideo).removeClassName('videoBtnOn');
	$('videoLink_' + i).addClassName('videoBtnOn');

	
	currentVideo = i;
	
}

function showPost()
{
	
	$('mediaWin').hide();
	$('accountsWin').show();
	$('postWin').hide();
	
	$('step1Div').removeClassName('selectedTab');
	$('step2Div').addClassName('selectedTab');
	
}


function showMedia()
{
	
	$('mediaWin').show();
	$('accountsWin').hide();
	$('postWin').hide();
	
	$('step2Div').removeClassName('selectedTab');
	$('step1Div').addClassName('selectedTab');
	
}

function doPost()
{

$('responseWin').update("Performing posts... please wait....")

	$('mediaWin').hide();
	$('accountsWin').hide();
	$('postWin').show();
	
	
	for (var i=0; i < postArray.length; i++) 
	{
		if (postArray[i][1] == 1)
		{
			var vPost = postArray[i][0];
			//copy the embed coide
			var vData = $('f_video_'+ currentVideo).value.escapeHTML()
			 $(vPost + '_data').value =  vData
			 
			 var v_source =  $('f_video_source_'+ currentVideo).value;
			 var v_params =  $('f_video_params_'+ currentVideo).value;
		  
			$(vPost+'FormData').request({
			  method: 'post',
        parameters: { video_source: v_source, video_params: v_params },
        
			  onComplete: function(transport)
				{ 
					
					doUpdate( transport.responseText);
					//alert('Form data saved!' + transport.responseText ) 
				}
			})
			
			//alert (vPost);
		}
	}


	// do the same with a callback:

	
	
}


function doUpdate(vText)
{
	//alert(vText)
	var a = new Element('div', { 'class': 'postText' }).update(vText);
	$('responseWin').appendChild(a);
	
}

function doCheck(id)
{

	var el = $(postArray[id][0]+'CHK');

	if ( el.hasClassName('checkbox') )
	{
		el.removeClassName('checkbox');
		el.addClassName('checked');
		postArray[id][1] = 1;

	} else {
		
		el.removeClassName('checked');
		el.addClassName('checkbox');	
		postArray[id][1] = 0;
		
	}
}



function getPostDiv(id)
{
	var divName = postArray[id][0];
	
	//if this is first time we have clicked add check box
	if (postArray[id][2] == 0)
	{
		postArray[id][2] = 1;
		var el = $(postArray[id][0]+'CHK');
		
		el.removeClassName('checkbox');
		el.addClassName('checked');
		postArray[id][1] = 1;
		
	}
	
	
	
	for (var i=0; i < postArray.length; i++) 
	{
		var el = $(postArray[i][0]);	
		if ( el.hasClassName('postOptionsOn') ) el.removeClassName('postOptionsOn');
		$(postArray[i][0] + 'Form').hide();
	}
		
	
		var el = $(divName);
		el.addClassName('postOptionsOn');
		
		$('infoForm').hide();
		$(postArray[id][0] + 'Form').show();

}


function manEntry()
{
	
	 $('video_0').update($('man_embed').value );
	 $('f_video_0').value = $('man_embed').value;
	 $('noFound').hide();
	
	
}

///////////////////////////////////

function doMediaCheck(id)
{


	for (var i=0; i < mediaArray.length; i++) 
	{
		
		var el = $(mediaArray[i][0]+'CHK');
		if ( !el.hasClassName('checkbox') )
		{
			el.removeClassName('checked');
			el.addClassName('checkbox');	
			mediaArray[i][1] = 0;
			
			$(mediaArray[i][0]+'Found').removeClassName('postOptionsOn');
			$(mediaArray[i][0] + 'Form').hide();
			

		}




	}


		var el = $(mediaArray[id][0]+'CHK');

		el.removeClassName('checkbox');
		el.addClassName('checked');
		mediaArray[id][1] = 1;
		
		$(mediaArray[id][0]+'Found').addClassName('postOptionsOn');
		$(mediaArray[id][0] + 'Form').show();
		
}



function twCounter() 
{
	
	if ($('twitter_url_append').checked)
	{
	  maxlimit = 115;
	} else {
	  maxlimit = 140;
	}
	
	
	vCount = maxlimit - $('twitter_message').value.length;
	$('sBann').update( vCount + " characters left");
	

	/*if ($(field).length > maxlimit) {
		vCount = $(field).substring(0, maxlimit);
		//$(cntfield).update( vCount)

 	} else {
	vCount = maxlimit - $(field).length;
	//$(cntfield).update( vCount);
	}
	*/
}



function getChannels()
{
	
	vMSG = 'Please Click getChannels with Valid Users';
	
	$('sf_user_id_1').value = '';
	$('sfChannelsList').innerHTML = vMSG;
	
	vURL = '/users/get_user_id?&plain&email=' + $('sf_email').value;
	
	vID = $('sf_user_id_1').value;
	
	if (vID.length != 36 ) 
	{
	
	new Ajax.Request(vURL, { method:'get',
	  onSuccess: function(transport){
	      vResponse = transport.responseText;
		  
			
		   if (vResponse.length == 36)
			{
				
				$('sf_user_id_1').value = vResponse;
				requestChannels();
			} else {
				
				//alert('you are not a valid user')
				$('sfChannelsList').innerHTML = vMSG;
			}
			
		
	    }
	  });
	
	} else  {
		
		requestChannels();
		
	}


	//sf_user_id_1
	
}

function requestChannels()
{
	
	
	$('channelsUserInfo').request({
	  onComplete: function(transport)
		{ 
			
			doChannelsList( transport.responseText);
			//alert('Form data saved!' + transport.responseText ) 
		}
	})
	
}


function doChannelsList(vText)
{

$('sfChannelsList').innerHTML = '';

$('sf_user_id_2').value = $('sf_user_id_1').value;

	var data = vText.evalJSON();
	

	
	for (var i=0; i < data.length; i++) 
	{
	
			vResultText = data[i].title;
		var a = new Element('div', { 'class': 'postText' });
		var vCheck = new Element('input', { 'type': 'checkbox', 'name': '_channel_ids[]', 'value' : data[i].channel_id });
	
		var t = new Element('text').update(vResultText);
		
		a.appendChild(vCheck);
		a.appendChild(t);
		$('sfChannelsList').appendChild(a);
	
	}
}

function showWpAdv() 
{
  $('wpBasicOptions').hide(); $('wpAdvOptions').show();
}

function hideWpAdv() 
{
  $('wpBasicOptions').show(); $('wpAdvOptions').hide();
}

function showBAdv() 
{
  $('bBasicOptions').hide(); $('bAdvOptions').show();
}

function hideBAdv() 
{
  $('bBasicOptions').show(); $('bAdvOptions').hide();
}

function showChannelOption()
{
	$('channels').show();
}
