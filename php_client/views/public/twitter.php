<?

?>


<div id="main-content" style=" float: left" >
	
<h1 style="padding:8px;">popular on twitter in past 48 hours</h1>




<ul id="public-feed-holder">





	<? for ($i=0; $i < count($data) ; $i++) { 
		
		
		$item_date = $data[$i]['date_added'] ? get_pretty_date( $data[$i]['date_added'] ) : "";
		$item_detail = substr( $data[$i]['detail'] , 0 , 80 );
		if ( strlen( $data[$i]['detail'] ) > 80 ) $item_detail.="...";
		
		$item_title_dashes = preg_replace('/\W/', '-', $data[$i]['title']);
		
		$item_title = substr( $data[$i]['title'] , 0 , 44 );
		if ( strlen( $data[$i]['title'] ) > 44 ) $item_title.="...";
		
		
		
		$item_link = "http://www.snackfeed.com/videos/ext/{$data[$i]['youtube_id']}/{$item_title_dashes}?t=yt";
		
		
		$item_thumb = "http://i2.ytimg.com/vi/" . $data[$i]['youtube_id'] ."/default.jpg";
		
		$item_comment = "";
		
		// this is determined based on whether there is a comment or not.
		$item_height = "85px";
		
		$item_source_icon = "/static/images/splash/twitter.png";
		$item_source_title = "Video from Twitter";
		$item_source_link = "/public/twitter";
		
		$item_comment = $data[$i]['tweet'];
		$item_commenter = "@".$data[$i]['from_user'];
		$item_commenter_link = "http://twitter.com/".$data[$i]['from_user'];
		
		
		
		if ( $item_comment ) $item_height = "105px";
		
		
		// type
		// detail
		// ts
		// date_added
		
		?>



		<li class="public-feed-item" >

			<div  style="width: 100%; height: <?= $item_height ?>;  ">

			<!-- thumb -->
			<div class="feed-item-thumb">

				<a href="<?= $item_link ?>">
					<div class="feed-item-thumb-div">
						<img class="feed-item-thumb-img" src="<?= $item_thumb ?>">
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
						<a class="feed-item-header-a" href="<?= $item_link ?>"><?= $item_title ?></a>
					</div>

					<a href="#" id="feed-play-button" style="float:right;"></a>

		

				</div>

				<div class="feed-sub-title">

					<div class="feed-sub-title-detail">
						
						
						
									found on <a class="blue-link-small" href="http://search.twitter.com/search?q=<?= $data[$i]['youtube_id'] ?>" target="_new">
										twitter
									</a> <?= $data[$i]['count'] ?> time<?=  ($data[$i]['count'] > 1) ? ("s") : ("")  ?> via <a class="blue-link-small" href="http://youtube.com/watch?v=<?= $data[$i]['youtube_id'] ?>" target="_new">youtube</a>
						
						
					</div>

					<div style="float: right;">

						<span class="feed-item-date" ><?= $item_date ?></span>

					</div>

				</div>

				<div class="feed-item-detail" >
					<?= $item_detail ?>
				<? if (User::$user_su == '1') { ?>	
					<a href="/public/add_ext/<?= $data[$i]['youtube_id'] ?>?type=102&comment=found <?= $data[$i]['count'] ?> times&source_id=<?= $data[$i]['tw_id'] ?>&source_title=<?= $data[$i]['from_user'] ?>&source_detail=<?= htmlspecialchars($data[$i]['tweet']) ?>">add to public</a>
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







	<div id="right-column" style="" >
		
		
		<? if (User::$user_id == '0' ){ ?>
		
				<? include '_inc/email.php'; ?>		
		<? } ?>
		
		
		
		
			<div class="right-column-box-light" style="margin-top: 30px;">

				<div class="column-box-header">
					<img style="position: relative; left: -35px;" src="/static/images/splash/arrow.png">
					<span style="position: relative; left: -30px">What's in this feed?</span>
				</div>

				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/splash/twitter.png">
					<a href="/public/twitter"> Popular on Twitter</a>
				</div>



			</div>
			
			
				<div class="right-column-box-light" style="margin-top: 30px;">

					<div class="column-box-header">
						<span style="">Other Feeds</span>
					</div>

					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/splash/ff.png">
						<a href="/public/friendfeed"> Best of FriendFeed</a>
					</div>
					
					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png">
						<a href="/public"> Snackfeed Home Feed </a>
					</div>
				
				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/icons/feed_status_icon.png"> 
					<a href="/public/trends">Popular Search Trends</a>
				</div>	
								
				</div>
		
		
	<? include '_inc/footer.php'; ?>

		
		
	</div>

