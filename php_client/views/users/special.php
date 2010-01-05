<link rel="stylesheet" href="/static/css/v2/feed_view.css" type="text/css" media="screen"  charset="utf-8">

<div style="height:20px"></div>	

<div  class="two-column-left-switch ">

	
<div class="header-big">
		Olympics Video Ticker
				<div style="position:absolute; right: 0px; top: 13px; font-size: 11px; color: #666; font-weight: normal;">
					last updated  <span style="color: #000; font-size: 13px; font-weight: bold; background: #eeeefe;"><?= get_pretty_date( $data[0]['latest_date']) ?></span>
				</div>	
	</div>



<?

for ($i=0; $i < count($data) ; $i++) 
{
	
?>

		<div id="blogEntry">
			<div id="blogEntryImg" onclick="window.location.href = '/shows/detail/<?= $data[$i]['show_id']  ?>'" >
				<img src="<?= $data[$i]['thumb']  ?>">
				<div class="blogEntryContentCount">
					
					<? if ($data[$i]['new_clips'] != 0) {?><strong><?= $data[$i]['new_clips'] ?></strong> New Clips <br/><? } ?>
					<? if ($data[$i]['new_episodes'] != 0) {?><strong><?= $data[$i]['new_episodes'] ?></strong> New Videos <br/><? } ?>
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


	
</div>


<style type="text/css" media="screen">
	.small-table
	{
		width: 100%;
		border-collapse: collapse;
	}
	.small-table th
	{
		padding-bottom: 4px; 
		border-bottom: 1px solid #ccc;
	}	
	
	.small-table tr td
	{
		text-align: center;
		padding-bottom: 4px; 
		padding-top: 4px; 
		border-bottom: 1px solid #ddd;

	}	
</style>

<div style="float:right; width: 220px; background: #eee; border: 1px solid #ccc; padding: 10px; margin-bottom: 20px">
<h3 style="padding-top: 5px; border-bottom: 1px solid #ccc; margin-bottom: 15px">Olympic Medal Count</h3>
<table class="small-table">
<thead>
	<th>Country</th>
	<th>gold</th>
	<th>silver</th>	
	<th>bronze</th>
	<th>total</th>	
</thead>
<tbody>
<?
$_medals_url = "http://syndication.nbcolympics.com/medals/index.xml";
$medal_feed = simplexml_load_file($_medals_url);

$i=0;
foreach ($medal_feed->medalssummary->country as $item) { ?>
<tr>
	<td style="text-align:left" ><?= $item['noc'] ?></td>
	<td><?= $item['totalgold'] ?></td>
	<td><?= $item['totalsilver'] ?></td>
	<td><?= $item['totalbronze'] ?></td>
	<td><?= $item['totalmedals'] ?></td>
</tr>
<?
$i++; if ($i> 4) break;
 } ?>

</tbody>
</table>
<div style="float:right; padding-top:5px">
	<a href="http://www.nbcolympics.com/medals/2008standings/index.html" target="_new" style="text-decoration:none; font-size: 10px;">complete medal standings</a>
</div>
</div>


<div style="float:right; width: 220px; background: #eee; border: 1px solid #ccc; padding: 10px">
	
	<h3 style="padding-top: 0px; border-bottom: 1px solid #ccc; margin-bottom: 20px">Latest Olympic News</h3>
	
<? foreach ($news_feed->channel->item as $item) { ?>
	<div style="padding-bottom: 5px; border-bottom: 1px solid #ccc; margin-bottom: 8px">
	<a style="text-decoration: none;" href="<?=  $item->link ?>" target="_new"><?=  $item->title ?></a> - 
	<span style="font-size: 9px; color: #999"><?= substr( strip_tags($item->description), 0,86) ?>...</span>
	</div>
	 
	
<? } ?>
</div>


<br clear="both" />
<div style="height:20px"></div>	
<div style="margin-left: 150px">
<a  href="/shows/special_shows" style="font-size: 14pt; font-weight: bold; text-decoration:none">
					See All Olympic Shows &raquo;</a>
</div>
	

