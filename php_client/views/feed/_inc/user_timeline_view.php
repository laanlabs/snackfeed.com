<?


/*

 subject: 
  - the entity doing the posting, watching, liking, or commenting?

 content:
  - the thing being watched, liked, posted, etc.

 location:
	- where it was posted, like a channel or something.
	

*/



$use_thumbs = Prefs::get("feed_view") == "thumbs" ? true : false;
$total_item_count = 0;
$temp_date;

for ($i=0; $i < count($data); $i++) 
{
	
	$data[$i]['new_content'] = $data[$i]['new_content'] == "1" ? "a" : $data[$i]['new_content'];
	
	$item_icon_class = $data[$i]['content_type'];
	
	if ( $data[$i]['content_source'] == 'favorite_videos' ) {
		
		$subject_title = $data[$i]['subject_title'];
		$subject_link = "/shows/detail/".$data[$i]['subject_id'];
		$content_word = ( $data[$i]['content_type'] ).($data[$i]['new_content'] > 1 ? "s" : "");
		$action_words = " posted ". $data[$i]['new_content']." ".$content_word;
		//" in his <a href=\"#\">channel</a>";
		$location_words = "";
		
	} else if ( $data[$i]['content_source'] == 'status_updates' ) {
		
		$subject_title = ($data[$i]['subject_title'] == User::$username ) ? "You" : $data[$i]['subject_title'] ;
		//$subject_link = "/users/profile/".$data[$i]['subject_id'];
		$subject_link = "/feed?uid=".$data[$i]['subject_id'];
		
		
		// the 'content_type' was used by me for 'clip' , 'episode' or 'status' -- to choose an icon on the left
		// side of the item, but now if we have shows in there, a show as content can also be a status item.
		
		if ( $data[$i]['content_type_specific'] == "1" )
		$content_word = "show";
		else
		$content_word = ( "video" ).($data[$i]['new_content'] > 1 ? "s" : "");
		
		
		$action_image = "";
		
		if ( $data[$i]['action_id'] == "2" ) {
			
			$action_image = "<img src='/static/images/icons/feed_like_icon.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
			
			 if ( $data[$i]['action_icon'] == "1" ) {
				$action_image = "<img src='/static/images/v3/emoticons/despair.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
			} 	else 	if ( $data[$i]['action_icon'] == "2" ) {
						$action_image = "<img src='/static/images/v3/emoticons/wtf.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
					} 	else 	if ( $data[$i]['action_icon'] == "3" ) {
								$action_image = "<img src='/static/images/v3/emoticons/weird.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
							} 	else 	if ( $data[$i]['action_icon'] == "4" ) {
											$action_image = "<img src='/static/images/v3/emoticons/laughing.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
										}
			
			$action_words = " <span style='font-weight: normal; color: #222222; background: #FFFbe9; padding: 1px 4px 1px 4px;'>".$action_image .$data[$i]['action_word']."</span> ". $data[$i]['new_content']." ".$content_word;
			
		} else if ( $data[$i]['action_id'] == "5" ) {
			$item_icon_class = "message";
			$action_words = " <span style='font-weight: normal; color: #222222; background: #FFdbd9; padding: 1px 4px 1px 4px;'>".$action_image .$data[$i]['action_word']."</span> ". $data[$i]['new_content']." ".$content_word;
			
		}	else if ( $data[$i]['action_id'] == "4" ) {
				// recommended??
				$item_icon_class = "system";
				$action_words = " <span style='font-weight: normal; color: #222222; background: #d6f4dd; padding: 1px 4px 1px 4px;'>".$action_image .$data[$i]['action_word']."</span> ". $data[$i]['new_content']." ".$content_word;
				
		} 	else if ( $data[$i]['action_id'] == "3" ) {
						// following ??
						$action_image = "<img src='/static/images/icons/feed_like_icon.png' style='position:relative; top: 2px; padding-right: 6px; margin-left: 2px;'>";
						$action_words = " <span style='font-weight: normal; color: #222222; background: #FFFbe9; padding: 1px 4px 1px 4px;'>".$action_image .$data[$i]['action_word']."</span> ". $data[$i]['new_content']." ".$content_word;

		}	
		
		else {
				$action_words = " " .$data[$i]['action_word']." ". $data[$i]['new_content']." ".$content_word;
		} 
		
		
		//" in his <a href=\"#\">channel</a>";
		
		if ( $data[$i]['location_title'] ) {
			
			if ( $data[$i]['action_id'] == "5" ) {
				$location_link = "/feed?uid=".$data[$i]['location_id'];
				$location_words = " by <a href='".$location_link ."'>". $data[$i]['location_title']."</a>";
		  } else {
				$location_link = $data[$i]['location_type'] == "1" ? "/channels/detail/".$data[$i]['location_id'] : "#";
				$location_words = " to <a href='".$location_link ."'>". $data[$i]['location_title']."</a>";
			} 
		
		} else {
			$location_words = "";
		}
		
		
		
	
	} else if ( $data[$i]['content_source'] == 'channel_videos' ) {
		
		$subject_title = $data[$i]['subject_title'];
		$subject_link = "/channels/detail/".$data[$i]['subject_id'];
		$content_word = ( $data[$i]['content_type'] ).($data[$i]['new_content'] > 1 ? "s" : "");
		$action_words = " channel added ". $data[$i]['new_content']." ".$content_word;
		//" in his <a href=\"#\">channel</a>";
		$location_words = "";
		
	}
	
		$unix_time = strtotime( $data[$i]['date_added'] );
		$sec_in_day = 24*60*60;
		$print_day = false;
		//echo "Now: ".time();
		//echo "<br/>";
		//echo "secs in a day: " . $sec_in_day;
		//echo "<br/>";
		//echo "date_Added: " . $unix_time;
		//die();
			
		 if ( $unix_time > (time()-$sec_in_day) ) 
		 {
		 	//echo "today";	
		 } else if (( $unix_time > (time()-$sec_in_day*2)) && ( $unix_time < (time()-$sec_in_day)) ) {
			
			if ( $temp_date != "Yesterday" ) {
				$temp_date = "Yesterday";
				$print_day = true;
			}
			
		 } else if ( $unix_time < (time()-$sec_in_day*2) ) {
				
				if ( $temp_date != date("M d" , $unix_time ) ) {
					$temp_date = date("M d" , $unix_time );
					$print_day = true;
				}
				
			
		}
		
		if ( $print_day && $i != 0 ) {
			?>


			<div style="width: 100%; height: 10px; margin: 12px 10px 30px 5px; border-bottom: 1px solid #bbbbbb;">
				
				<div class="feed-date-more">
					<?= $temp_date ?>
				</div>
			
			</div>
					<?
					
		}
		
		?>



<div class="feed-item">
	
	<div class="feed-icon feed-<?=  $item_icon_class  ?>">
		
	</div>
	
	<div class="feed-container">
		
		<!-- summary -->
		<div class="feed-title">
			<a class="title-link <?= $data[$i]['content_source'] ?>" uid="<?= $data[$i]['subject_id'] ?>" href="<?= $subject_link ?>"><?= $subject_title ?></a><?= $action_words ?><?= $location_words ?>.
			<!-- <?= $data[$i]['action_icon'] ?> -->
		</div>
		
		<!-- entries -->
		<?
		
		if ( $subject_title != "You" && $data[$i]['content_source'] == 'status_updates' )
			$user_referrer_link = "&u=".$subject_title;
		else if ( $data[$i]['action_id'] == "5" ) {
			$user_referrer_link = "&u=".$data[$i]['location_title'];
		} else {
			$user_referrer_link = "";
		}
		
		for ($j=0; $j < count( $data[$i]['children'] ); $j++) 
		{
			
			$total_item_count++;
			
			$current_item = $data[$i]['children'][$j];
			$item_title = $current_item['title'];
			$item_detail = $current_item['detail'];
			
			
			if ( $data[$i]['content_type_specific'] == "1" )
			$item_link = "/shows/detail/".$current_item['video_id'];
		  else
			$item_link = "/videos/detail/".$current_item['video_id']."?_s=u".$user_referrer_link;
			
			
			$item_date = $current_item['date'] ? get_pretty_date( $current_item['date'] ) : "";
			//$item_date = $current_item['date'];
			//$item_date = "heyhey";
			
			//echo $current_item['date'];
			//echo "--".strtotime( $current_item['date'] );
			
		?>
		
		<div style="<? if ($use_thumbs) { ?>clear: right;  min-height: 80px; <?}?> " >
			<? if ($use_thumbs) { ?>
				
				<div style="overflow: hidden; float: right;  width: 82px; height: 80px;">
					<a href="<?= $item_link ?>">
						<img style="height:60px;border: 1px solid #ccc" src="<?= $current_item['thumb'] ?>">
					</a>
				</div>
				
			<? } ?>
				
				<div style="<? if ($use_thumbs) { ?>margin-right: 85px;  <?}?>" class="feed-body-item">
			
						<div class="item-title" style="<? if ( 0 && $use_thumbs) { ?>background: #eeeeee; min-height: 60px; <?}?>"> 
							<a href="<?= $item_link ?>" class="video-link" uid="<?= $current_item['video_id'] ?>">
								<?= $item_title ?>
							</a>&nbsp;&nbsp;<?= $item_detail  ?>
							
						</div>
			
						<div class="item-info">
							<div style='background: #f9f9f9; width: 120px; float:left;'><?= $item_date ?></div>
							<!--<a href="#">Add to Queue </a> <a href="#"> More from <?= $subject_title ?> </a>-->
							<a style="margin-left: 15px; text-decoration:none; color: #aaaaaa; font-size: 12px"
							href="javascript:sf.addPlay('add_video_<?= ($total_item_count)
							?>','/videos/playlist_add/?video_id=<?= $current_item['video_id']
							?>')" id="add_video_<?= ($total_item_count) ?>" ><span style='font-weight: bold; color:#89b999;'>+</span> playlist</a>
							
						</div>
						
						<? if ( ( $data[$i]['action_id'] == "5" || $data[$i]['action_id'] == "2" ) && $current_item['message'] != "" ){ ?>
						<div class="item-comment">
							<?= $current_item['message'] ?>
						</div>
						<?}?>
						
				</div>
		
		</div>
		
		<!-- 
		<div class="feed-body-item">
			<div class="item-title"> Video - <a href="#">The new iphone </a></div>
			<div class="item-info"> 2 hours ago <a href="#"> Add to Queue </a> </div>
		</div>
		
	-->
		
		
		<?
			}
		
			if ( $data[$i]['extra_children'] > 0 ) {
				?>
					
		
					<div class="feed-body-item">
						<div class="item-info"><a class="more" href="<?= $data[$i]['extra_children_link'] ?>"><?= $data[$i]['extra_children'] ?> more <?= $content_word ?> </a></div>
					</div>
		
		
				<?
			}
		
		?>
		
		
		
	</div>
		
</div>





		
		<?
		
}	







?>