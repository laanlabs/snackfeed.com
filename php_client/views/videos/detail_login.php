



<style type="text/css" media="screen">
	#watch-options
	{
		width: 800px;
		margin-top: 80px
	}
	
	#nav-watch {
		position: relative;
		width: 100%;
		height: 38px;
		background: #eae9e9;
		border-bottom: 1px solid #b1aaaa;

	}

	#nav-watch ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	#nav-watch li {
		float: left;
		height: 100%;
	
	}

	#nav-watch li a.nav-item-watch {
	line-height: 38px;
	font-size: 22px;
		height:38px;
		padding-left: 25px;
		padding-right: 25px;
		display: block;
		border-right: 1px solid #dcdce9;
		color: #999;
		text-decoration: none;
		text-align: center;
	}

	#nav-watch li a:hover {

		color: #000;

	}
	
	
	#nav-watch li.selected a {
		color: #000;
		background: #ccc
	}
	
	
	#watch-detail
	{
		padding-top: 30px
	}
	
	#watch-nowplaying
	{
		float: left;
		width: 450px
	}
	
	#watch-nowplaying-options
	{
		float: right;
		width: 220px;
	}
	
	#watch-actions
	{
		padding-top: 10px;
		padding-bottom: 10px;
		background: #eee;
		height: 25px;
	}
		.play-block
	{
		padding-top: 20px;
		padding-bottom: 20px

	}		

	.play-title
	{
		padding-top: 20px;
		margin-bottom: 5px;
		height: 26px;
		border-bottom: 1px solid #ccc;

	}
	
	.play-selected
	{
		background: #FFFFCC; 
	}
</style>





<div id="watch-detail">
	
	<div id="watch-nowplaying">
		
		
		<img class="img_left" src="<?= $video_data[0]['thumb']  ?>"/>
		<h3><?= stripslashes($video_data[0]['title']) ?></h3>
		<?= stripslashes( $video_data[0]['detail'] ) ?>
		
		<br/> 
		
		
		
	</div>
</div>	
<br clear="both" />
<div style="height: 20px"></div>


<h1>
<a href="<?= stripslashes( $video_data[0]['url_link'] ) ?>" target="_new" >Watch this video <img  style="border: none; outline: none;" src="/static/images/icons/external_link.png"></a>
</h1>

<div style="height: 20px"></div>
Please <a href="/users/register">register</a> with Snackfeed to enjoy customization and enhanced features.