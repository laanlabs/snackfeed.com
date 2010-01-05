<?

$same_show_count = 0;
$last_show;

$max_to_show = 4;

function get_extra_items($start , $data2 ) {
	
	$same_item_count = 0;
	$last_item2 = $data2[$start]['show_id'];
	$start_place = $start;
	
	for ($i2=$start_place; $i < count($data2); $i2++) 
	{
		
		
		
		if ( $data2[$i2]['show_id'] != $last_item2 ) {
			
			//echo $same_item_count; die();
			return $same_item_count-1;
			
		}
		else
		$same_item_count++;
		
		
		$last_item2 = $data2[$i2]['show_id'];
	}
	
	
}


for ($i=0; $i < count($data); $i++) 
{
	
	
	$extra_items = 0;
	
	if ( $data[$i]['show_id'] != $last_show ) 
	{$same_show_count=0; }
	else
	$same_show_count++;
	
	//echo "-- ".$same_show_count." -- ";
	
	if ( $same_show_count >= ($max_to_show-1) ) {
		
		// we know there is atleast one extra item here, how many more are there?
		$extra_items = get_extra_items( $i , $data );
		
		//echo "Got extras: ".$extra_items." ** ";
		
		// if there are extras, we are going to print the last one, and move on.
	}
	
	
		?>
		
		<div class="feed-item">
			
			<div class="feed-icon">
			</div>
			
			
			<div style="background: #dd00aa; float:left; padding-bottom: 2px;">
			
			
				<a class="titleA" style="" href="/shows/detail/<?= $data[$i]['show_id']  ?>"><?= stripslashes($data[$i]['title']) ?></a> &nbsp;&nbsp;&nbsp; 
				<a class="titleA" href="/videos/detail/<?= $data[$i]['video_id']  ?>"><?= stripslashes($data[$i]['v_title']) ?></a> &nbsp;&nbsp; 
			

	 			<? if ($data[$i]['video_type_id']=="1") { ?> *Full Ep.*  <?}?>
			
			</div>
		
			
			
			
		
			<? if ( $extra_items > 1 ) {  ?>
			
				<div style=" clear:both; height: 28px; padding-top: 4px; padding-left: 4px;" >
					<a style="background: #ffffbb; color: #003388;" href="/shows/detail/<?= $data[$i]['show_id']  ?>">
					&gt;&gt;	<?= $extra_items." more" ?></a>
					&nbsp;from <?= $data[$i]['title'] ?>
				</div>
		
			<? 
				$i = $i + $extra_items;
				$same_show_count=0;
				
				} else if ( $data[$i]['show_id'] != $data[$i+1]['show_id'] ) {
				
					// if the next item is different, then insert a little yellow marker to separate.
					?> <div style="clear:both; background: #ffffbb;">&nbsp;&nbsp;&nbsp;cool</div> <?
					
				}
				
			?>
		
		
		
		</div>
		
		<?
		
	
	

	
	
	$last_show = $data[$i]['show_id'];

}

?>