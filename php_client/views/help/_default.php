<style type="text/css" media="screen">

	#nav-help {
		position: relative;
		width: 100%;
		height: 38px;
		background: #eae9e9;
		border-bottom: 1px solid #b1aaaa;



	}

	#nav-help ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	#nav-help li {
		float: left;
		height: 100%;
	
	}

	#nav-help li a.nav-item-help {
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

	#nav-help li a:hover {

		color: #000;

	}

	#comments-count
	{
		position: relative;
		display:inline;
		color: #ff0000;
		top: -4px;
	}
	
	#help-content
	{
	
		padding-left: 20px;
		padding-top: 10px;
		padding-right: 20px;
	}
	
	
</style>


<div id="nav-help">
	<ul>
		<li><a href="javascript:toggleHelp('help')" class="nav-item-help" >help</a></li>
		<li><a href="javascript:toggleHelp('comments')" class="nav-item-help" >comments<div id="comments-count"></div></a></li>
		<li><a href="javascript:toggleHelp('contact')" class="nav-item-help" >feedback/contact/bugs</a></li>	
		<li><a href="javascript:toggleHelp('index')" class="nav-item-help" >help index</a></li>				
	</ul>
</div>		
	
<div id="help-content">	
<div id="div-help" style="line-height: 22px">
	
	<h3><?= stripslashes($data[0]['title']) ?></h3>
	<div id="name">
		<?= stripslashes($data[0]['detail']) ?>	
	</div>
	
	
	<div style="padding-top:30px">
		<a href="javascript:toggleHelp('index')">see all help</a>
	</div>
	
	
	
	
</div>


	


<div id="div-comments" style="display:none">
	

	<script type="text/javascript" charset="utf-8">
		//set the comment location
		disqus_url = 'http://snackfeed.com/help/';
	</script>
	<!-- DISQUS START -->
	<script type="text/javascript" charset="utf-8">
		//set the comment location
		disqus_url = 'http://snackfeed.com/help/';
	</script>
	<div id="disqus_thread"></div><script type="text/javascript" src="http://disqus.com/forums/www-snackfeed/embed.js"></script><noscript><a href="http://www-snackfeed.disqus.com/?url=ref">View the forum thread.</a></noscript><a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>


	<!-- DISQUS END -->

</div>

<div id="div-contact" style="display:none">

	<div  style="width:525px;  margin: 0 auto; ">

		<div class="indent-column" style="font-size: 12px; line-height: 22px; padding-top: 25px" >
				<form method="post" action="/help" name="form_email" id="form_email">
					<input type="hidden" name="send_email" value="1"/>

			<div id="form-message" class="form-message"><?= $vMSG ?></div>



				<label for="input_from" class="nForm" >your name:</label> 
					<input class="nForm" type="text" name="input_from" id="input_from" value="<?= User::$username ?>"  /><br clear="left"/>
					<div class="field-message small-detail"></div><br clear="left" />

				<label for="input_email" class="nForm" >your email:</label> 
					<input class="nForm" type="text" name="input_email" id="input_email" value=""  /><br clear="left"/>
					<div class="field-message small-detail"></div><br clear="left" />

				<label for="input_message" class="nForm" >message:</label> 
				<textarea class="nForm" name="input_message" cols="35" rows="6"></textarea><br clear="left"/>
					<div class="field-message small-detail"></div><br clear="left" />


				<label for="input_reason" class="nForm" >reason:</label> 
				<select name="input_reason" class="nForm">
					<option value="general">say hello</option>
					<option value="product">bug (dont panic)</option>
					<option value="product">product feedback</option>
					<option value="other">other</option>
				</select>
				<br clear="left"/>
				<div class="field-message small-detail"></div><br clear="left" />


					<br clear="left"/>	
					<div id="button-submit" class="button-form" ><a  href="javascript:sendEmail();">send</a></div>	
					<br clear="left"/>	
					<br clear="left"/>


		</div>

	</div>

</div>	

<div id="div-index" style="display:none">
	<? for ($i=0; $i < count($toc_data); $i++) { ?>
	<h3><a href="/help/<?= $toc_data[$i]['controller'] ?>/<?= $toc_data[$i]['action'] ?>"><?= $toc_data[$i]['title'] ?></a> </h3>
	<? } ?>
</div>

</div>


<script type="text/javascript" charset="utf-8">
	
	var lastDiv = 'help';
	
	var comment_count = $('dsq-comments-count').innerHTML;
	comment_count = comment_count.replace('Comments','') 
	$('comments-count').update(comment_count)
	
	
	function toggleHelp(id)
	{
		$('div-' + lastDiv ).hide();
		$('div-' + id ).show();
		lastDiv = id;
		
		
	}
	
	
	function sendEmail(){
		$('form_email').request({
		  onComplete: function(){ $('form-message').update('email sent!') }
		})
	}
	
</script>



<? /*  

*/?>