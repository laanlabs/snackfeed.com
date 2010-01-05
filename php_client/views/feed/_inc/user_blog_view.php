<?

for ($i=0; $i < count($data) ; $i++) 
{
	
?>

		<div id="blogEntry">
			<div id="blogEntryImg" onclick="window.location.href = '/shows/detail/<?= $data[$i]['show_id']  ?>'" >
				<img src="<?= $data[$i]['thumb']  ?>">
				<div class="blogEntryContentCount">
					
					<? if ($data[$i]['new_clips'] != 0) {?><strong><?= $data[$i]['new_clips'] ?></strong> New Clips <br/><? } ?>
					<? if ($data[$i]['new_episodes'] != 0) {?><strong><?= $data[$i]['new_episodes'] ?></strong> New Episodes <br/><? } ?>
					<strong><?= $data[$i]['date_formatted'] ?></strong><br/>
				</div>
				<div id="blogItemWatchBtn"></div>
			</div>
			
			<div id="blogEntryText">
				<a class="titleA" href="/shows/detail/<?= $data[$i]['show_id']  ?>"><?= stripslashes($data[$i]['title']) ?></a>
				<div id="blogEntryTextDesc">
					<div>
						<? for ($j=0; $j < count($data[$i]['items']) ; $j++) { ?>
						<div class="clipListDiv">
							<a href="/videos/detail/<?= $data[$i]['items'][$j]['video_id'] ?>"><img src="<?= $data[$i]['items'][$j]['thumb'] ?>"></a><a href="/videos/detail/<?= $data[$i]['items'][$j]['video_id'] ?>" class="clipTitle"><?= $data[$i]['items'][$j]['title'] ?><br></a>
							<?= $data[$i]['items'][$j]['detail'] ?>
						</div>
						<? } ?>	
					</div>
				</div>
			</div>

		</div>


<?

}

?>				