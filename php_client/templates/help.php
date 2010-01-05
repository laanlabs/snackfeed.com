<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>snackfeed</title>
	<script src="/static/js/prototype.js" type="text/javascript"></script>
	
	<style type="text/css" media="screen">
	html,body{
	      margin:0px;
	      padding:0px;
	      width: 100%;
	      height: 100%;
	      border:none;
	
		font-family: helvetica, arial, verdana, sans-serif;
		font-size: 14px;
	
	}
		
		
	a:link, a:visited, a:active {
		color: #000;
		text-decoration:underline;
		outline:0;
	}

	a:hover {
		color: #666; 
		background: #ccc;
		text-decoration:none; 

	}	
		
		
	

	label.nForm, input.nForm, select.nForm {
		display: block;
		float: left;
		margin-bottom: 10px;
		font-size: 24px;
	}

	input.nForm, textarea.nForm, select.nForm {
		width: 240px;
		border: 1px solid #ccc;
		color:#666;
		background-color:#F2F2F2;

	}

	.nForm:focus	{
		background: #fff;
		border: 1px solid #595959;
	}



	label.nForm  {
		text-align: right;
		width: 175px;
		padding-right: 10px;
		font-weight:bold;

	}


	div.button-form{
		margin-left: 185px;
	}

	#button-submit {

		height: 28px;
		width: 120px;
		background: #fff url('/static/images/v2/bk/btn_bk.gif') repeat-x ;	
		text-align: center;
	}

	#button-submit a {

	line-height: 28px;
	font-size: 18px;
		height:28px;
	 	color: #fff;
		font-weight:bold;
		text-decoration: none;
		text-align: center;
		display: block;
		width: 100%;
	 }

	#button-submit a:hover {


	}


	div.form-message {
		margin-left: 185px; padding-top: 10px; padding-bottom: 10px
	}

	div.field-message {
		margin-left: 185px; padding-top: 0px; padding-bottom: 3px;
		position: relative;
		top: -5px;

	}	
		
	</style>
	
	
</head>

<body>




		

<?

	include VIEWS."/{$_controller}/{$_action}.php";

?>
		







	













</body>
</html>