<div  style="width:850px;  margin: 0 auto; padding-top: 90px ">
	
	<div style="height: 70px;">
		<img src="/static/images/v2/content/step2.png"></img>
		
	</div>

	<div style="font-size:24px; font-weight: bold; padding-bottom: 20px">
		step 2a: choose some people to follow<br/>
		<span class="detail-small">these are friends (and people who are interesting) - their favorites will appear in your feed</span>		
	</div>
		
	

		<!-- START ITEM -->
		 <div class="type-item" >	
			<div style="height: 40px;">
				
			
			<div style="float: left; width: 120px">
			<div class="type-title">Founders</div>
				 follow the people who started this thing
			</div>	
			<div style="float: right; width: 75px">	
				<div class="type-follow ">
					<a href="javascript:followFounders();" >follow all</a>
				</div>
			</div>	
			</div>
			<br clear="both"/>
			<div id="name">
				
			
			<? for ($j = 0 ; $j < count($users_data) ; $j++) { ?>
			<div class="sub-item">
				<div style="float: left; ">
					
					<img src="<?= $users_data[$j]['thumb'] ?>" class="img-follow-thumb"><br/>
							<?= substr(stripslashes($users_data[$j]['nickname']), 0 , 13) ?>
				</div>
				<div class="sub-item-follow">
						<a href="javascript:sf.updates('user_follow_1<?= $j ?>','/users/follow/<?= $users_data[$j]['user_id'] ?>?&plain=1')" class="" id="user_follow_1<?= $j  ?>" >follow this person</a>
				</div>
			
			</div>
			<br clear="both" />
			<? } ?>
			</div>	
		 </div>
			<!-- END ITEM -->

			<!-- START ITEM -->
			 <div class="type-item" >	
				<div style="height: 40px;">


				<div style="float: left; width: 120px">
				<div class="type-title">Similar?</div>
					 people that we think are like you
				</div>	
				<div style="float: right; width: 75px">	
					<div class="type-follow ">
						<a href="javascript:followSimilar();" >follow all</a>
					</div>
				</div>	
				</div>
				<br clear="both"/>
				<div id="name">


				<? for ($j = 0 ; $j < count($data_similar) ; $j++) { ?>
				<div class="sub-item">
					<div style="float: left; ">

							<img src="<?= $data_similar[$j]['thumb'] ?>" class="img-follow-thumb"><br/>
								<?= substr(stripslashes($data_similar[$j]['nickname']), 0 , 13) ?>
					</div>
					<div class="sub-item-follow">
							<a href="javascript:sf.updates('user_follow_2<?= $j ?>','/users/follow/<?= $data_similar[$j]['user_id'] ?>?&plain=1')" class="" id="user_follow_2<?= $j  ?>" >follow this person</a>
					</div>

				</div>
				<br clear="both" />
				<? } ?>
				</div>	
			 </div>
				<!-- END ITEM -->


				<!-- START ITEM -->
				 <div class="type-item" >	
					<div style="height: 40px;">


					<div style="float: left; width: 120px">
					<div class="type-title">Friends?</div>
						 people that you might know
					</div>	
					<div style="float: right; width: 75px">	
						<div class="type-follow ">
							<a href="javascript:followKnow();" >follow all</a>
						</div>
					</div>	
					</div>
					<br clear="both"/>
					<div id="name">


					<? for ($j = 0 ; $j < count($data_know) ; $j++) { ?>
					<div class="sub-item">
						<div style="float: left; ">

								<img src="<?= $data_know[$j]['thumb'] ?>" class="img-follow-thumb"><br/>
									<?= substr(stripslashes($data_know[$j]['nickname']), 0 , 13) ?>
						</div>
						<div class="sub-item-follow">
								<a href="javascript:sf.updates('user_follow_3<?= $j ?>','/users/follow/<?= $data_know[$j]['user_id'] ?>?&plain=1')" class="" id="user_follow_3<?= $j  ?>" >follow this person</a>
						</div>

					</div>
					<br clear="both" />
					<? } ?>
					</div>	
				 </div>
					<!-- END ITEM -->	



				<br clear="both"/>	
				<br clear="both"/>	
				<div id="button-submit" style="width: 300px;  margin-left: 0px; margin-top: 30px " class="button-form" ><a href="/feed?show_welcome=1">finished! - start feeding &nbsp;<span style="font-size: 20px; font-weight: normal">&gt;&gt;</span></a></div>
			

</div>	




<style type="text/css" media="screen">

	.sub-item-follow
	{
		position: absolute; top: 10px; right: 0px;
	}

	.img-follow-thumb
	{
		height: 35px; border: 1px solid #ccc;
	
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
			 display: block;
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

<script type="text/javascript" charset="utf-8">
	function followFounders()
	{
		<? for ($j = 0 ; $j < count($users_data) ; $j++) { ?>
			sf.updates('user_follow_1<?= $j ?>','/users/follow/<?= $users_data[$j]['user_id'] ?>?&plain=1');
		
		<? } ?>
	}
	
	function followSimilar()
	{
		<? for ($j = 0 ; $j < count($data_similar) ; $j++) { ?>
			sf.updates('user_follow_2<?= $j ?>','/users/follow/<?= $data_similar[$j]['user_id'] ?>?&plain=1');
		
		<? } ?>
	}
	
	function followKnow()
	{
		<? for ($j = 0 ; $j < count($data_know) ; $j++) { ?>
			sf.updates('user_follow_3<?= $j ?>','/users/follow/<?= $data_know[$j]['user_id'] ?>?&plain=1');
		
		<? } ?>
	}		
	
</script>