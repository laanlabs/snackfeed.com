
<!--
// -----------------------------------------------------------------------------
// Globals
// Major version of Flash required
var requiredMajorVersion = 9;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 28;
// -----------------------------------------------------------------------------
// -->


function moveIFrame(x,y,w,h) {
    var frameRef=document.getElementById("myFrame");
    frameRef.style.left=x;
    frameRef.style.top=y;
    var iFrameRef=document.getElementById("myIFrame");	
	iFrameRef.width=w;
	iFrameRef.height=h;
}

function hideIFrame(){
    document.getElementById("myFrame").style.visibility="hidden";
}
	
function showIFrame(){
    document.getElementById("myFrame").style.visibility="visible";
}

function loadIFrame(url){
	document.getElementById("myFrame").innerHTML = "<iframe id='myIFrame' src='" + url + "'frameborder='0'></iframe>";
}

function loadSwf(url) {
	
	if (navigator.appName.indexOf("Microsoft") != -1) {
				try {
					document.getElementById("iframe_frame1").window["hulu_loader"].loadSwf(url);
				} catch(e){}
    }
    else {
				try {
					document.getElementById("iframe_frame1").document["hulu_loader"].loadSwf(url);
				} catch(e){}
    }
	
}

function shrinkPlayer() {
	
		if (navigator.appName.indexOf("Microsoft") != -1) {
				try {
					window["hulu_loader"].shrinkPlayer();
				} catch(e){}
    }
    else {
				try {
					document.getElementById("iframe_frame1").document["hulu_loader"].shrinkPlayer();
				} catch(e){}
    }

}

function goFullScreen() {
	
		if (navigator.appName.indexOf("Microsoft") != -1) {
				try {
					window["hulu_loader"].goFullScreen();
				} catch(e){}
    }
    else {
				try {
					document.getElementById("iframe_frame1").getElementById("hulu_loader").goFullScreen();
				} catch(e){}
    }

}


