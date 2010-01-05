
<div style="padding-top:70px"></div>

<div class="two-column-left">
	<div class="header-big">
		options
	</div>
	<div class="indent-column">
		
			<ul class="side-options" >
			<!-- <li><a href="/users/playlists/<?= User::$user_id ?>">default</a></li> -->
			<li><a href="/videos/detail/<?= $videos_data[0]['video_id'] ?>?pl=0&u=<?= User::$username ?>&group_id=<?= $group_id ?>">watch this playlist</a></li>
			<li><a href="/users/playlists/<?= User::$user_id ?>?rem_group_id=<?= $group_id ?>">clear this playlist</a></li>
			<? if ($group_id == '0'){ ?>
			<li><a href="#" onclick="$('playlist-save').show();">save this playlist</a></li>
			<? } ?>
		</ul>		
		
	</div>
	
	<div style="height:20px"></div>
	
	<? if (count($playlists_data) > 0 ){ ?>
		<div class="header-big">
			saved playlists
		</div>
		<div class="indent-column">
				<? if ($group_id != '0'){ ?>
			 	 <a href="/users/playlists/<?= User::$user_id ?>">&#171; back to default playlist</a>
				<? } ?>
					
				<ul class="side-options" >
			
				<? 		for ($i = 0 ; $i < count($playlists_data) ; $i++) { ?>
				<li><a href="/users/playlists/<?= User::$user_id ?>?group_id=<?= $playlists_data[$i]['group_id']  ?>"><?= $playlists_data[$i]['group_title']  ?></a></li>
				<? } ?>	


			</ul>		

		</div>
<? } ?>	
	
</div>


<div  class="two-column-right ">
	
	<div class="header-big">
		playlist: <?= $playlist_title ?>  
	</div>
	
	<div id="playlist-save" style="padding-top: 30px; border-bottom: 1px solid #ccc; margin-bottom: 20px; display:none">


	<form action="/users/playlists" method="post" accept-charset="utf-8" name="edit_form" id="edit_form">
			<input type="hidden" name="save_playlist" value="1" />
			<label for="group_title" class="nForm" >playlist name:</label> 
				<input class="nForm" type="text" name="group_title" id="group_title" value="playlist <?= count($playlists_data) +1  ?>" /><br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />	

	
			<div id="button-submit" class="button-form" ><a href="javascript:document.edit_form.submit();">create</a></div>	
			<br clear="left"/>	
		

	</form>

	</div>
	
	
	<div class="indent-column">
		

<? 		for ($i = 0 ; $i < count($videos_data) ; $i++) { ?>

		<div class="result-item" >
			<img class="img_left" src="<?= $videos_data[$i]['thumb']  ?>"/>
			<a  href="/videos/detail/<?= $videos_data[$i]['video_id'] ?>?pl=<?= $i ?>&group_id=<?= $videos_data[$i]['group_id'] ?>&u=<?= User::$username ?>"><?= stripslashes($videos_data[$i]['title']) ?></a><br/>
				<? if ( $videos_data[$i]['video_type_id'] == "1") { ?> FULL <? } ?> 
			 <?= substr($videos_data[$i]['detail'], 0, 120) ?> 
			
			
			 <div style="position:absolute; right: 0px; bottom: 3px">
			   <a style="text-decoration:none; color: #ccc; font-size: 10px" href="/users/playlists/<?= User::$user_id ?>?rem_playlist_id=<?= $videos_data[$i]['playlist_id'] ?>" >remove from playlist</a>	
			 </div>
			
			 
	
			 
		</div>

<?		}  

if (count($videos_data) == 0) {  ?>
		
	
	<h3 style="padding: 20px">sorry your playlist is empty</h3>
	
<? } ?>	
		
	</div>
	
	
	
	
</div>