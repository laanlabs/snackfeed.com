






<div style="padding-top: 30px">

<div class="two-column-left">
	<div class="header-big">
		show details
	</div>
	<div class="indent-column">
		
	
	<div style="height: 20px"></div>
		<strong><?= stripslashes($shows_data[0]['title']) ?></strong><br/>
	<img style="border:1px solid #000; display: block; width: 145px; height: 80px" src="<?= $shows_data[0]['thumb']  ?>"/><br/>

	<?= stripslashes($shows_data[0]['detail']) ?><br/>



<? if (User::$user_id == '0') {   ?>
	
		<div class="button-gradient-light" style="width: 145px"><a href="/users/register" >follow this show</a></div>
<? } else { ?>	
	
	<? if (!$following){ ?>
	<div class="button-gradient-light" style="width: 145px"><a href="javascript:sf.update('follow_link','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $shows_data[0]['show_id']  ?>&plain=1')" id="follow_link" >follow this show</a></div>
	<? } else { ?>
	<div class="button-gradient-light" style="width: 145px"><a href="javascript:sf.update('unfollow_link','/users/remove_show_from_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $shows_data[0]['show_id']  ?>&plain=1')" id="unfollow_link" >stop following show</a></div>
	<? } ?>
	
			<? if (User::$user_su == '1') { ?>	
	<a href="http://a.snackfeed.com/?a=shows.getVideos&show_id=<?= $shows_data[0]['show_id']  ?>" target="_new">cron</a>
			<? } ?>	
	
	<div style="height: 20px"></div>

		<div class="header-big">
			show videos
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
		<li><a href="/shows/detail/<?= $id ?>?&t=<?= $type_data[$i]['video_type_id']?>&s=<?= $s ?>&ob=<?= $ob ?>"><?= $type_data[$i]['video_type'] ?> (<?= $type_data[$i]['vCount'] ?>) </a></li>

<?		}   ?>


	</ul>
	<div style="height: 20px"></div>	
	
	
<div class="sideHeader" id="name">
		SEARCH:
	</div>
<form id="searchForm" method="get" action="/shows/detail/<?= $id ?>" name="searchForm">
			<input id="searchBox" type="search" results="10" placeholder="Enter your query" name="q" value="<?= $q ?>" />
	<a href="javascript:document.searchForm.submit();">filter</a>
</form>			
	
</div>
</div>



<div style="height: 20px"></div>

	<div class="header-big">
		people following
	</div>
	<div class="indent-column">

			<ul class="side-options" >

	<? 		for ($i = 0 ; $i < count($user_shows) ; $i++) { ?>
	
				<li><a href="/users/profile/<?= $user_shows[$i]['user_id'] ?>"><?= $user_shows[$i]['nickname'] ?></a></li>
	
	<?		}    ?>
			</ul>


	</div>
	
	<div style="height:20px"></div>
	
	<div class="header-big">
		channel options
	</div>
	<div class="indent-column">
   add this show to my channel watch list
			<ul class="side-options" >

	<? 		for ($i = 0 ; $i < count($user_channels) ; $i++) { 
				if ($user_channels[$i]['role'] > 1) {
		?>
				
				<li><a href="/channels/edit_program/?show_id=<?= $_REQUEST['id'] ?>&channel_id=<?= $user_channels[$i]['channel_id'] ?>"><?= $user_channels[$i]['title'] ?></a></li>
	
	<?		} }    ?>
			</ul>

<? } ?>	
	</div>	


	
</div>


<div class="two-column-right">
	<div class="header-big">
		results <span class="small-detail">displaying <?= $o+1 ?> - <?= $o+$c ?> of <?= $vTotal ?> </span>
	</div> 

<div style="padding: 5px; border-bottom: 1px solid #666; height: 30px">
	<div style="float:left">sort: 

		<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_pub-DESC">date published</a> |
			<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.date_added-DESC">date added</a> |	
		<a href="/shows/detail/<?= $shows_data[0]['show_id'] ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=v.title">title</a> 		
		
	</div>
	<div style="float:right">  
		<? if ($o > 1 ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
	</div>
</div>
<br clear="all"/>
	<div class="indent-column">
	
<? 		for ($i = 0 ; $i < count($videos_data) ; $i++) { ?>

		<div class="result-item" >
			<img class="img_left" src="<?= $videos_data[$i]['thumb']  ?>"/>
			<a  href="/videos/detail/<?= $videos_data[$i]['video_id'] ?>/<?= preg_replace('/\W/', '-', $videos_data[$i]['title']) ?>?u=<?= User::$username ?>"><?= htmlspecialchars(stripslashes($videos_data[$i]['title'])) ?></a><br/>
			<?= date("m-d-y",strtotime($videos_data[$i]['date_pub'])) ?>  - 
				<? if ( $videos_data[$i]['video_type_id'] == "1") { ?> FULL <? } ?> 
			 <?= htmlspecialchars(stripslashes(substr($videos_data[$i]['detail'], 0, 120))) ?>  
			
			<? if (User::$user_id != '0') { ?>
			 <div style="position:absolute; right: 0px; bottom: 3px">
			   <a style="text-decoration:none; font-weight: normal; color: #888; font-size: 12px" href="javascript:sf.addPlay('add_video_<?= $i ?>','/videos/playlist_add/?video_id=<?= $videos_data[$i]['video_id'] ?>')" id="add_video_<?= $i ?>" >+ playlist</a>	
			 </div>
			<?		}    ?>
			 
	
			 
		</div>





<?		} //END GUEST OFF   ?>
	
	



</div>

<div style="padding: 5px; margin-top: 20px; padding-top: 10px; border-top: 1px solid #666; height: 30px">

	<div style="float:right">  
		<? if ($o > 1 ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o-$c ?>" >prev</a> |
		<?		}    ?>
		
		<? if (($o+$c) < $vTotal ) { ?>
			<a href="/shows/detail/<?= $id ?>?q=<?= $q ?>&t=<?= $t ?>&s=<?= $s ?>&ob=<?= $ob ?>&o=<?= $o+$c ?>" >next</a> 
		<?		}    ?>	
	
	</div>
</div>


</div>
