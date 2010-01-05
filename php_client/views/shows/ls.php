<div style="padding-top:70px"></div>



<div id="search-container" >
	

	
<div id="search-wrapper" >
	<form id="searchForm" method="get" action="/shows/ls" name="searchForm">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" style="width: 220px" >
				<a href="javascript:document.search_form.submit();">search for shows</a>
			</div>
		</div>

	</form>
</div>

<br clear="both" />




<br clear="all" />



<div style="padding-top: 30px">

<div class="two-column-left">
	<div class="header-big">
		show categories
	</div>
	<div class="indent-column">
	<div style="height: 15px"></div>	
		
	<ul class="sideFilterOptions" style="font-size: 12px; line-height: 15px">
<? for ($i = 0 ; $i < count($tag_data) ; $i++)
			{
?>
		<li><a href="/shows/ls?q=<?= $q ?>&t=<?= $tag_data[$i]['tag_id']?>&ob=<?= $ob ?>"><?= $tag_data[$i]['name'] ?> (<?= $tag_data[$i]['vCount'] ?>) </a></li>
<?		}   ?>
	</ul>	
	
</div>
</div>



<div class="two-column-right">
	<div class="header-big">
		show results <? if ($q ) { ?> for '<?= $q ?> '<? } ?><span class="small-detail">displaying <?= $o+1 ?> - <?= $o+$c ?> of <?= $vTotal ?> </span>
	</div>

<div style="padding: 5px; border-bottom: 1px solid #666; height: 30px">
	<div style="float:left">sort: 
		<a href="/shows/ls?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_pub-DESC">date</a> |
		<a href="/shows/ls?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.title">title</a> 		
		
	</div>
	<div style="float:right">  
		<? if ($o > 1 ) { ?>
			<a href="/shows/ls?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/shows/ls?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
		
	</div>
	
</div>
<br clear="all"/>
	<div class="indent-column">
	
<? 		for ($i = 0 ; $i < count($shows_data) ; $i++)
			{
?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $shows_data[$i]['thumb']  ?>"/>
		<a href="/shows/detail/<?= $shows_data[$i]['show_id'] ?>/<?= preg_replace('/\W/', '-', $shows_data[$i]['title']) ?>"><?= stripslashes($shows_data[$i]['title']) ?></a><br/>
			
		 <?= substr($shows_data[$i]['detail'], 0, 120) ?> 
			
			
			
			<? if ( User::$user_id ){ ?>
				<div class="item-actions">
					<a href="javascript:sf.updates('show_follow_<?= $i . $j ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $shows_data[$i]['show_id']  ?>&plain=1')" class="" id="show_follow_<?= $i . $j  ?>" >follow this show</a>
				</div>
			<? } ?>
			
	</div>

<?		}    ?>
	
	





</div>
</div>
