<?


	// Data for new record
	$post_type  = 'regular';
	
	
	
	$post_var = array(
        'email'     => $_username,
        'password'  => $_password,
        'type'      => $post_type,
        'title'     => $wp_title,
        'generator' => 'snackFeed'
    );
	
	if ($post_type == 'regular')
	{
		$post_var = array_merge($post_var, array('body' =>	$wp_body ));
	}

	if ($post_type == 'quote')
	{

		$tArr = array(
				'quote' 	=>	$_POST['message']
						);
				$post_var = array_merge($post_var, $tArr );
	}

	if ($post_type == 'photo')
	{
		$tArr = array(
				'caption' 	=>	$_POST['message'],
				'source'	=>  $_POST['tumblr_image']		);
		$post_var = array_merge($post_var, $tArr );
	}


	if ($post_type == 'video')
	{
		$tArr = array(
				'caption' 	=>	$_POST['message'],
				'embed'		=> trim(html_entity_decode(stripslashes($_POST['tumblr_data'])))	);
		$post_var = array_merge($post_var, $tArr );
	}

	//print_r($post_var);
	//die();


	//'caption'   => $_POST['message'],
	//'embed'		=> trim(stripslashes($_POST['tumblr_data'])),
	
	// Prepare POST request
	$request_data = http_build_query( $post_var);

	// Send the POST request (with cURL)
	$c = curl_init('http://www.tumblr.com/api/write');
	curl_setopt($c, CURLOPT_POST, true);
	curl_setopt($c, CURLOPT_POSTFIELDS, $request_data);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($c);
	$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
	curl_close($c);

	// Check for success
	if ($status == 201) {
	    echo "Success! The new post ID is $result.\n";
	} else if ($status == 403) {
	    echo 'Bad email or password';
	} else {
	    echo "Error: $result\n";
	}



?>