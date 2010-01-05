<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Server-side Pagination</title>

<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}
</style>

<link rel="stylesheet" type="text/css" href="yui/build/fonts/fonts-min.css?_yuiversion=2.5.0" />
<link rel="stylesheet" type="text/css" href="yui/build/datatable/assets/skins/sam/datatable.css?_yuiversion=2.5.0" />
<script type="text/javascript" src="yui/build/utilities/utilities.js?_yuiversion=2.5.0"></script>
<script type="text/javascript" src="yui/build/json/json.js?_yuiversion=2.5.0"></script>
<script type="text/javascript" src="yui/build/datasource/datasource-beta.js?_yuiversion=2.5.0"></script>
<script type="text/javascript" src="yui/build/datatable/datatable-beta.js?_yuiversion=2.5.0"></script>

<link rel="stylesheet" type="text/css" href="yui/build/container/assets/skins/sam/container.css?_yuiversion=2.5.0" />
<script type="text/javascript" src="yui/yahoo-dom-event/yahoo-dom-event.js?_yuiversion=2.5.0"></script>
<script type="text/javascript" src="yui/build/container/container.js?_yuiversion=2.5.0"></script>


<script type="text/javascript" src="yui/build/yuiloader/yuiloader-beta.js"></script>


<!--begin custom header content for this example-->
<style type="text/css">
    #paging a {
        color: #0000de;
    }

		.yui-overlay { position:absolute;background:#fff;border:1px dotted black;padding:0px;margin:0px; }
		.yui-overlay .hd { border:1px solid red;padding:5px; }
		.yui-overlay .bd { border:1px solid green;padding:5px; }
		.yui-overlay .ft { border:1px solid blue;padding:5px; }

		#ctx { background:orange;width:100px;height:25px; }

		#example {height:15em;}


</style>

<!--end custom header content for this example-->

</head>

<body class=" yui-skin-sam">

<h1>Server-side Pagination</h1>
<p><a href="#" id="loglink">Click here</a> to log a simple message.</p>
<div class="exampleIntro">
	<p>This example illustrates how to configure a DataTable instance to page through a large data set managed on the server.</p>
			
</div>

<div>
	overlay1:
	<button id="show1">Show</button>

	<button id="hide1">Hide</button>
</div>


<div id="overlay1" style="visibility:hidden">
	<div class="hd">Overlay #1 from Markup</div>
	<div class="bd">This is a Overlay that was marked up in the document.</div>
	<div class="ft">End of Overlay #1</div>

</div>


<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<div id="demo">
    <div id="paging"></div>
    <div id="dt"></div>
</div>
<script type="text/javascript">


YAHOO.namespace("example.container");

	function init() {
		// Build overlay1 based on markup, initially hidden, fixed to the center of the viewport, and 300px wide
		YAHOO.example.container.overlay1 = new YAHOO.widget.Overlay("overlay1", { fixedcenter:false,
																				  xy:[600,200],
																				  visible:false,
																				  width:"100%"
																				 } );
		YAHOO.example.container.overlay1.render();
		YAHOO.log("Overlay1");

		YAHOO.util.Event.addListener("show1", "click", YAHOO.example.container.overlay1.show, YAHOO.example.container.overlay1, true);
		YAHOO.util.Event.addListener("hide1", "click", YAHOO.example.container.overlay1.hide, YAHOO.example.container.overlay1, true);
		
		
		
		
		var loader = new YAHOO.util.YUILoader();
		loader.insert({
		    require: ['fonts','dragdrop','logger'],
		    base: 'yui/build/',

		    onSuccess: function(loader) {
		            YAHOO.util.Event.addListener(YAHOO.util.Dom.get("loglink"), "click", function(e) {
		                YAHOO.util.Event.stopEvent(e);
		                YAHOO.log("This is a simple log message.");
		            });

		            // Put a LogReader on your page
		            this.myLogReader = new YAHOO.widget.LogReader();
		    }
		});		
		
		
		
		
		

	}

	YAHOO.util.Event.addListener(window, "load", init);











YAHOO.util.Event.onDOMReady(function () {
    var DataSource = YAHOO.util.DataSource,
        DataTable  = YAHOO.widget.DataTable,
        Paginator  = YAHOO.widget.Paginator;

    var mySource = new DataSource('/shows/get_show_list?json=1');
    mySource.responseType   = DataSource.TYPE_JSON;
    mySource.responseSchema = {
        resultsList : 'shows',
        totalRecords: 'total_results',
        fields      : [
            'show_id','title','detail','thumb']
    };

    var buildQueryString = function (state,dt) {
        return "startIndex=" + state.pagination.recordOffset +
               "&results=" + state.pagination.rowsPerPage;
    };

    var myPaginator = new Paginator({
        containers         : ['paging'],
        pageLinks          : 5,
        rowsPerPage        : 15,
        rowsPerPageOptions : [15,30,60],
        template           : "<strong>{CurrentPageReport}</strong> {PreviousPageLink} {PageLinks} {NextPageLink} {RowsPerPageDropdown}"
    });

    var myTableConfig = {
        initialRequest         : 'startIndex=0&results=25',
        generateRequest        : buildQueryString,
        paginationEventHandler : DataTable.handleDataSourcePagination,
        paginator              : myPaginator
    };

    var myColumnDefs = [
        {key:"show_id"},
        {key:"title"},
        {key:"thumb"}
    ];

    var myTable = new DataTable('dt', myColumnDefs, mySource, myTableConfig);
});

</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->

</body>
</html>