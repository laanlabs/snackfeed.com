<?
	require_once(APP_ROOT . "/lib/jsonrpc/xmlrpc.inc");
	


	$_uri = "/xmlrpc.php";
	
	
	
	$_publish = 1;
	
	//echo $_uri;
	
	$c = new xmlrpc_client($_uri, $_host, 80);

	$content['title'] = $wp_title;
	$content['description']=  $wp_body;
	$content['categories'] = $wp_cats;
	$x = new xmlrpcmsg("metaWeblog.newPost",
	                    array(php_xmlrpc_encode("1"),
                        php_xmlrpc_encode($_username),
                        php_xmlrpc_encode($_password),
                        php_xmlrpc_encode($content),
                        php_xmlrpc_encode($_publish)));

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