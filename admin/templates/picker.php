<html>
<head>
	<title>Admin</title>
	<style type="text/css">
		@import '/lib/css/default.css';
		@import '/lib/css/new.css';					
	</style>	
</head>
<body>
	
	<?
	//include the view template
	include MODELS."/".$_m."/views/". $_v .".php";
	?>


	<script>
	function setField(fID, fName)
	{

		if(window.top.opener.idField)
		{
			window.top.opener.idField.value = fID;
			window.top.opener.nameField.value = fName;
			window.top.close();
		}
		else
		{
			alert('The original form cannot be found. Please make your selection again.');
			window.top.close();
		}
	}
	</script>


</body>
</html>