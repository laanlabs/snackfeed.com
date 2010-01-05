<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");

//print_r($_REQUEST);
//die();




$html =  stripslashes($_REQUEST['_body']);

$_host = str_replace("http://", "", $_REQUEST['_url']);
$tmp = explode("/" , $_host);


$_host = "http://" . $tmp[0] . "/";

//echo $_host;

$k = 0;

$canArray = array( );

$dom = new DOMDocument();
$dom->resolveExternals = false;
$dom->validateOnParse = true;
$dom->preserveWhiteSpace = true;
$dom->substituteEntities = true;
$dom->formatOutput = false;
@$dom->loadHTML($html);


//do inputs
$_inputs = $dom->getElementsByTagName('input');

//echo $_inputs->length.'<br />';

foreach($_inputs as $_input) { 
 $_value = $_input->getAttribute('value'); 
 
if (preg_match("/\<embed.*/im", $_value)) {


	preg_match_all('/src=(\"|\')(.*?)(\"|\')/i', $_value, $matches);
	//print_r($matches);
	$_src = $matches[2][0];

	preg_match_all('/width=(\"|\')([0-9]+?)(\"|\')/i', $_value, $matches);
	//print_r($matches);
	$_width = $matches[2][0];

	preg_match_all('/height=(\"|\')([0-9]+?)(\"|\')/i', $_value, $matches);
	$_height = $matches[2][0];
	
	preg_match_all('/flashvars=(\"|\')(.*?)(\"|\')/i', $_value, $matches);
	$_vars = $matches[2][0];
	
	$canArray[$k][0] = $_src;
	$canArray[$k][1] = $_width;
	$canArray[$k][2] = $_height;
	$canArray[$k][3] = $_vars;
	
	$k++;
	
}

}


$pattern ='#\<embed(.*?)\>#i';
preg_match_all($pattern, $html, $matches2);
//print_r($matches2);

for ($i=0; $i < count($matches2[0]) ; $i++) { 

	$_value = $matches2[0][$i];

	preg_match_all('/src=(\"|\')(.*?)(\"|\')/i', $_value, $matches);
	//print_r($matches);
	$_src = trim($matches[2][0]);


	if (!strstr($_src, 'http://') ) $_src = $_host . $_src;


	preg_match_all('/width=(\"|\')([0-9]+?)(\"|\')/i', $_value, $matches);
	//print_r($matches);
	$_width = $matches[2][0];

	preg_match_all('/height=(\"|\')([0-9]+?)(\"|\')/i', $_value, $matches);
	$_height = $matches[2][0];

	preg_match_all('/flashvars=(\"|\')(.*?)(\"|\')/i', $_value, $matches);
	$_vars = $matches[2][0];

    if ($_width > 0 && $_height > 0){
        $aspect = $_width / $_height;

        if ($aspect >= 1.0 && $aspect <= 2.3) {
          
			$canArray[$k][0] = $_src ;
			$canArray[$k][1] = $_width;
			$canArray[$k][2] = $_height;
			$canArray[$k][3] = $_vars;
			$k++;
        }
    }


}

$pattern ='#\<object(.*?)\>#i';
//preg_match_all($pattern, $html, $matches3);
//print_r($matches2);


/*
//sort array on width
foreach($canArray as $sortarray){
      $column[] = $sortarray[1];
}

//sort arrays after loop
array_multisort($column, SORT_DESC, $canArray);

*/




//print_r($_REQUEST);


$post_title = stripslashes($_REQUEST['_title']);
$post_message = $_REQUEST['_quote'];
$post_url = $_REQUEST['_url'];

$tumblr_email =  $_COOKIE["tumblr_email"];
$tumblr_password = $_COOKIE["tumblr_password"];


$wp_blog_url = $_COOKIE["wp_blog_url"];
$wp_username = $_COOKIE["wp_username"];
$wp_password = $_COOKIE["wp_password"];

$twitter_email = $_COOKIE["twitter_email"];
$twitter_password = $_COOKIE["twitter_password"];
$twitter_message = $post_title;

$b_username = $_COOKIE["b_username"];
$b_password = $_COOKIE["b_password"];
$b_blog_url = $_COOKIE["b_blog_url"];

$_type = isset($_REQUEST['_type']) ? $_REQUEST['_type'] : 'video';
$_REQUEST['_image'] = trim($_REQUEST['_image']);
$_REQUEST['_audio'] = trim($_REQUEST['_audio']);
$_REQUEST['_quote'] = trim($_REQUEST['_quote']);


