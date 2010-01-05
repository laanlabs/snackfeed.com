<?
function rgb2html($r, $g=-1, $b=-1)
{
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return '#'.$color;
}

?>

<div id="main-content" style=" float: left; line-height: 36px;" >
	<div style="margin-top: 15px; margin-bottom: 45px; margin-left:10px ">
		<div style="float:left; font-size: 24px; font-weight: bold"><?= $_title ?></div>
		<div style="float:right; font-size: 12px; padding-top: 6px ">
			<a href="/public/keywords">all time</a> | <a href="/public/keywords/today">today</a> 
		</div>
	</div>
	<br clear="both"/>
		
<?

for ($i=0; $i < count($wWords) ; $i++) { 
	$_term = $wWords[$i][0];
	$_term=preg_replace('/[^A-Za-z0-9]/','', $_term);
	$_weight = round((float)((($wWords[$i][1]+1))/$_max),2);
	$_size = 12 + round($_weight*28);
	
	$_color =  round($_weight*255);
	$_hex = rgb2html($_color, 255-$_color, $i);

	
?>

<a style="color: <?= $_hex ?>; font-size: <?= $_size ?>px; padding: 10px" title="Found <?= $wWords[$i][1] ?> times" href="/search?q=<?= $_term ?>"><?= $_term ?></a>

<?

	
}		
		
		
?>
</div>
<div id="right-column"  >
	
	
	
	<? if (User::$user_id == '0' ){ ?>
	
			<? include '_inc/email.php'; ?>		
	<? } ?>
	
			<div class="right-column-box-light" style="margin-top: 30px;">

				<div class="column-box-header">
					<span style="">Other Feeds</span>
				</div>

				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png">
					<a href="/public"> Snackfeed Home Feed </a>
				</div>

				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/icons/feed_fullep_icon.png">
					<a href="/shows">Popular Shows </a>
				</div>					

				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/splash/ff.png">
					<a href="/public/friendfeed"> Best of FriendFeed</a>
				</div>

				<div style="color: #222; padding: 9px; font-size: 13px;">
					<img class="icon-offset" src="/static/images/splash/twitter.png">
					<a href="/public/twitter"> Popular on Twitter</a>
				</div>					
				
				<div class="column-box-item">
					<img class="icon-offset" src="/static/images/icons/feed_status_icon.png"> 
					<a href="/public/trends">Popular Search Trends</a>
				</div>
				
			</div>
	
<? include '_inc/footer.php'; ?>

</div>
