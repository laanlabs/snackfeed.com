<?
setcookie("wp_username", $_POST['wp_username'], time()+60*60*24*30, "/" , ".snackfeed.com");
setcookie("wp_password", $_POST['wp_password'], time()+60*60*24*30, "/" , ".snackfeed.com");
setcookie("wp_blog_url", $_POST['wp_blog_url'], time()+60*60*24*30, "/" , ".snackfeed.com");

?>
Your Word Press Blog Responded: 
<?php
	include("xmlrpc.inc");
	
	$_loc = $_POST['wp_blog_url'];
	$_loc = str_replace("http://", "", $_loc );
	$tmp = explode("/" , $_loc);
	$_host = $tmp[0];
	$_uri = str_replace($_host, "", $_loc );
	
	//make sure we have trailing slash
	if (substr($_uri  , strlen($_uri)-1, 1 ) != "/") $_uri .= "/";

	$_uri_base = $_uri;
	
	$_uri = $_uri . "xmlrpc.php";
	
	if ($_POST['wp_publish'] == "") $_POST['wp_publish'] = 1;
	

	$_message = stripslashes($_POST['message']);
	$_message  =	str_replace("’" , "'", $_message);
	$_message  =	str_replace('&#039;', '&apos;', htmlspecialchars($_message , ENT_QUOTES));
	
	
	$_body = html_entity_decode(stripslashes($_POST['wordPress_data'])) . $_message  ;
	
	
/*	
	$myFile = "sample.txt";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $_body);
	fclose($fh);
*/	

	//wp_categories
	$_cats = array();
	if (!empty($_POST['wp_categories']))
	{
		$_cats =  explode(",", $_POST['wp_categories']);
	}  
	
	
	
	if (!empty($_POST['wp_image_url']))
	{
		$_body =  '<img src="' . trim($_POST['wp_image_url']) . '" />' . $_body;
	}
	

	
	$c = new xmlrpc_client($_uri, $_host, 80);

	$content['title']= stripslashes($_POST['title']);
	$content['description']=  $_body;
	$content['categories'] = $_cats;
	$x = new xmlrpcmsg("metaWeblog.newPost",
	                    array(php_xmlrpc_encode("1"),
                        php_xmlrpc_encode($_POST['wp_username']),
                        php_xmlrpc_encode($_POST['wp_password']),
                        php_xmlrpc_encode($content),
                        php_xmlrpc_encode($_POST['wp_publish'])));

	$c->return_type = 'phpvals';
	$r =$c->send($x);
	if ($r->errno=="0")
	{
		$p_url = "http://" . $_host . $_uri_base . "?p=" . $r->val . "&preview=true";
		echo "Successfully Posted to <a href='{$p_url }' target='_new' >{$p_url}</a>";

	} else {
		echo "POST FAILED!!! Reason: ";
		

		
		switch ($r->errno)
		{
			case '2':
			 $vMsg = "this was not a valid blog url";
			 break;
			case '5':
			 $vMsg = "this was not a valid blog url";
			 break;
			case '403':
			 $vMsg = "Invalid username/password combination.";
			 break;
			default:
			 $vMsg 	= "unknown reason -- most probably bad URL. Details: " . $r->errstr;
		}
		
		//$->errstr
		
		echo $vMsg . " Click <a href='javascript:showPost()'>here</a> to try again.";
		
		//print_r($r);
              }
?>