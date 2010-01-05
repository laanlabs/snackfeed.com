

<div style="padding-top:70px"></div>

<div id="search-container" >
<!--	
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
-->	
<div id="search-wrapper" >
	<form id="search-form" method="get" action="/search" name="search_form">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" style="width: 300px" >
				<a href="javascript:document.search_form.submit();">search for videos</a>
			</div>
		</div>
		<!--
		<div id="search-advanced" style="padding-left: 20px; padding-top: 15px; text-align: left; font-size: 18px; color: #bbb"> or 
<a href="/shows/ls?q=<?= $q ?>" class="blue-link" style="font-size: 18px">search for shows for '<strong><?= $q ?></strong>'</a>
		</div>
		-->
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


<div style="float: left; width: 620px;">
	<div class="header-big">
		found <?= $results['total_found'] ?> results <? if ($q ) { ?> for '<?= $q ?>' <? }?><span class="small-detail"> displaying <?= $o+1 ?> - <?= $o+$c ?>  </span>
		
		<div style="text-align:right; font-size: 12px; position: absolute; right: 0px; top:8px">
		<? if ($o > 1 ) { ?>
			<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		
		<? if (($o+$c) < $results['total_found'] ) { ?>
			<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
		</div>
	</div>


<!--<div style="padding: 5px; border-bottom: 1px solid #666; height: 30px">
	<div style="float:left">sort: 
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=rank-DESC">rank</a> | 
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_pub-DESC">date</a> |
		<a href="/search?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.title">title</a> 		
		
	</div>
</div> -->

<div class="indent-column">

<br clear="all"/>
	
<? 		for ($i = 0 ; $i < count($results_data) ; $i++)
			{
?>

	<div class="result-item" >
		<img class="img_left" src="<?= $results_data[$i]['thumb']  ?>"/>
		<a href="/videos/detail/<?= $results_data[$i]['video_id'] ?>"><?= stripslashes($results_data[$i]['title']) ?></a><br/>
		FROM: <a href="/shows/detail/<?= $results_data[$i]['show_id'] ?>"><?= $results_data[$i]['show_title'] ?></a><br/>
			
		<?= $results_data[$i]['date_pub'] ?>  - <?= stripslashes(substr(strip_tags($results_data[$i]['detail']), 0, 120)) ?> 
		
	</div>

<?		}    ?>
	
	

</div>



</div>
<? } ?>
</div>


<? if (count($shows_data) > 0 ) { ?>

	<div style="margin-top: 5px;float: right; width: 280px;"  >
		
		

		<div class="right-column-box-light" style="margin-top: 30px;">
			
			<div class="column-box-header">
				<span style="position: relative; left: 0px">Looking for this Show?</span>
			</div>

<? for ($i=0; $i < count($shows_data); $i++) { 

?>
			
			<div class="column-box-item" style="padding-bottom:0px">
				<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png"> 
				<a href="/shows/detail/<?= $shows_data[$i]['show_id'] ?>"><?= $shows_data[$i]['title'] ?></a>
			</div>
		
<? 	}?>				
		
		</div>
		


		
		
	</div>

<? 	}?>	


<? 

if (count($yt_data) > 0 ) { ?>

	<div style="margin-top: 5px;float: right; width: 280px;"  >
		
		

		<div class="right-column-box-light" style="margin-top: 30px;">
			
			<div class="column-box-header">
				<span style="position: relative; left: 0px"><a href="/search/youtube?q=<?= $q ?>">Found <?= number_format($yt_total, 0, "" , ",") ?> Videos on YouTube </a></span>
			</div>


<? 	
		
			for ($i = 0 ; $i < count($yt_data) ; $i++)
			{

			$_id = str_replace("http://www.youtube.com/watch?v=", "",   $yt_data[$i]['watch_url'] );
			$date_converted = date("M-d-y", strtotime($yt_data[$i]['date_pub']));


?>
			

<div id="name" style="padding: 3px; padding-bottom: 5px; border-bottom: 1px solid #ccc; margin-left: 10px; margin-bottom: 8px; margin-top: 5px">
<img style="width: 40px; border: 1px solid #ccc; float: left; margin-right: 4px" src="<?= $yt_data[$i]['thumb']  ?>"/>
		<a style="font-weight: bold; font-size: 12px" href="/videos/ext/<?= $_id ?>?t=yt"><?= substr($yt_data[$i]['title'], 0, 40) ?></a>
		<?= substr($yt_data[$i]['detail'], 0, 60) ?> 
	</div>
		
<? 	}?>				
		
		</div>
		


		
		
	</div>

<? 	}?>	



