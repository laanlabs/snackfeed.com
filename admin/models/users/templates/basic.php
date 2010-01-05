<?

$content = "";
$_date = urlencode($_date);
$_link_base = "http://www.snackfeed.com/";

foreach ($q as $r)
{
	
$r['new_titles'] = stripslashes($r['new_titles']);	
$r['title'] = stripslashes($r['title']);
	
$content .= <<<EOT
	<li style="">
	      <div >
	          <a href="{$_link_base}shows/detail/{$r['show_id']}" style="font-family:'Lucida Grande',Verdana,Helvetica,Arial,sans-serif; font-size: 20pt; color:#5D9E9B">{$r['title']}</a>:
	      </div>

	          <div style="color:acacac">{$r['date_formatted']}</div>

	       		<div class="caption">
	            <span><p>{$r['new_content']} new pieces of content, Episodes: {$r['new_episodes']}, Clips: {$r['new_clips']}</p> <blockquote>
						<p>{$r['new_titles']}
						<a href="{$_link_base}shows/detail/{$r['show_id']}" style="color:#acacac">more →</a>
						</p>
					</blockquote>
				</span>                           
				</div>

	 </li>

EOT;
}





$to =  $_email ;//"hello@hello.com";
$sender = "hello@snackfeed.com";

$subject = 'snackfeed cheese ' . date("M d ");
$message = <<<EOT
<html>
<body>


<h3 ><a style="font-family:'Lucida Grande',Verdana,Helvetica,Arial,sans-serif; font-size: 20pt; color:#DB0048" href="{$_link_base }feed">Your snackfeed Digest</a></h3>


<ol>
$content
</ol>


<p/>

<h4>Thanks,</h4>
Your snaqfeed team....


</body></html>
EOT;


//echo $message; die();



$headers = "From: " . $sender . "<" . $sender . ">\n";
$headers .= "Reply-To: " . $sender ." <" . $sender . ">\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html\n"; 
mail($to,$subject,$message,$headers);

echo "MAIL SENT TO: " . $to . "<br/>"; 

?>

