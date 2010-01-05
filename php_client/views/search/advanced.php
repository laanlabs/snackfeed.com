

<div style="padding-top:70px"></div>

<div id="search-container" >
	
<div style="padding: 5px">
	<a href="/search/" style="text-decoration: none; font-size: 16px; font-weight: bold;" >normal</a> &nbsp;|&nbsp; 
	
	<a href="/search/youtube?q=<?= $q ?>" style="font-size: 17px; color: #1155ac;" >
		<? if ($q) { ?>
		search '<span style="color: #000000;"><?= $q ?></span>' on YouTube.com
		<? } else { ?>
		search videos on YouTube.com
		<? } ?>
	</a>
	
</div>
	
<div id="search-wrapper" >
	<form id="search-form" method="get" action="/search" name="search_form">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" >
				<a href="javascript:document.search_form.submit();">search</a>
			</div>
		</div>
		<div id="search-advanced" style="padding-left: 20px; padding-top: 15px; text-align: left"> or 
<a href="/shows/ls?q=<?= $q ?>">search for shows</a>
		</div>

	</form>
</div>

<br clear="both" />

<?
	if ( count($results_data) == 0 && $q ) {
?>
<div style="padding: 5px; font-size: 16px; margin-top: 40px; background: #ffe595; ">
There were no results, sorry.

<? if ($q) { ?>
<br/>
<br/>
Try <a href="/search/youtube?q=<?= $q ?>" style="color: #1155ac;" >
searching for '<span style="color: #000000;"><?= $q ?></span>' on YouTube.com
</a>
<? } ?>
</div>
<?
 } ?>


<?
	if ( count($results_data) > 0 ) {
?>

<div style="padding-top: 30px">


<div class="two-column-left">
	<div class="header-big">
		filter options
	</div>
	<div class="indent-column">



	<div style="height: 20px"></div>
	<div class="sideHeader" id="name">
		TYPE:
	</div>
	<ul class="sideFilterOptions">
<? for ($i = 0 ; $i < count($type_data) ; $i++)
			{
?>
		<li><a href="/search?q=<?= $q ?>&t=<?= $type_data[$i]['video_type_id']?>&s=<?= $s ?>&ob=<?= $ob ?>"><?= $type_data[$i]['video_type'] ?> (<?= $type_data[$i]['vCount'] ?>) </a></li>

<?		}   ?>


	</ul>	
	
	<div style="height: 20px"></div>
	
	<div class="sideHeader" id="name">
		SOURCE:
	</div>
	<ul class="sideFilterOptions">
<? for ($i = 0 ; $i < count($source_data) ; $i++)
			{
?>
		<li><a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $source_data[$i]['show_id']?>&ob=<?= $ob ?>"><?= $source_data[$i]['title'] ?> (<?= $source_data[$i]['vCount'] ?>) </a></li>
<?		}   ?>
	</ul>	
	
</div>

</div>


<div class="two-column-right">
	<div class="header-big">
		video results <? if ($q ) { ?> for '<?= $q ?>' <? }?><span class="small-detail">displaying <?= $o+1 ?> - <?= $o+$c ?> of <?= $vTotal ?> </span>
	</div>


<div style="padding: 5px; border-bottom: 1px solid #666; height: 30px">
	<div style="float:left">sort: 
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=rank-DESC">rank</a> | 
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_pub-DESC">date</a> |
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.title">title</a> 		
		
	</div>
	<div style="float:right">  
		<? if ($o > 1 ) { ?>
			<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
		
		</div>
	
</div>

<div class="indent-column">

<br clear="all"/>
	
<? 		for ($i = 0 ; $i < count($results_data) ; $i++)
			{
?>

	<div class="result-item" >
		<img class="img_left" src="<?= $results_data[$i]['thumb']  ?>"/>
		<a href="/videos/detail/<?= $results_data[$i]['video_id'] ?>"><?= stripslashes($results_data[$i]['title']) ?></a><br/>
			
		<?= $results_data[$i]['date_pub'] ?>  - <?= stripslashes(substr(strip_tags($results_data[$i]['detail']), 0, 120)) ?> 
		
	</div>

<?		}    ?>
	
	

</div>



</div>
<? } ?>
</div>