switch ($_type) 
{
	case 'image':
		$_type_id = 1;
		break;
	case 'quote':
		$_type_id = 2;
		$twitter_message = $post_message;
		break;
	case 'audio':
		$_type_id = 3;
		break;				
	default:
		$_type_id = 0;
	
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Admin</title>
	<style type="text/css">
		@import 'default.css';
	</style>
	<script src="js/prototype.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/main.js" type="text/javascript" charset="utf-8"></script>		
</head>
<body>

	<!-- YO - this is a test to record movies of ppl visiting.... ClickTale Top part -->
	<script type="text/javascript">
	var WRInitTime=(new Date()).getTime();
	</script>
	<!-- ClickTale end of Top part -->
	
<div id="topBar" >
	<div id="step1Div" class="selectedTab" style=" width: 255px; padding-right: 5px; padding-left: 36px; float:left;">
		<a href="javascript: showMedia();">
		<span class="bigTitle">STEP 1</span>
		<span class="smallTitle">choose...</span>
		</a>
	</div>
	<div id="step2Div" style="width: 255px; padding-left: 36px; padding-right: 5px; float:left;">
		<a href="javascript:showPost()">
		<span class="bigTitle">STEP 2</span>
		<span class="smallTitle">post to...</span>
		</a>
	</div>



</div>	

<div id="mediaWin" >

	<div class="sideBar">

	
		<div id="videosFound" class="postOptions hand" onclick="doMediaCheck('0')" >
			<div id="videosCHK" class="checkbox" ></div><div>videos</div>
		</div>

		<div  id="imagesFound" class="postOptions hand" onclick="doMediaCheck('1')" >
			<div id="imagesCHK" class="checkbox"  ></div><div>images</div>
		</div>

		<div id="textFound" class="postOptions hand" onclick="doMediaCheck('2')" >
			<div id="textCHK" class="checkbox"  ></div><div>text</div>
		</div>
		
		<div id="songsFound" class="postOptions hand" onclick="doMediaCheck('3')" >
			<div id="songsCHK" class="checkbox"  ></div><div>songs</div>
		</div>		
			
			
		<div style="height: 100%; border-right: 1px solid #333">
			<div style="position:relative; top: 30px">
				<a href="javascript: showPost()"  id="btn">NEXT STEP <img src="images/next.png"/></a>
			</div>
		</div>
	
	</div>
	

	<div style="position: absolute; left: 220px; top: 60px; ">
	

	 <div id="videosForm" style="display: none; border:0px solid #ff0000;" class="formDiv">
 
		
		<? 	
	   	if (count($canArray) > 0)
		{	
		?>
		<div style="padding-top:5px; padding-bottom: 12px">
		Found <?= count($canArray) ?> video(s): 
		
		<?
		if (count($canArray) > 1 )
		{
			$vBtnOn = "videoBtnOn";
			for ($i=0; $i < count($canArray) ; $i++) {  ?>

			<a id="videoLink_<?= $i ?>" class="videoBtn <?= $vBtnOn ?>" href="javascript:showVideo(<?= $i ?>)"><?= $i +1 ?></a>

		<? 	
			$vBtnOn = "";
			}
			}
		?>
		</div>
	<form id="form_videos">
	  <?

		for ($i=0; $i < count($canArray) ; $i++) { 
			
		 $_width =	$canArray[$i][1] ;
		 $_height =  $canArray[$i][2] ;
		 
		 $_ratio = empty($_width) ? 1 : $_height/$_width;
		

		
		//echo $_ratio;
		
		$_widthNew = 320;
		$_heightNew = round(320 * $_ratio);

		/* width:<?=  $_widthNew ?>; height:<?=  $_heightNew ?>; */
                   
			       
			
	  ?>	

	
	 

	
	   		<div id="video_<?= $i ?>" style="border:0px solid #000; text-align: center; <?= $_hidden ?>; ">
		
<embed src="<?=  $canArray[$i][0] ?>" play="false" flashvars="<?=  $canArray[$i][3] ?>"  type="application/x-shockwave-flash" wmode="transparent" width="<?=  $_width ?>" height="<?=  $_height?>" ></embed>
		
		<input type="hidden" id="f_video_<?= $i ?>" value='<object width="<?=  $_width ?>" height="<?=  $_height?>"><param name="movie" value="<?=  $canArray[$i][0] ?>"></param><param name="wmode" value="transparent"></param><embed src="<?=  $canArray[$i][0] ?>" <? if (!empty($canArray[$i][3]))  echo 'flashVars="' . $canArray[$i][3] .'" ';  ?>type="application/x-shockwave-flash" wmode="transparent" width="<?=  $_width ?>" height="<?=  $_height?>"></embed></object>' />
		
				<input type="hidden" id="f_video_source_<?= $i ?>" value="<?=  $canArray[$i][0] ?>" />
				<input type="hidden" id="f_video_params_<?= $i ?>" value="<?=  $canArray[$i][3] ?>" />
		
			
			</div>
	  
	<?
	 	$_hidden = "display: none";
		}
	?>

		</form>
		<div>
			

		
		</div>
		
	<? } else {?>	
		
		<div id="noFound">
		We did not find any videos on this page -- you can manually paste embed code in the form below and then click update<br/>
		<br/>
		<textarea name="man_embed" id="man_embed" class="simpleBox" style=" height: 200px;"></textarea><br/>
		<a id="btn" style="position:relative; top: 15px;" href="javascript:manEntry()">Update</a>
		</div>
		<input type="hidden" id="f_video_0" value='' />
		<input type="hidden" id="f_video_source_0" value="" />
		<input type="hidden" id="f_video_params_0" value="" />
		<div id="video_0" style="border:0px solid #000; text-align: center;">
		</div>
		
	<? } ?>
	
     </div>

	<div id="imagesForm" style="display: none;" class="formDiv">
		
		<?
			if (!empty($_REQUEST['_image'] )) {
				
			
		?>
		
		<h4>Your Screenshot</h4> 
		<img src="<?= $_REQUEST['_image'] ?>" style="width: 300px" />
		<br/>
		<a href="<?= $_REQUEST['_image'] ?>" target="_new">full size</a>
		
		
		<?
	} else {
		?>
	<p/>
	<h3>No Images Sent</h3>
	
	<? } ?>
	
	</div>

	<div id="textForm" style="display: none;" class="formDiv">
		<h4>Your Quote/Text</h4> 
		<div style="color:#ff9900;">Please edit this text in next step.</div>
		<textarea name="text_field" readonly id="text_field" class="simpleBox" style="cursor: default; height: 200px; background-color: #eaeaea; color: #acacac;"><?= $_REQUEST['_quote'] ?></textarea><br/>
		
	
	</div>
	
	<div id="songsForm" style="display: none;" class="formDiv">
		
		<? 
		
		if (!empty($_REQUEST['_audio']))
		$songs = explode("||", $_REQUEST['_audio']);
		
		if (count($songs) > 0) 
		{
		?>	
		<h5>Found <em><?= count($songs) ?></em> MP3 Files from your cache:</h5>
		
		<div id="scrollMusic" style="border: 1px solid #000; width: 350px; height: 250px; overflow-y: auto; overflow-x:hidden; position:relative; left: 30px; text-align: left; ">
		<table width="100%" cellspacing="0" cellpadding="10">
		<?
		
		for ($i=0; $i < count($songs) ; $i++) { 
			$color = "#ddd";
			if($i % 2) $color = "#ccc";
		
		
		?>
		<tr style="background-color: <?= $color ?>">
			<td>
				<input type="radio" name="songUrl" value="song_<?= $i ?>" />
			</td>
			<td>	
		<a onclick="javascript:$('vSong_<?= $i ?>').show();">&gt;</a> Song <?= $i+1 ?> <a href="<?= $songs[$i] ?>" target="_new">download</a><br/>
		<div id="vSong_<?= $i ?>" style="display: none" >
		<input type="text" name="song_<?= $i ?>" value="<?= $songs[$i] ?>" size="55" />
		</div>
		<!-- Quicktime  Start-->
		<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="250" height="20" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
		<param name="autoplay" value="false" />
		<param name="controller" value="true" />
		<param name="kioskmode" value="true" />
		<param name="src" value="<?= $songs[$i] ?>" />
		<embed src="<?= $songs[$i] ?>"
		height="20" width="250"
		type="video/quicktime"
		autoplay="false"
		controller="true"
		kioskmode="true"
		pluginspage="http://www.apple.com/quicktime/download"
		/>
		</object>
		 <!-- Quicktime End-->

		</td>
		</tr>
	<? /*  *	
		<object type="application/x-shockwave-flash" data="mp3player.swf" id="audioplayer1" height="24" width="290"><param name="movie" value="mp3player.swf"><param name="FlashVars" value="playerID=1&amp;soundFile=<?= $songs[$i] ?>"><param name="quality" value="high"><param name="menu" value="false"><param name="wmode" value="transparent"></object>
*/?>
	
		<?
		}
		?>
		</table>
		</div>
		<br/>
		<div style="width:500px; position: relative; left: 20px">
		!!!: this is very early stage -- if you dont see playbar, its probably not a valid mp3.
		</div>
		<? } else {?>	
		<p/>
		<p/>
						Sorry we could not find any songs in your cache?!?	
	
	
	
	<?	}?>
	
	</div>	


		
	</div>
	
</div>	

<div id="accountsWin" style="display: none;" >
	
	<div class="sideBar">

	
		<div id="tumblr" class="postOptions" onclick="javascript:getPostDiv('0')" >
			<div id="tumblrCHK" class="checkbox"  onclick="doCheck('0')"></div>tumblr
		</div>

		<div  id="wordPress" class="postOptions" onclick="javascript:getPostDiv('1')" >
			<div id="wordPressCHK" class="checkbox"  onclick="doCheck('1')"></div>Word Press
		</div>

		<div id="twitter" class="postOptions" onclick="javascript:getPostDiv('2')" >
			<div id="twitterCHK" class="checkbox"  onclick="doCheck('2')"></div>twitter
		</div>
		
		<div id="blogger" class="postOptions" onclick="javascript:getPostDiv('3')" >
			<div id="bloggerCHK" class="checkbox"  onclick="doCheck('3')"></div>blogger
		</div> 
		
		<div id="channels" style="display:none;" class="postOptions" onclick="javascript:getPostDiv('4')" >
			<div id="channelsCHK" class="checkbox"  onclick="doCheck('4')"></div>channels
		</div>			
			
			
		<div style="height: 100%; border-right: 1px solid #333">
			<div>
				<a href="javascript: doPost()" id="postButton2">
				<span  ><img src="images/check3.png"/>OK, POST</span>
				</a>
			</div>
		</div>
	
	</div>
	
	<div style="position: absolute; left: 220px; top: 60px; ">
		<div id="infoForm" class="formDiv" style="font-size:30px; width: 350px; line-height: 40px">
			Please select your blog, messaging accounts from the left you wish to publish to...
		</div>
	
		<div id="tumblrForm" style="display: none;" class="formDiv">
			
			<form id="tumblrFormData" method="post" action="post_tumblr.php">
			<input type="hidden" name="tumblr_data" id="tumblr_data" value="" />
			<input type="hidden" name="tumblr_image" id="tumblr_image" value="<?= $_REQUEST['_image'] ?>" />
			
			
			<div class="formTitle">Title:</div>
			<input type="text" name="title" value="<?= $post_title ?>" size="60" class="simpleBox" />
			
			<div class="formTitle">Message:</div>
			<textarea name="message"  class="simpleBox" rows="2" cols="55" style=" height: 100px;"><?= $post_message ?></textarea>


			<div class="formTitle">Post Type:</div>
			<select name="tumblr_type">
				<option value="regular" >regular</option>
				<option value="video" <? if ($_type == 'video') echo 'SELECTED'; ?> >video</option>
				<option value="photo" <? if ($_type == 'image') echo 'SELECTED'; ?> >photo/image</option>
				<option value="quote" <? if ($_type == 'quote') echo 'SELECTED'; ?> >quote</option>
				<option value="audio" <? if ($_type == 'audio') echo 'SELECTED'; ?> >audio</option>
			</select>
		


			<div class="formTitle">Your tumblr email:</div>
				<input type="text" name="tumblr_email" value="<?= $tumblr_email ?>" size="60" class="simpleBox" />
			
			<div class="formTitle">Your tumblr password:</div>
			<input type="password" name="tumblr_password" value="<?= $tumblr_password ?>" size="60"  class="simpleBox" />
	
		</form>
		</div>
	
		<div id="twitterForm" style="display: none;" class="formDiv">
		
				
				<form id="twitterFormData" method="post" action="post_twitter.php">
				<input type="hidden" name="twitter_data" id="twitter_data" value="" />

				<div class="formTitle">Message:</div>
				<textarea name="message" id="twitter_message" class="simpleBox" style=" height: 100px;"  onKeyUp="twCounter()" ><?= $twitter_message ?></textarea>
				<div id="sBann"  style="font-size: 12px; color: #999">140 character limit</div>

			<? if ($_type == 'video') { ?>	
				<div class="formTitle">Video URL:</div>
				<input type="text" name="twitter_url" value="<?= $post_url ?>" size="60" class="simpleBox" />
				<div style="font-size: 12px; "><input type="checkbox" CHECKED id="twitter_url_append" onChange="twCounter()" name="twitter_url_append" value="1" /> Include at end of message?
				<span style="font-size: 12px; color: #999">will be automatically converted to tiny url</span></div>
			<? } ?>
			
			<? if ($_type == 'image') { ?>	
				<div class="formTitle">Image URL:</div>
				<input type="text" name="twitter_url" value="<?= $_REQUEST['_image'] ?>" size="60" class="simpleBox" />
				<div style="font-size: 12px; "><input type="checkbox" CHECKED id="twitter_url_append" onChange="twCounter()" name="twitter_url_append" value="1" /> Include at end of message?
				<span style="font-size: 12px; color: #999">will be automatically converted to tiny url</span></div>
			
			<? } ?>
			
				<div class="formTitle">Your twitter username:</div>
					<input type="text" name="twitter_email" value="<?= $twitter_email ?>" size="60" class="simpleBox" />

				<div class="formTitle">Your twitter password:</div>
				<input type="password" name="twitter_password" value="<?= $twitter_password ?>" size="60"  class="simpleBox" />



				</form>
		</div>
	
		<div id="wordPressForm" style="display: none;" class="formDiv">
			
			
			<form id="wordPressFormData" method="post" action="post_wordPress.php">
			<input type="hidden" name="wordPress_data" id="wordPress_data" value="" />
			<input type="hidden" name="wp_image_url" value="<?= $_REQUEST['_image'] ?>"  />
			

			<div class="formTitle">Title:</div>
			<input type="text" name="title" value="<?= $post_title ?>" size="60" class="simpleBox" />
			<div id="wpBasicOptions">
			<div class="formTitle">Post:  <a href="javascript: showWpAdv();" style="padding-left: 220px; color:#999; font-size: 10px">(see advanced options)</a></div>
			<textarea name="message"  class="simpleBox" style=" height: 100px;"><?= $post_message ?></textarea><br/>
			<input type="checkbox" value="0" name="wp_publish" /> post as draft

			<div class="formTitle">Your Blog URL:</div>
			<input type="text" name="wp_blog_url" value="<?= $wp_blog_url ?>" size="60" class="simpleBox" /><br/>
			<div style="font-size: 12px; color: #999">e.g. www.yoursite.com/blog/</div>

			<div class="formTitle">Your username:</div>
			<input type="text" name="wp_username" value="<?= $wp_username ?>" size="60" class="simpleBox" />

			<div class="formTitle">Your password:</div>
			<input type="password" name="wp_password" value="<?= $wp_password ?>" size="60"  class="simpleBox" />
            <div style="font-size: 12px; color: #999; position: relative; top: 3px">NOTE: Only Google Video, Youtube, DailyMotion, Grouper, Odeo, and SplashCast are supported on Wordpress.com hosted blogs -- Others will not appear.</div>
			</div>
			<div id="wpAdvOptions" style="padding-top: 20px; display:none">
				<a href="javascript:hideWpAdv()" style="color:#000; font-size: 12px" class="genericBtn">&lt;&lt; Back to Basic Options</a>
				<div class="formTitle">Categories: </div>
				<textarea name="wp_categories"  class="simpleBox" style=" height: 100px;"></textarea><br/>
				<div style="font-size: 12px; color: #999; position: relative; top: 3px">
					A comma separated list with NO spaces between commas.<br/>
					NOTE: Each category must match an existing category on your blog. </div>
			</div>	
			</form>
		</div>	
	
		<div id="bloggerForm" style="display: none;" class="formDiv">
			
			
			<form id="bloggerFormData" method="post" action="post_blogger.php">
			<input type="hidden" name="blogger_data" id="blogger_data" value="" />
			<input type="hidden" name="blogger_image_url" value="<?= $_REQUEST['_image'] ?>"  />


			<div class="formTitle">Title:</div>
			<input type="text" name="title" value="<?= $post_title ?>" size="60" class="simpleBox" />

			<div id="bBasicOptions">
				
		
			<div class="formTitle">Post:
				<a href="javascript: showBAdv();" style="padding-left: 220px; color:#999; font-size: 10px">(see advanced options)</a>
				</div>
			<textarea name="message"  class="simpleBox" style=" height: 100px;"><?= $post_message ?></textarea><br/>
				<input type="checkbox" value="1" name="b_publish" /> post as draft

			
			<div class="formTitle">Google username:</div>
			<input type="text" name="b_username" value="<?= $b_username ?>" size="60" class="simpleBox" />

			<div class="formTitle">Google password:</div>
			<input type="password" name="b_password" value="<?= $b_password ?>" size="60"  class="simpleBox" />
			
				<div class="formTitle">Blog Name: <span style="color: #999; font-size: 12px">(if you have more than one blogger/blogspot acct.)</span></div>
				<input type="text" name="b_blog_url" value="<?= $b_blog_url ?>" size="60" class="simpleBox" /><br/>
				<div style="font-size: 12px; color: #999; padding-top: 3px;">i.e. yourBlogName from yourBlogName.blogspot.com</div>
			
					</div>

				<div id="bAdvOptions" style="padding-top: 20px; display:none">
					<a href="javascript:hideBAdv()" style="color:#000; font-size: 12px" class="genericBtn">&lt;&lt; Back to Basic Options</a>
					<div class="formTitle">Labels: </div>
					<textarea name="b_categories"  class="simpleBox" style=" height: 100px;"></textarea><br/>
					<div style="font-size: 12px; color: #999; position: relative; top: 3px">
						A comma separated list with NO spaces between commas.<br/>
						</div>
				</div>

			</form>
		</div>	
	
		<div id="channelsForm" style="display: none;" class="formDiv">
			
			<? 
				//$sf_user_id = 'dfb6d566-3c52-102b-9a93-001c23b974f2';
			   $sf_email = 'jason@laan.com';	?>
			
			<form id="channelsUserInfo" method="post" action="/users/get_user_channels">
				<input type="hidden" name="user_id" id="sf_user_id_1" value="<?= $sf_user_id ?>" />
				<input type="hidden" name="json"  value="true" />
				
	
				<div class="formTitle">SF Email:</div>
				<input type="text" name="sf_email" id="sf_email" value="<?= $sf_email ?>" size="60" class="simpleBox" /><br/>
				<a href="javascript:getChannels()">getChannels</a>	
				</form>
				
				<form id="channelsFormData" method="post" action="post_channels.php">
						<input type="hidden" name="channels_data" id="channels_data" value='' />
			<input type="hidden" name="user_id" id="sf_user_id_2" value="" />
		
				<div class="formTitle">Your Channels:</div>
				<div id="sfChannelsList" style="width: 300px; height: 60px; overflow: auto; background-color: #acacac;">
					We dont have your channels -- click getChannels
				</div>
				<div class="formTitle">Title:</div>
				<input type="text" name="title" value="<?= $post_title ?>" size="60" class="simpleBox" />

				<div class="formTitle">Post:</div>
				<textarea name="message"  class="simpleBox" style=" height: 50px;"><?= $post_message ?></textarea>		
				
			</form>
		
		</div>
	
	</div>
	
</div>	

<div id="postWin" style="display:none" >
	<div id="reponseArea" style="padding:20px">
	<h1>Performing Posts...</h1>
	<div id="responseWin">
		</div>
	</div>
</div>

<div style="position: absolute; top: 0px; left: 630px; padding-top: 5px; text-align: center; background-color: #ff0000; width: 90px; height: 20px;">
<a href="http://labs.laan.com/contact.php" class="feedbackBtn" target="_new">feedback</a>
</div>

<div style="position: absolute; top: 0px; left: 730px; padding-top: 5px; text-align: center;">
<a href="javascript:showChannelOption()" class="feedbackBtn">*</a>
</div>


<script>
doMediaCheck('<?= $_type_id ?>');
twCounter() ;

if ($('sf_email').value.length > 3 )
{
	getChannels();
}



</script>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-654321-13");
pageTracker._initData();
pageTracker._trackPageview();
</script>

</body></html>