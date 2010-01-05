snackWatcher.formController = {
	
	submit2 : function ( formname , action ) {
		
		//var formObject = document.getElementById( formname );
		$('formTable').hide();
		
	},
	
	jsonHelper : function ( url , callbackFunction ) {
		
		var url2 = url;
		var cback = callbackFunction;
		var jsonResponse = null;
		
		var handlerObj = {
			success : function(o) {
				try { 
					//jsonResponse = YAHOO.lang.JSON.parse(  o.responseText );
					jsonResponse = o.responseText.evalJSON();  
				} 
				catch (e) { 
				    YAHOO.log( "jsonHelper: ERROR PARSING JSON")
				}
				if ( cback ) {
					cback( jsonResponse );
				}
			},
			failure : function(o) {
				YAHOO.log( "jsonHelper: ERROR LOADING URL")
			},
			timeout : 5000
		}
		var callRef = YAHOO.util.Connect.asyncRequest('GET', url , handlerObj );
	},
	
	loadExternalForm : function ( element , url , callbackFunction ) {
		
		var url2 = url;
		var el = element;
		var cback = callbackFunction;
		
		YAHOO.log("trying form: " +  url2 );
		
		
		var handlerObj = function() {
			
			this.success = function(o) {
				
				YAHOO.log("form load success: " +  url2 );
				
				
				
				el.innerHTML = o.responseText;
				
				for(var i = 0, e = el.getElementsByTagName("script"); i < e.length; ++i)
				eval( e[i].innerHTML );
				
				if ( cback )
				cback();
				
				
			}
			
			this.failure = function(o) {
				alert("err")
			}
			
			this.timeout = 5000;
			
		}
		
		
		var callRef = YAHOO.util.Connect.asyncRequest('GET', url , new handlerObj );
		
		
	},
	
	submit : function ( formname , action , callbackFunction ) {
		
		// argument formId can be the id or name attribute value of the
		// HTML form, or an HTML form object.
		
		var callback = function() {
			
			this.success = function(o) {
				
				//YAHOO.log( o.responseText );
				
				//var modal = document.getElementById('modalBox');
				//modal.innerHTML = o.responseText;
				
				//welcomeView.scaleToContentHeight();
				
				if ( callbackFunction ) {
					
					callbackFunction();
					
				} else {
					
					YAHOO.log("no callback");
					
				}
			}
			
			this.failure = function(o) {
				YAHOO.log("error in forrm submit");
			}
			
			this.timeout = 3000;
			
		}
		
		var formObject = document.forms[ formname ];
		
		YAHOO.util.Connect.setForm( formObject );
		
		// This example facilitates a POST transaction.
		// An HTTP GET can be used as well.
		var cObj = YAHOO.util.Connect.asyncRequest( 'POST' , action , new callback() );
		
		
		
		
	}
	
}