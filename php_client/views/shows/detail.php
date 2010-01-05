

<div id="main-content" >


<div id="show-info-header">
	
	
	<!-- thumb -->
	<div class="show-info-thumb">
			<div class="show-info-thumb-div">
			<img class="show-info-thumb-img" src="<?= $shows_data[0]['thumb']  ?>" /></div>
	</div>
	
	
	<div id="show-info-meta-container">
		
		<div class="show-info-title">
				<a class="show-info-title-a" href="/videos/detail/<?= $videos_data[$i]['video_id']?>/<?= $item_title_dashes ?>?_s=f"><?= stripslashes($shows_data[0]['title']) ?></a> 
				<? if (User::$user_su == '1') { ?>[<a href="http://a.snackfeed.com/?a=shows.getVideos&show_id=<?= $shows_data[0]['show_id']  ?>" target="_new">cron</a>]<? } ?>	
		</div>
		
		<div id="show-info-description">
			<?= stripslashes($shows_data[0]['detail']) ?>
		</div>
		

		<?
			if (!$following){
				$_link = "javascript:sf.update('follow_link','/users/save_show_to_favorites?user_id=" . User::$user_id . "&show_id={$shows_data[0]['show_id']}&plain=1')";
				$_text = "TRACK THIS SHOW";
				$_btn_id = "follow_link";
			} else {
				$_link = "javascript:sf.update('unfollow_link','/users/remove_show_from_favorites?user_id=" . User::$user_id . "&show_id={$shows_data[0]['show_id']}&plain=1')";
				$_text = "STOP TRACKING THIS SHOW";
				$_btn_id = "unfollow_link";
			}
			render_partial("small_button", array("text" => $_text, "id" => $_btn_id, "link" => $_link) );
		?>
		
			
	</div>
		
</div>



<div id="show-info-tabs">
	
	<div class="nav-tabs">
	<ul>
<?
	${"tab_" . $_v} = "selected";
	if ($_tabs == 1 ){

?>
		<li id="watch-nav-next" class="<?= $tab_episodes ?>" ><a  href="/shows/detail/<?= $id ?>" class="nav-item-watch nav-item-left" >episodes</a>
			<div class="nav-tabs-trim" ></div>
		</li>
		<li id="watch-nav-show" class="<?= $tab_clips ?>"><a href="/shows/detail/<?= $id ?>?_v=clips" class="nav-item-watch" >clips</a>
			<div class="nav-tabs-trim" ></div></li>
<? } else { ?>			
		<li id="watch-nav-show" class="<?= $tab_videos ?> "><a href="/shows/detail/<?= $id ?>" class="nav-item-watch nav-item-left" >videos</a>
			<div class="nav-tabs-trim" ></div></li>

<? } ?>		
		<!-- <li id="watch-nav-related" class="<?= $tab_activity ?>"><a href="/shows/detail/<?= $id ?>?_v=activity" class="nav-item-watch" >activity</a> -->
			<div class="nav-tabs-trim" ></div></li>
		<li id="watch-nav-related" class="<?= $tab_search ?>"><a href="/shows/detail/<?= $id ?>?_v=search" class="nav-item-watch" >search</a>
			<div class="nav-tabs-trim" ></div></li>
	</ul>

<div class="item-set-nav" style="float:right; padding-right: 8px; padding-top:14px">
	<? if ($_options ) { ?>
	<span class="small-detail"><?= $o+1 ?> - <?= $d ?> of <?= $vTotal ?> </span>
		<? if ($o > 1 ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>&_v=<?= $_v ?>" >prev</a> 
		<?		}    ?>
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>&_v=<?= $_v ?>" >next</a> 
		<?		}    } ?>	
</div>

</div>
	

</div>

<div id="show-info-filters" style="font-size: 11px;">
	<? if ($_options ) { ?>
	sort: 
		<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_pub-DESC">date published</a> 		|
		<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_added-DESC">date added</a> 		|	
		<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.title">title</a>
	<?	}   ?>	 	
</div>


<ul id="show-results-holder">


	<? 
		$_s = "s";
	
		switch ($_v)
		{
			case "activity":
				echo "user activity related to show";
				break;
			case "search" :
				
				include "_inc/search.php"; 
				if (!empty($q)) include VIEWS."/feed/_inc/feed_item_renderer.php"; 
				break;
				
			default:	
			include VIEWS."/feed/_inc/feed_item_renderer.php"; 
		
			
		}
	
	
		
	
	
	
	?>

	
</ul>



</div>





	<div id="right-column"  >
		
		

		<div class="right-column-box-light" style="margin-top: 30px;">
			
			<div class="column-box-header">
				<span style="position: relative; left: 0px">Similar Shows?</span>
			</div>

<? for ($i=0; $i < count($data_related); $i++) { 

?>
			
			<div class="column-box-item">
				<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png"> 
				<a href="/shows/detail/<?= $data_related[$i]['show_id'] ?>"><?= $data_related[$i]['title'] ?></a>
			</div>
		
<? 	}?>	
			
		
		</div>
		

		<div class="right-column-box-light" style="margin-top: 30px;">
			
			<div class="column-box-header">
				<span style="position: relative; left: 0px">Show Fans</span>
			</div>

<? for ($i=0; $i < count($user_shows); $i++) { 

?>
			
			<div class="column-box-item">
				<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png"> 
				<a href="/users/profile/<?= $user_shows[$i]['user_id'] ?>"><?= $user_shows[$i]['nickname'] ?></a>
			</div>
		
<? 	}?>	
			
		
		</div>
		

		
		
	</div>




