<div style="padding-top:70px"></div>
<link rel="stylesheet" href="/static/css/v2/tabs.css" type="text/css" media="screen"  charset="utf-8">

<?
	${"tab_" . $_action} = "tab-selected";
?>


<div class="header-tabs">
	<ul class="sub-tabs">
		<li><a class="<?= $tab_edit ?>" href="/users/edit">profile</a></li>
		<li><a class="<?= $tab_images ?>" href="/users/images">images</a></li>
		<li><a class="<?= $tab_password ?>" href="/users/password">change password</a></li>
		<li><a class="<?= $tab_alerts ?>" href="/users/alerts">email/alerts</a></li>
		<li><a class="<?= $tab_ext ?>" href="/users/ext">external accounts</a></li>		
		<li><a class="<?= $tab_packages ?>" href="/users/packages">package wiz</a></li>		
	</ul>	
</div>




