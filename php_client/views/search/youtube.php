<div style="padding-top:70px"></div>

<div id="search-container" >
	
<div style="padding: 5px">
	<a href="/search/" style="font-size: 17px; color: #1155ac;" >search snackfeed</a> &nbsp;|&nbsp; 
	
	<a href="/search/youtube?q=<?= $q ?>" style="text-decoration: none; font-size: 16px; font-weight: bold; " >
		<? if ($q) { ?>
		search '<span style="color: #000000;"><?= $q ?></span>' on YouTube.com
		<? } else { ?>
		search videos on YouTube.com
		<? } ?>
	</a>

</div>
	
<div id="search-wrapper" >
	<form id="search-form" method="get" action="/search/youtube" name="search_form">
		<div id="search-box">
			<input id="search-input" type="search" results="10" placeholder="what are you looking for?" name="q" value="<?= $q ?>" />
			</div>
		<div id="search-button" style="padding-top: 10px">
			<div id="button-submit" >
				<a href="javascript:document.search_form.submit();">search</a>
			</div>
		</div>
		<div id="search-advanced" style="padding-left: 20px; padding-top: 15px; text-align: left">
<a href="">Advanced Options</a>
		</div>

	</form>
</div>


<?
	if ( count($youtube_popular_videos) > 0 ) {
?>

<div style="clear: both; padding-top: 40px;">
	

	<div class="three-column">
	<div class="header-big">
		hot searches:
	</div>
	<div class="indent-column">
		<ul class="search-items">

		<?  for ($i = 0 ; $i < min(5,count($youtube_hot_searches)) ; $i++) {    ?> 
			
			<li><a  href="/videos/ext/<?= $youtube_hot_searches[$i]['video_id'] ?>?t=yt"><?= $youtube_hot_searches[$i]['title'] ?></a>
			</li>
			
		<?  } ?>
		</ul>
	</div>
	</div>
	
	<div class="three-column" style="margin-left: 25px">
	<div class="header-big">
		popular videos:
	</div>
	<div class="indent-column">
		<ul class="search-items">
		<?  for ($i = 0 ; $i < min(5,count($youtube_popular_videos)) ; $i++) {    ?> 
			
			<li><a  href="/videos/ext/<?= $youtube_popular_videos[$i]['video_id'] ?>?t=yt"><?= $youtube_popular_videos[$i]['title'] ?></a>
			</li>
			
			
		<?  } ?>
		</ul>
	</div>
	</div>
	
	<div class="three-column" style="margin-left: 25px">
	<div class="header-big">
		top rated today:
	</div>
	<div class="indent-column">
		<ul class="search-items">
		<?  for ($i = 0 ; $i < min(5,count($youtube_top_rated)) ; $i++) {    ?> 
			
			<li><a  href="/videos/ext/<?= $youtube_top_rated[$i]['video_id'] ?>?t=yt"><?= $youtube_top_rated[$i]['title'] ?></a>
			</li>
		
			
		<?  } ?>
		</ul>
	</div>
	</div>
	
</div>		
	
<?
	}
?>



<?
	if ( count($video_results) > 0 ) {

?>
<br clear="all"/>
<div style="height: 20px"></div>


	<div class="two-column-left">
	<div class="header-big">
		hot searches:
	</div>
	<div class="indent-column">
		<ul class="search-items">

		<?  for ($i = 0 ; $i < min(5,count($youtube_hot_searches)) ; $i++) {    ?> 
			
			<li><a  href="/videos/ext/<?= $youtube_hot_searches[$i]['video_id'] ?>?t=yt"><?= $youtube_hot_searches[$i]['title'] ?></a>
			</li>
			
		<?  } ?>
		</ul>
	</div>
	</div>
	
	
<div class="two-column-right">
	<div class="header-big">
		results <span class="small-detail">displaying <?= $o+1 ?> - <?= $o+$c ?> of <?= $vTotal ?> </span>
	</div>
	
<div style="padding: 5px; border-bottom: 1px solid #666; height: 30px">
	<div style="float:left">sort: 
		<a href="/search/youtube?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=viewCount">views</a> | 
		<a href="/search/youtube?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=published">date</a> |
		<a href="/search/youtube?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=relevance">relevance</a> 	
		
	</div>
	<div style="float:right">  
		<? if ($o > 1 ) { ?>
			<a href="/search/youtube?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/search/youtube?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
		
		
		</div>
	
</div>

<div class="indent-column">
	



<br clear="all" />


<? 	
		
			for ($i = 0 ; $i < count($video_results) ; $i++)
			{

			$_id = str_replace("http://www.youtube.com/watch?v=", "",   $video_results[$i]['watch_url'] );
			$date_converted = date("M-d-y", strtotime($video_results[$i]['date_pub']));


?>

<div id="name" style="padding: 5px; border-bottom: 1px solid #ccc; height: 63px;">
<img class="img_left" src="<?= $video_results[$i]['thumb']  ?>"/>
		<a style="font-weight: bold; font-size: 14px" href="/videos/ext/<?= $_id ?>?t=yt"><?= $video_results[$i]['title'] ?></a><br/>
			
		<?= $date_converted ?>  - 

		 
		<?= substr($video_results[$i]['detail'], 0, 30) ?> 
		<br/>
		
		<span style="font-size: 11px; color: #555555; font-weight: bold;"> Views: <?= $video_results[$i]['views'] ?> </span>
		
		<span style="padding-left: 50px; font-size: 11px; color: #555555; font-weight: bold;"><a style="font-size: 11px;" href="<?= $video_results[$i]['watch_url'] ?>">View at YouTube</a></span>
		
		
	</div>

<?		}    ?>


<?
	} elseif ( $q != null ){
		
		
		
		
		?> 
		
		
		<br clear="all"/>
		
		<div style="height: 90px;">
			There were no results 
		</div>
		
		<?
		
	}

?>

</div>
</div>