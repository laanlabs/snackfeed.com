<div style="padding-top:70px"></div>

<link rel="stylesheet" href="/static/css/v2/tabs.css" type="text/css" media="screen"  charset="utf-8">

<?

	${"tab_" . $favorite_type} = "tab-selected";

?>


<div class="header-tabs">
	<ul class="sub-tabs">
			<li><a class="<?= $tab_shows ?>" href="/users/profile/<?= $_user_id ?>?t=shows">shows following</a></li>
			<li><a class="<?= $tab_following ?>" href="/users/profile/<?= $_user_id ?>?t=following">people following</a></li>
			<li><a class="<?= $tab_followers ?>" href="/users/profile/<?= $_user_id ?>?t=followers">followers</a></li>
			<li><a class="<?= $tab_videos ?>" href="/users/profile/<?= $_user_id ?>?t=videos">videos liked</a></li>
			<li><a class="<?= $tab_channels ?>" href="/users/profile/<?= $_user_id ?>?t=channels">channels</a></li>
	</ul>	
</div>

<br clear="both" />





<div  class="two-column-left-switch ">
	




	<? 		
	if ($favorite_type == 'channels') { ?>


		<div class="header-big">
			channels <? if ($_user_id == User::$user_id){ ?>you are <? }else{ ?>they are <? } ?> following
		</div>

		<div class="indent-column">


	<br clear="all"/>

	<? if (count($user_channels) == 0) {?>
	<div class="indent-column"  >
		<h3 class="h3-header">no favorite channels <? if ($_user_id == User::$user_id){ ?>you are <? }else{ ?><?= $user_data['nickname'] ?> is<? } ?> following</h3>

</div>

	<? } ?>	


	<? for ($i = 0 ; $i < count($user_channels) ; $i++) { ?>

		<div class="result-item-big" >
			<img class="img-left-big" src="<?= $user_channels[$i]['thumb']  ?>"/>
			<a href="/channels/detail/<?= $user_channels[$i]['channel_id'] ?>"><?= stripslashes($user_channels[$i]['title']) ?></a><br/>

			<?= stripslashes(substr(strip_tags($user_channels[$i]['detail']), 0, 120)) ?> 

				<? if ($_user_id == User::$user_id){ ?>
					<? if ( $user_channels[$i]['role'] == 100  ) { ?>	
					<br/>	
					[<a href="/channels/edit/<?= $user_channels[$i]['channel_id'] ?>">edit this channel</a>]
				<? } ?>	
				<div class="item-actions">
					<a href="/users/profile/<?= $_user_id ?>?t=channels&rem_channel_id=<?= $user_channels[$i]['channel_id'] ?>">un-follow</a>
				</div>
				<? } ?>

	</div>

	<?		}   } ?>


	
<? 		
if ($favorite_type == 'shows') { ?>
	
	
	<div class="header-big">
		<span style="margin-right: 30px;">shows <? if ($_user_id == User::$user_id){ ?>you are <? }else{ ?>they are <? } ?> following
		</span>
		
		<? if ($_user_id == User::$user_id ) { ?> 
			
				<a href="/shows" style="font-size: 11pt; font-weight: normal;">
					Find more
				</a>	
			
		<? } ?>
			
	</div>
	
	<div class="indent-column">
		

<br clear="all"/>
	
<? if (count($data['shows']) == 0) {?>
	<div class="indent-column"  >
	<h3 class="h3-header">no favorite shows <? if ($_user_id == User::$user_id){ ?>you are <? }else{ ?><?= $user_data['nickname'] ?> is<? } ?> following</h3>

use this
	<a href="/users/packages">wizzard</a> (well actually a form) to quickly add some shows by category -- or just go <a href="/shows">browse</a> around.
</div>
<? } ?>	
	
	
<? for ($i = 0 ; $i < count($data['shows']) ; $i++) { ?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $data['shows'][$i]['thumb']  ?>"/>
		<a href="/shows/detail/<?= $data['shows'][$i]['show_id'] ?>"><?= stripslashes($data['shows'][$i]['title']) ?></a><br/>
			
		<?= stripslashes(substr(strip_tags($data['shows'][$i]['detail']), 0, 120)) ?> 
		
			<? if ($_user_id == User::$user_id){ ?>
			<div class="item-actions">
				<a href="/users/profile/<?= $_user_id ?>?&t=shows&rem_show_id=<?= $data['shows'][$i]['show_id'] ?>">un-follow</a>
			</div>
			<? } ?>
		
	</div>

<?		}   } ?>
	
	

<? 	if ($favorite_type == 'videos') { ?>
	
	
	<div class="header-big">
		videos <? if ($_user_id == User::$user_id){ ?>you are <? }else{ ?>they are <? } ?> following
	</div>
	
	<div class="indent-column">
	
<? if (count($data) == 0) {?>
<div class="indent-column"  >
<h3 class="h3-header"> no videos <?= $_call ?> following</h3>
its always a good time to go 
<a href="/search">find some</a> ... 
</div>


<? } ?>	

	
	
<? for ($i = 0 ; $i < count($data) ; $i++) { ?>

	<div class="result-item" >
		<img class="img_left" src="<?= $data[$i]['thumb']  ?>"/>
		<a href="/videos/detail/<?= $data[$i]['video_id'] ?>"><?= stripslashes($data[$i]['title']) ?></a><br/>
			
		<?= stripslashes(substr(strip_tags($data[$i]['detail']), 0, 120)) ?> 
		
			
		<? if ($_user_id == User::$user_id){ ?>
			<div class="item-actions">
				<a href="/users/profile/<?= $_user_id ?>?&t=videos&rem_video_id=<?= $data[$i]['video_id'] ?>">unfollow</a>
			</div>
		<? } ?>
	</div>

<?		}   } ?>					



