<div  style="width:850px;  margin: 0 auto; padding-top: 90px ">
	
	<div style="height: 70px;">
		<img src="/static/images/v2/content/step2.png"></img>
		
	</div>

	<div style="font-size:24px; font-weight: bold; padding-bottom: 20px">
		step 2: choose some shows to follow<br/>
		<div class="detail-small" style="padding-top: 10px;" >videos from shows will appear in your feed - you should definitely pick a bundle or two to get your feed started - also if you don't like any of these shows? don't worry
there are thousands more inside</div>		
	</div>
		
	



		<? for ($i = 0 ; $i < count($packages_data) ; $i++) { ?>	
		<!-- START ITEM -->
		 <div class="type-item" >	
			<div style="height: 40px;">
				
			
			<div style="float: left; width: 120px">
			<div class="type-title"><?= stripslashes($packages_data[$i]['name']) ?></div>
				 <?= $packages_data[$i]['detail'] ?> 
			</div>	
			<div style="float: right; width: 75px">	
				<div class="type-follow ">
					<a href="javascript:followPack_<?= $i ?>();" class="" id="package_follow_<?= $i ?>" >follow all</a>
				</div>
			</div>	
			</div>
			<br clear="both"/>
			<div id="name">
				
			
			<?
				$show_data = Show::get_package_shows(array("package_id" => $packages_data[$i]['package_id'], "limit" => "3"));
				for ($j = 0 ; $j < count($show_data) ; $j++) {
			?>
			<div class="sub-item">
				<div style="float: left; ">
					
						<img src="<?= $show_data[$j]['thumb'] ?>" style="width: 60px; border: 1px solid #ccc"><br/>
							<?= substr(stripslashes($show_data[$j]['title']), 0 , 25) ?>
				</div>
				<div class="sub-item-follow">
						<a href="javascript:sf.updates('show_follow_<?= $i . $j ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $show_data[$j]['show_id']  ?>&plain=1')" class="" id="show_follow_<?= $i . $j  ?>" >follow this show</a>
				</div>
			
			</div>
			<br clear="both" />
			<? } ?>
			</div>	
		 </div>
			<!-- END ITEM -->
			
			<script type="text/javascript" charset="utf-8">
				function followPack_<?= $i ?>()
				{
					sf.updates('package_follow_<?= $i ?>','/users/save_package/?user_id=<?= User::$user_id ?>&package_id=<?= $packages_data[$i]['package_id'] ?>&plain=1')
					<? for ($j = 0 ; $j < count($show_data) ; $j++) { ?>
					sf.updates('show_follow_<?= $i . $j ?>','/users/save_show_to_favorites?user_id=<?= User::$user_id ?>&show_id=<?= $show_data[$j]['show_id']  ?>&plain=1')
					<? } ?>
				}
			</script>	
			
	<? } ?>



	



				<br clear="both"/>	
				<br clear="both"/>	
				<div id="button-submit" style="width: 300px;  margin-left: 0px; margin-top: 30px " class="button-form" ><a href="/users/register_3/<?= User::$user_id ?>">next step - follow people &nbsp;<span style="font-size: 20px; font-weight: normal">&gt;&gt;</span></a></div>
			

</div>	




<style type="text/css" media="screen">
	.sub-item-follow
	{
		position: absolute; top: 10px; right: 0px;
	}

	.sub-item
	{
		padding-top: 10px; height: 50px; margin-left: 25px; border-top: 1px solid #ccc;
		position: relative;
	}
	.type-follow
	{
		padding-top: 5px; left: 7px; position: relative;
		display: block;
	}
	
	.type-follow a
	{
		padding: 5px 7px 2px 7px;
		border: 1px solid #666;
		text-decoration: none;
		background: #ccc;
			 font-size: 12px;
	}
	
	.type-follow a:hover
	{
	
		background: #666;
		color: #fff;
	}
	


	.type-item
	{
	 	width: 220px; position: relative; border: 0px solid #000;
		float: left;
		padding-right: 20px;
		padding-top: 10px;
			padding-left: 10px;
			margin-left: 30px;
			background: #eee;	
		
	}

	.type-title
	{
		font-size: 14px; font-weight: bold;
	}



	
	.detail-small
	{
		font-size: 12px;
		color: #666;
		font-weight: normal;
	}
	
	a.btnSelected, a.btnSelected:hover
	{
		background: #00ffee;
		text-decoration: none;
	}
	
</style>


