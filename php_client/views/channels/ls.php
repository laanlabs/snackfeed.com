

<div class="two-column-left">
	<div class="header-big">
		options
	</div>
	<div class="indent-column">
		
		put categories here
		
	</div>
	
	
</div>

<div  class="two-column-right ">
	
	<div class="header-big">
		Channels <span class="small-detail">current channels </span>
	</div>
	
	<div class="indent-column" style="font-size: 12px; line-height: 22px; padding-top: 25px" >
	
<?

for ($i=0; $i < count($data) ; $i++) 
{
	
?>

	<div class="result-item-big" >
		<img class="img-left-big" src="<?= $data[$i]['thumb']  ?>"/>
		<a href="/channels/detail/<?= $data[$i]['channel_id'] ?>"><?= stripslashes($data[$i]['title']) ?></a><br/>
			
		<?= stripslashes(substr($data[$i]['detail'], 0, 120)) ?> 
		
	</div>


<?

}

?>		
		
		

	
</div>	
	
</div>