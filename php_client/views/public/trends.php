<style type="text/css" media="screen">
	.vid-thumb {
	float:left;
	width: 130px;	
	position: relative;
	z-index: 1;
	}
	

	
	.vid-detail {
		position: absolute;
		top: 70px;
		color: #555;
		width: 300px;
		padding: 5px; 
		border: 1px solid #555;
		background: #eee;
		z-index: 1000;
		
	
	}
	
	.trend-title {
		padding-top: 2px;
		padding-bottom: 10px;
		margin-bottom: 5px;
		border-bottom: 1px solid #ccc;
		font-size: 22px;
		
	}
	
	.trend-title-sub {
		padding-bottom: 10px;	
		color: #999;
	}
	
	.trend-no {
		font-size: 36px;
	}
	
</style>

<div id="main-content" style=" float: left" >

<div id="name">
	<div style="float:left; font-size: 26px; padding-top: 8px; padding-left: 4px; font-weight: bold">
		Top 20 Google Web Trends
	</div>
	<div style="float:right; font-size: 18px; padding-top: 14px; padding-right: 4px; color: #ccc">
		as of <?=  get_pretty_date($videos_data[0]['date_updated']) ?>
	</div>
	<br clear="both" />
</div>


<div id="public-feed-holder" style="margin-top: 10px">


	<?  

	
	$_order_by = 0 ;
		for ($i=0; $i < count($videos_data) ; $i++) {  
		if ( $videos_data[$i]['order_by'] >= $_order_by  ) {
			
			$item_title_dashes = preg_replace('/\W/', '-', $videos_data[$i]['title']);
		
			if ($videos_data[$i]['video_type'] == 2 ) {
				$_link = "/videos/ext/" .$videos_data[$i]['ext_id'] . "/" . $item_title_dashes . "?t=yt";
				
				
			} else {
				$_link = "/videos/detail/" .$videos_data[$i]['video_id'] . "/" . $item_title_dashes;
			}
		
			$_title = stripslashes($videos_data[$i]['title']);
			$_tip = $videos_data[$i]['trend_id'] . "_" . $videos_data[$i]['video_id'] . "_" . $videos_data[$i]['ext_id'];
		
		?>
	
		
		
		
	<? if  ( $_trend_id != $videos_data[$i]['trend_id']) {
		$_order_by = $videos_data[$i]['order_by']; 
		$_thumb_count = 0;  ?>		
	<br clear="both" />
	<? if  ( $i > 0 ) {?>
		<div style="height: 30px"></div>
	<? } ?>		
	
	<div id="name">
		<div class="trend-title">
			<span class="trend-no"><?= $videos_data[$i]['order_by'] ?>.</span> <?= $videos_data[$i]['trend_title'] ?>
		</div>
		<div class="trend-title-sub">
			<?= $videos_data[$i]['trend_detail'] ?> <?= $videos_data[$i]['source'] ?> 
		</div>	
		
		<? if  ( $videos_data[$i]['vCount'] > 0 ) {?>
		<div class="vid-thumb">
			<a href="<?= $_link ?>"  onmouseover="showDivTip('<?= $_tip ?>')" onmouseout="hideTip('<?= $_tip ?>')"><img class="feed-item-thumb-img" src="<?= $videos_data[$i]['thumb']?>"></a>
			<div class="vid-detail" id="<?= $_tip ?>" style="display:none;">
				<?= $_title?> - <?= substr(htmlspecialchars(stripslashes($videos_data[$i]['detail'])), 0 ,100) ?>
			</div>
		</div>
		<? } else { ?>
			<div id="name" style="color: #999">
				sorry no videos found for this trend <em>yet</em> - search <a href="http://www.google.com/search?q=<?= $videos_data[$i]['trend_title'] ?>" target="_new">google</a>.
			</div>
		<? } ?>			
			
	</div>	
	<? } else { 
		if ($_thumb_count < 4 ){?>
		<div class="vid-thumb" >
			<a href="<?= $_link ?>" onmouseover="showDivTip('<?= $_tip ?>')" onmouseout="hideTip('<?= $_tip ?>')"><img class="feed-item-thumb-img" src="<?= $videos_data[$i]['thumb']?>"></a>
			<div class="vid-detail" id="<?= $_tip ?>" style="display:none;">
				<?= $_title?> - <?= substr(htmlspecialchars(stripslashes($videos_data[$i]['detail'])), 0 ,100) ?>
			</div>
		</div>
		
	<?  }
		$_thumb_count++;
	
		}	
		$_trend_id = $videos_data[$i]['trend_id'];
	
		}
		
		} ?>


	
</div>



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
					
					<div class="column-box-item">
						<img class="icon-offset" src="/static/images/icons/feed_status_icon.png"> 
						<a href="/public/keywords/today">Our Video Index</a>
					</div>
					
				</div>
		
	<? include '_inc/footer.php'; ?>	

		
		
	</div>

<script type="text/javascript" charset="utf-8">
	function showDivTip(id)
	{
		$(id).show();
	}
	
	function hideTip(id)
	{
		$(id).hide();
	}
	
</script>