<? 	if ($favorite_type == 'followers') { ?>
	
	<div class="header-big">
		people following <? if ($_user_id == User::$user_id){ ?>you <? }else{ ?>this user <? } ?> 
	</div>
	
	<div class="indent-column">
	
	
<? if (count($data) == 0) {?>
<div class="indent-column"  >
<h3 class="h3-header"> no one following</h3>
</div>


<? } ?>	

	
	
<? for ($i = 0 ; $i < count($data) ; $i++) { ?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $data[$i]['thumb']  ?>"/>
		<a href="/users/profile/<?= $data[$i]['user_id'] ?>"><?= stripslashes($data[$i]['nickname']) ?></a><br/>
			
			<? if (!empty($data[$i]['location'] )) { ?><?= $data[$i]['location'] ?><br/><? } ?>
			<? if (!empty($data[$i]['bio'] )) {?><?= $data[$i]['bio'] ?><br/><? } ?>
			<? if (!empty($data[$i]['url'] )) {?><a href="<?= $data[$i]['url'] ?>"><?= $data[$i]['url'] ?></a><br/><? } ?>
		

	</div>

<?		}   } ?>	




<? 	if ($favorite_type == 'following') { ?>
	
	<div class="header-big">
		people <? if ($_user_id == User::$user_id){ ?>you are<? }else{ ?>this user is<? } ?> following
		
				<? if ($_user_id == User::$user_id ) { ?> 
			
				<a href="/users" style="font-size: 11pt; font-weight: normal;">
					Find more
				</a>	
			
		<? } ?>
	</div>
	
	<div class="indent-column">
	
	
<? if (count($data) == 0) {?>
<div class="indent-column"  >
<h3 class="h3-header"> not following anyone</h3>

</div>


<? } ?>	

	
	
<? for ($i = 0 ; $i < count($data) ; $i++) { ?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $data[$i]['thumb']  ?>"/>
		<a href="/users/profile/<?= $data[$i]['user_id'] ?>"><?= stripslashes($data[$i]['nickname']) ?></a><br/>
			
			<? if (!empty($data[$i]['location'] )) { ?><?= $data[$i]['location'] ?><br/><? } ?>
			<? if (!empty($data[$i]['bio'] )) {?><?= $data[$i]['bio'] ?><br/><? } ?>
			<? if (!empty($data[$i]['url'] )) {?><a href="<?= $data[$i]['url'] ?>"><?= $data[$i]['url'] ?></a><br/><? } ?>
		
			
		<? if ($_user_id == User::$user_id){ ?>
			<div class="item-actions">
				<a href="/users/profile/<?= $_user_id ?>?t=following&rem_user_id=<?= $data[$i]['user_id'] ?>">unfollow</a>
			</div>
		<? } ?>
	</div>

<?		}   } ?>


		
		
	</div>
	
	
	
	
</div>

<div class="side-bar">
	
	<div class="section-header">
<h1><? if ($_user_id == User::$user_id){ ?>you <? }else{ ?>user's profile<? } ?> </h1>
	
			
			<div class="item-header"><a href=""><?= $user_data['nickname'] ?></a></div>
			<div class="item-image">
				<a href=""><img src="<?= $user_data['thumb'] ?>" width="145" height="80" alt="" /></a>
			</div>
			<div style="text-align:left">
				
			<? if ($_user_id == User::$user_id){ ?>
			<div style="padding-top: 3px; padding-bottom: 5px">
				<a style="color: #000000; font-size: 11px; font-weight: normal;" href="/users/images">change your picture</a>
				| <a style="color: #000000; font-size: 11px; font-weight: normal;" href="/users/edit">edit profile</a>
			</div>
			<? } ?>
			
			<br/>
			
			<? if ($_user_id != User::$user_id){ ?><a href="/users/follow/<?= $user_data['user_id'] ?>?_r=<?= urlencode($_SERVER['REQUEST_URI']) ?>">follow this person</a><br/><? } ?>
			<? if (!empty($user_data['location'] )) { ?><?= $user_data['location'] ?><br/><? } ?>
			<? if (!empty($user_data['bio'] )) {?><?= $user_data['bio'] ?><br/><? } ?>
			<? if (!empty($user_data['url'] )) {?><a href="<?= $user_data['url'] ?>"><?= $user_data['url'] ?></a><br/><? } ?>

</div>

<div style="height: 15px"></div>


<? if ($_user_id == User::$user_id){ ?>	
<div class="section-header">
<h1>Advanced Options</h1>
<ul class="ul-simple">
	<li><a href="/users/editRoom">channel edit room</a></li>
	<li><a href="/channels/edit">create channel</a></li>
</ul>

</div>
<? } ?>			
			
</div>

</div>