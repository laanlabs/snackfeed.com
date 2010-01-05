<?

$_found_array = array();
$_found_array[0] = "I found this on __SHOW_NAME__ .";
$_found_array[1] = "I love __SHOW_NAME__ and they just posted some new video i found ";
$_found_array[2] = "this is an interesting video from  __SHOW_NAME__ on <a href=\"http://snackfeed.com\">snackfeed.com</a>.";
$_found_array[3] = "FROM  __SHOW_NAME__ ";
$_found_array[4] = "another great video from  __SHOW_NAME__ ";
$_found_array[5] = " __SHOW_NAME__ ";
$_found_array[6] = " __SHOW_NAME__ has posted another video. ";
$_found_array[7] = "you have to watch this one -- very interesting from  __SHOW_NAME__ ";
$_found_array[8] = "something else i like from  __SHOW_NAME__ ";
$_found_array[9] = "one for all my friends out there from  __SHOW_NAME__ ";
$_found_array[10] = " love this show -  __SHOW_NAME__ - and here is another video from it .. ";







$sf_url = "http://snackfeed.com/videos/detail/";
$_now = date("Y-m-d G:i:s");

$sql = " 
	SELECT  blog_id
 	FROM blogs 
	WHERE status = 1
	AND process_date_next < '" . $_now . "'
 	LIMIT 1; ";

$blogs_data = DB::query($sql);




//set the blog id to the next one if there isnt
$_GET['blog_id'] = isset($_GET['blog_id']) ? $_GET['blog_id'] : $blogs_data[0]['blog_id'] ;

echo $_GET['blog_id'];

if (empty($_GET['blog_id']))  die("no blog found to process");

$_base_table = "blog";
include LIB."/calls/db_edit.php";

echo $_title;
echo $_process_hour_interval;

$_date_try_next = date("Y-m-d G:i:s", mktime(date("G")+ $_process_hour_interval,0,0,date("m"),date("d"),date("Y")) ); 

echo "<hr>" . $_date_try_next;





		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")- $_process_days_offset,date("Y")) );

		
		$joins = ""; $condidtions = "";
		
		if ($_source_type == 1) //type is channel
		{
			$joins .= "JOIN channel_videos c ON c.video_id = v.video_id AND c.status > 0 AND c.channel_id = '{$_source_id}'";
			
		} else if($_source_type == 2) //type is show
		{
			$condidtions = " AND v.show_id = '{$_source_id}' ";
		}


		$sql = "
			SELECT v.video_id, v.title, v.detail, v.url_source,
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
			IF(LOCATE('http',v.thumb)>0, v.thumb, concat('" . BASE_URL ."', v.thumb) ) as thumb,
			sh.title AS show_title	
			
			FROM videos v
				LEFT OUTER JOIN sources sc ON v.source_id = sc.source_id
				JOIN shows sh ON v.show_id = sh.show_id
					{$joins}
		
			
			WHERE 1
			{$condidtions}
			AND v.date_added > '{$_date}'
			AND v.parent_id = '0'
			AND v.video_type_id IN ({$_video_type_ids})
			AND v.video_id NOT IN (SELECT video_id FROM blog_posts WHERE blog_id = '{$_blog_id}' )

			ORDER BY v.date_added DESC
			LIMIT {$_video_count}

		";

//echo $sql; die();


$q = DB::query($sql);

echo "COUNT: " . count($q);




for ($ki=0; $ki < count($q) ; $ki++) { 

	$random = rand( 0  , count($_found_array)-1);
	$_blog_prefix = str_replace("__SHOW_NAME__", stripslashes($q[$ki]['show_title']) ,$_found_array[$random] );

	$wp_title = stripslashes($q[$ki]['title']);
	
	$sf_vid_url = $sf_url . $q[$ki]['video_id'] . "/" . preg_replace('/\W/', '-', $q[$ki]['title']);; 
	
	$wp_body = "<a href=\"{$sf_vid_url}\"><img src=\"{$q[$ki]['thumb']}\" align=\"left\" border=0 style=\"padding:5px\" ></a> " ;
	
	$wp_body .= "{$_blog_prefix}<br/>" ; 
	$wp_body .= stripslashes($q[$ki]['detail']); 
	$wp_body .=  "<br><a href=\"{$sf_vid_url}\">watch this video</a> " ;
	
	echo "POSTING: " . $wp_title . $wp_body.  "<br/>";

	
	$_host =  $_url;
	
	if ($_blog_type == 1) //for word press
	{
		include 'publish_wp.php';
	} else if ($_blog_type == 2) //for word press
	{
		include 'publish_blogger.php';
	} else if ($_blog_type == 3) //for word press
	{
		include 'publish_tumblr.php';
	}


	//insert this video so it doesn get redon
	$sql = "INSERT INTO blog_posts SET 
		blog_id = '{$_blog_id}', 
		video_id = '{$q[$ki]['video_id']}', 
		source_id = '{$_source_id}',  
		source_type = '{$_source_type}'
		
		ON DUPLICATE KEY UPDATE source_type = source_type
		";
		
		echo $sql;
		
		DB::query($sql, false);


}



$_t = "empty";



$sql = " 
	UPDATE blogs 
	SET 
	process_date_last = '{$_now}',
	process_date_next = '{$_date_try_next}'
	WHERE blog_id = '{$_blog_id}' ";



DB::query($sql, false)


?>