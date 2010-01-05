//global vars

var offset = 0;
var pagesize = 12;




tubeLister = {
	init:function(e){



		var f = document.getElementsByTagName('form')[0];

		tubeLister.photosList = document.createElement('ul');
		tubeLister.photosList.id = 'tubeListerPhotos';
		//tubeLister.photosList.style.display='none';

		var f = document.getElementsByTagName('form')[0];
		
		var x = document.getElementById('results');
		
		
		
		
		var b = document.createElement('div');
		b.id='box';

		b.appendChild(tubeLister.photosList);

		x.appendChild(b);
		//b.style.display='none';
		tubeLister.photosList.innerHTML = "results holder";	
		
		
		
		tubeLister.playList = document.createElement('ul');
		var y = document.getElementById('playlistDiv');
		var c = document.createElement('div');
		c.id='boxList';
		c.appendChild(tubeLister.playList);
		y.appendChild(c)	;
		tubeLister.playList.innerHTML = "<li>Playlist holder</li>";	
		
		
		
		//pagination
		var p = document.getElementById('pagination');
		tubeLister.pageList = document.createElement('div');
		p.appendChild(tubeLister.pageList);
		tubeLister.pageList.innerHTML = "PAGE LIST HERE";
		
		
		//calls the click button
		YAHOO.util.Event.on(f,'submit',tubeLister.callResults);
	},
	callResults:function(e){
			YAHOO.log("calling for data");	
			
			
			
			//Load the transitional state of the results section:
			tubeLister.photosList.innerHTML = "<h3>Retrieving Data...</h3>" +
				"<img src='http://l.yimg.com/us.yimg.com/i/nt/ic/ut/bsc/busybar_1.gif' " +
				"alt='Please wait...'>";
							
				
				//alert (offset);
							
				var url = "/shows/get_show_list?json=1&limit="+  pagesize + "&offset=" + offset;			
				YAHOO.log("URL: " + url);
			
			
				YAHOO.util.Connect.asyncRequest('GET',url, callbacks);					
					
					
							

	},
	
	showResults:function(showResults){

		YAHOO.log("HOWS SOUCNT" + showResults['shows'].length);

        //YAHOO.log("PARSED DATA: " + YAHOO.lang.dump(showResults));

        // The returned data was parsed into an array of objects.
        // Add a P element for each received message

		var output='';

        for (var i = 0, len = showResults['shows'].length; i < len; ++i) {
			//YAHOO.log(showResults['shows'][i]['thumb']);
			output+='<li><a href="'+showResults['shows'][i]['thumb'] + '" title="'+showResults['shows'][i]['title'] + '"><img src="' + showResults['shows'][i]['thumb'] +'" id="' + showResults['shows'][i]['show_id']  + '" alt="'+showResults['shows'][i]['title']+'" /></a></li>';	
        }

	
		//YAHOO.log("calling for data:" + data);

		//make sure we have removed all listeneres
		YAHOO.util.Event.purgeElement( tubeLister.photosList , true);
		
		YAHOO.util.Dom.setStyle(tubeLister.photosList,'opacity',0);
		tubeLister.photosList.style.display = 'block';

		var anim2 = new YAHOO.util.Anim(tubeLister.photosList,{ opacity: {to: 1} }, .6);
	    anim2.animate();

		
		tubeLister.photosList.innerHTML = output;	
		
		YAHOO.util.Event.on(tubeLister.photosList,'click',tubeLister.addPlaylist);	
	
	
	
		//make pagelist
		tr = showResults['total_results'];
		pages = Math.ceil(tr/pagesize);
	
		output = '';
		for (var i = 0; i < pages; ++i) {
			output += '[<a href="" id="' + i*pagesize + '" >' + eval(i+1) + '</a>]';
		}
	
		
		//add prev page
		var vPrev = (offset) -  (pagesize);
		if (offset >= pagesize ) output = '<a href="" id="' + vPrev +  '" title="' + vPrev +  '" >prev</a>' + output;
		
		
		//add prev page
		var vNext = (offset) + (pagesize);
		if (vNext < tr ) output += '<a href="" id="' + vNext +  '" title="' + vNext +  '">next</a>';
		
		
		tubeLister.pageList.innerHTML = output;
		YAHOO.util.Event.on(tubeLister.pageList,'click',tubeLister.movePage);	
		
	},
	
	movePage:function(e){
		YAHOO.util.Event.preventDefault(e);
		
		var o = YAHOO.util.Event.getTarget(e);
		offset = parseInt(o.id);
		

		if (offset) {
			YAHOO.util.Event.purgeElement( tubeLister.pageList , true);
			tubeLister.callResults();
		}
	},
	
	addPlaylist:function(e){
		
		
		YAHOO.util.Event.preventDefault(e);	

		var o = YAHOO.util.Event.getTarget(e);
		//alert(o.alt);
		
		tubeLister.playList.innerHTML += "<li>" +  o.alt  +  "</li>";	
		
		var postData = "id=" + o.id;
		
		
		YAHOO.util.Connect.asyncRequest('POST',"show_save.php", postBacks, postData );
		
		
	}
	

}




var callbacks = {

    success : function (o) {
		YAHOO.log("DATA Response");
        //YAHOO.log("RAW JSON DATA: " + o.responseText);


		var jsonString =  o.responseText;
		
	
		
		var showResults = [];
		
		try { 
		    showResults = YAHOO.lang.JSON.parse(jsonString); 
			YAHOO.log("PARSE SUCCESSCULE");
		} 
		catch (e) { 
		    alert("Invalid product data"); 
		}
		
		tubeLister.showResults(showResults);

    },

    failure : function (o) {
        if (!YAHOO.util.Connect.isCallInProgress(o)) {
            alert("Async call failed!");
        }
    },

    timeout : 3000
}


var postBacks = {
	

    success : function (o) {
		YAHOO.log("DATA Response");
        YAHOO.log("RAW JSON DATA: " + o.responseText);




    },

    failure : function (o) {
        if (!YAHOO.util.Connect.isCallInProgress(o)) {
            alert("postback Async call failed!");
        }
    },

    timeout : 3000	
	
	
	
	
}