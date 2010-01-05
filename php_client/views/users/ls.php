<div style="padding-top:70px"></div>
<div class="two-column-left">
	<div class="header-big">
		options
	</div>
	<div class="indent-column">
		
		<div style="height: 20px"></div>
	<div class="sideHeader" id="name">
		SEARCH:
	</div>
<form id="searchForm" method="get" action="/users/ls" name="searchForm">
			<input id="searchBox" type="search" results="10" placeholder="Enter your query" name="q" value="<?= $q ?>" />
	<a href="javascript:document.searchForm.submit();">filter</a>
</form>	
				
		
	</div>
	
	
</div>


<div  class="two-column-right ">
	
	<div class="header-big">
		people 
	</div>
	
	<div class="indent-column">
		

<? for ($i = 0 ; $i < count($data) ; $i++) { ?>

	<div class="result-item" style="height: 90px" >
<img class="img-left-big" src="<?= $data[$i]['thumb']  ?>"/>
	
		<a href="/users/profile/<?= $data[$i]['user_id'] ?>"><?= stripslashes($data[$i]['nickname']) ?></a><br/>
			
			<? if (!empty($data[$i]['location'] )) { ?><?= $data[$i]['location'] ?><br/><? } ?>
			<? if (!empty($data[$i]['bio'] )) {?><?= $data[$i]['bio'] ?><br/><? } ?>
			<? if (!empty($data[$i]['url'] )) {?><a href="<?= $data[$i]['url'] ?>"><?= $data[$i]['url'] ?></a><br/><? } ?>
		
			
		<? 
		
		if ($_user_id != User::$user_id){ ?>
			<div class="item-actions">
				<a href="javascript:sf.updates('user_follow_<?= $i ?>','/users/follow/<?= $data[$i]['user_id'] ?>?&plain=1')" class="" id="user_follow_<?= $i  ?>" >follow this person</a>
	
			</div>
		<? } ?>
	</div>

<?		}    ?>
		
		
	</div>
	
	
	
	
</div>