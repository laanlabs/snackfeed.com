

<div id="main-content" style=" float: left" >


<h1 style="padding:8px;">Last 100 Videos Found</h1>




<ul id="public-feed-holder">



	<?  for ($i=0; $i < count($videos_data) ; $i++) { 
		
		$item_date = "";
		$item_detail = "";
		$item_detail_extra = "";
		
		$item_date = $videos_data[$i]['date_added'] ? get_pretty_date( $videos_data[$i]['date_added'] ) : "";
		$item_detail = substr( $videos_data[$i]['detail'] , 0 , 80 );
		
		if ( strlen( $videos_data[$i]['detail'] ) > 80 ) {
		 $item_detail.="...";
		 $item_detail_extra = $videos_data[$i]['detail'];
		}
		
		
		$item_title_dashes = preg_replace('/\W/', '-', $videos_data[$i]['title']);
		
		$_title = stripslashes($videos_data[$i]['title']) ;
		if (!empty($videos_data[$i]['title_prefix'])) $_title  =  $videos_data[$i]['title_prefix'] . " - " . $_title;
		$item_title = substr( $_title, 0 , 44 );
		if ( strlen( $_title ) > 44 ) $item_title.="...";
		
		$item_comment = "";
		
		// this is determined based on whether there is a comment or not.
		$item_height = "95px";
		
		switch ( $videos_data[$i]['type'] ) {
			
		case "101":
		    $item_source_icon = "/static/images/splash/ff.png";
				$item_source_title = "Video from FriendFeed";
				$item_source_link = "/public/friendfeed";
		    break;
		
		case "102":
		    $item_source_icon = "/static/images/splash/twitter.png";
				$item_source_title = "Video from Twitter";
				$item_source_link = "/public/twitter";
		    $item_comment = $videos_data[$i]['source_detail'];
				$item_commenter = "@".$videos_data[$i]['source_title'];
				$item_commenter_link = "http://twitter.com/".$videos_data[$i]['source_title'];
				
				break;
				
		case "4":
				$item_source_icon = "/static/images/splash/cheese_small.png";
				break;
				
		default:
				$item_source_icon = "";
				$item_comment = $videos_data[$i]['comment'];
				$item_commenter = "Snackfeed";
				$item_commenter_link = "#";
				
				break;
		}
		
		if ( $item_comment ) $item_height = "105px";
		
		
		// type
		// detail
		// ts
		// date_added
		
		?>



		<li class="public-feed-item" style="min-height: <?= $item_height ?>; " >

			<div  style="width: 100%;  ">

			<!-- thumb -->
			<div class="feed-item-thumb ">

				<a href="/videos/detail/<?= $videos_data[$i]['video_id']?>/<?= $item_title_dashes ?>?_s=s">
					<div class="feed-item-thumb-div">
						<img class="feed-item-thumb-img" src="<?= $videos_data[$i]['thumb']?>">
					</div>
				</a>

			</div>


			<!-- source icon -->
			<div class="feed-item-source">
				<a alt="" title="<?= $item_source_title ?>" href="<?= $item_source_link ?>">
					
					<? if ($item_source_icon) { ?>
					<img  src="<?= $item_source_icon ?>"></a>
					<? } ?>
			</div>

			<!-- main item content -->
			<div class="feed-item-main">
				<div style="height: 21px;">
					<div class="feed-item-header">
						<a class="feed-item-header-a" href="/videos/detail/<?= $videos_data[$i]['video_id']?>/<?= $item_title_dashes ?>?_s=s"><?= $item_title ?></a>
						
					</div>
					<a href="/videos/detail/<?= $videos_data[$i]['video_id']?>/<?= $item_title_dashes ?>?_s=s" id="feed-play-button" style="float:right;"></a>


				<? if (User::$user_id != '0' ){ ?>
					<a id="add_video_<?= $videos_data[$i]['video_id']?>" href="javascript:sf.addPlayPublicFeed('add_video_<?= $videos_data[$i]['video_id']?>','/videos/playlist_add/?video_id=<?= $videos_data[$i]['video_id']?>')" class="feed-add-button" style="float:right;"></a>
					<? } ?>

				</div>

				<div class="feed-sub-title">

					<div class="feed-sub-title-detail">
						
						
						<?
							if ( $videos_data[$i]['type'] >= 100 ) {
						?>
							<?= $videos_data[$i]['comment']?>
						<?
						
							if ( $videos_data[$i]['type'] == 101 ) {
								?> on <a class="blue-link-small" href="http://friendfeed.com">FriendFeed</a>
								
								<?
							} else if ( $videos_data[$i]['type'] == 102 ) {
								?> 
									on <a class="blue-link-small" href="http://twitter.com">twitter</a>
								<?
							} 
						
					 		} else {
						
								if ( $videos_data[$i]['type'] == 4 ) {
									?> 
										Posted by the <a class="blue-link-small" href="#">Snackfeed Team</a>
									<?
								} else {
									
								?> 
								from the show
								<a class="blue-link-small" href="/shows/detail/<?= $videos_data[$i]['show_id']?>/<?=  preg_replace('/\W/', '-', $videos_data[$i]['show_title']) ?>"><?= $videos_data[$i]['show_title']?></a>
								
								<?
									
								}  
								
							} ?>
						
					</div>

					<div style="float: right;">

						<span class="feed-item-date" ><?= $item_date ?></span>

					</div>

				</div>

				<div class="feed-item-detail" >
					
					<span id="regular_description_<?= $videos_data[$i]['public_id'] ?>">
					<?= $item_detail ?>
					
					
					</span>
					
					<? if ( $item_detail_extra != "" ) { ?>
					<span style="display:none;" id="more_description_<?= $videos_data[$i]['public_id'] ?>" >
						<?= $item_detail_extra ?> 
						
					<? if (User::$user_su == '1') { ?>	
						<a href="/public/item_delete/<?= $videos_data[$i]['public_id'] ?>">del</a>
					<? } ?>
						
					</span>
					
					<span id="more_description_button_<?= $videos_data[$i]['public_id'] ?>" >
						
						<a class="blue-link-small" onclick=" $('more_description_<?= $videos_data[$i]['public_id'] ?>').show(); $('more_description_button_<?= $videos_data[$i]['public_id'] ?>').hide(); $('regular_description_<?= $videos_data[$i]['public_id'] ?>').hide(); return false " href="#"> more </a>
						
					</span>
					
					<? } ?>
					
					
	
					
				</div>

				<?
				
				if ( $item_comment ) {
				
				?>
				
				<div class="feed-comment" >
					<img style="" class="icon-offset" src="/static/images/splash/comment.png">
					<a class="blue-link" href="<?= $item_commenter_link ?>"><?= $item_commenter ?></a>: <?= $item_comment  ?>
				</div>
				
				<? } ?>

			</div>


			</div>

		</li>

		<? } ?>


	
</ul>



</div>





	<div id="right-column"  >
		
		
		
		<? if (User::$user_id == '0' ){ ?>
		
				<? include '_inc/email.php'; ?>		
		<? } ?>
		
				<div class="right-column-box-light" style="margin-top: 30px;">

					<div class="column-box-header">
						<span style="">Other Feeds</span>
					</div>

					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png">
						<a href="/public"> Snackfeed Home Feed </a>
					</div>

					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png">
						<a href="/shows">Popular Shows </a>
					</div>					

					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/splash/ff.png">
						<a href="/public/friendfeed"> Best of FriendFeed</a>
					</div>

					<div style="color: #222; padding: 9px; font-size: 13px;">
						<img class="icon-offset" src="/static/images/splash/twitter.png">
						<a href="/public/twitter"> Popular on Twitter</a>
					</div>					
					

					
				</div>
		
	<? include '_inc/footer.php'; ?>	

		
		
	</div>




