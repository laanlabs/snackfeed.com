






<div style="padding-top: 30px">

<div class="two-column-left">
	<div class="header-big">
		channel details
	</div>
	<div class="indent-column">
		<a href="javascript:sf.update('follow_link','/channels/follow/<?= $data['meta']['channel_id']  ?>')" id="follow_link" >follow this channel</a><br/>
	
	<div style="height: 20px"></div>
	<img style="border:1px solid #000" src="<?= $data['meta']['thumb']  ?>"/><br/>
	<strong><?= stripslashes($data['meta']['title']) ?></strong><br/>
	<?= stripslashes($data['meta']['detail']) ?><br/>
	
	
	
	</div>

	<div style="height: 20px"></div>


<div style="height: 20px"></div>

	<div class="header-big">
		channel followers
	</div>
	<div class="indent-column">
	<div style="height: 20px"></div>
	<ul class="side-options" >
		
<? for ($i = 0 ; $i < count($channel_users) ; $i++){ ?>	
	<li><a href="/users/profile/<?= $channel_users[$i]['user_id'] ?>"><?= $channel_users[$i]['nickname'] ?></a> <?= $channel_users[$i]['channel_role_title'] ?></li>
<?  }  ?>	
	

	
	
	
	</div>



</div>


<div class="two-column-right">
	<div class="header-big">
		recent videos <span class="small-detail">a list of the last few videos in this channel </span>
	</div>


	<div class="indent-column">
	
<? 		

for ($i = 0 ; $i < count($data['videos']) ; $i++)
			{
?>

		<div class="result-item" >
			<img class="img_left" src="<?= $data['videos'][$i]['thumb']  ?>"/>
			<a  href="/videos/detail/<?= $data['videos'][$i]['video_id'] ?>"><?= stripslashes($data['videos'][$i]['title']) ?></a><br/>
			
			 <?= substr($data['videos'][$i]['detail'], 0, 120) ?> 
			 
			 
			 			 <div style="position:absolute; right: 0px; bottom: 3px">
			   <a style="text-decoration:none; color: #ccc; font-size: 10px" href="javascript:sf.addPlay('add_video_<?= $i ?>','/videos/playlist_add/?video_id=<?= $data['videos'][$i]['video_id'] ?>')" id="add_video_<?= $i ?>" >+ playlist</a>	
			 </div>
			 
		</div>

<?		}    ?>
	
	



</div>

</div>
