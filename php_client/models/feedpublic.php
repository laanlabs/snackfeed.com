<?



class FeedPublic {
	
 	function __construct()
	{
	

	}



	public static function _default($req)
	{
		global $req_login; $req_login = false;
		
		global $header_block, $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		$header_block .= '<link rel="alternate" type="application/rss+xml" title="snackfeed public feed [RSS]" href="http://snackfeed.com/public/rss">
';
		global $videos_data;
		
		$sql = " SELECT f.*, s.title as show_title, s.title_prefix
				 FROM feed_publics f
					LEFT OUTER JOIN shows s ON f.show_id = s.show_id
				 WHERE f.status = 1	
				 ORDER BY date_added desc
				 LIMIT 100 ";
		
		$videos_data = DB::query($sql);
		

		
		$sf_meta_desc .= " - ";
		for ($i=0; $i < count($videos_data) ; $i++) 
		{
			$sf_meta_desc .= substr( $videos_data[$i]['title'] , 0 , 44 ) . " - " . $videos_data[$i]['show_title'] . " - ";
			$sf_meta_keywords .= htmlspecialchars(stripslashes($videos_data[$i]['show_title'])) . ", ";
				if ($i > 20 ) break;
		}
		
		$sf_meta_title = "a taste of what videos are on inside snackfeed right now";	
		$sf_meta_desc = htmlspecialchars(stripslashes($sf_meta_desc));		
		
	}


	public static function trends($req)
	{
		global $req_login; $req_login = false;
		global $videos_data;
		global $header_block, $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		
		$sql = "SELECT t.trend_id, t.order_by, 
				  (select count(t1.trend_id) FROM google_trend_videos t1 WHERE t1.trend_id = t.trend_id) as vCount,
				t.title as trend_title, t.detail as trend_detail, t.source, t.source_url, t.date_updated,
				tv.title, tv.detail, tv.thumb, tv.video_id, tv.video_type, tv.ext_id
				FROM google_trends t
				  LEFT OUTER JOIN google_trend_videos tv ON t.trend_id = tv.trend_id
				
				WHERE t.order_by <= 20
				ORDER BY FLOOR(UNIX_TIMESTAMP(t.date_updated)/10000) DESC, t.order_by, tv.video_type, tv.ts DESC 
					LIMIT 200;";
		
		$videos_data = DB::query($sql);
		
		

		$sf_title = "top google trends video mashup";
		$sf_meta_desc = "videos that match the following trends: ";
		$sf_meta_keywords = "";		
		
		for ($i=0; $i < 30 ; $i++) { 
			$_trend = htmlspecialchars(stripslashes($videos_data[$i]['trend_title'] ));
			$_title = htmlspecialchars(stripslashes($videos_data[$i]['title']));
			$_detail =  substr(htmlspecialchars(stripslashes($videos_data[$i]['trend_detail'])), 0, 50);
			
			
			$sf_meta_desc .=  $_trend . " " . $_detail . " "; 
			$sf_meta_keywords .= $_trend . "," . $_title. ",";
		
		}
		
		
		$header_block .= '<link rel="alternate" type="application/rss+xml" title="trends video feed [RSS]" href="http://snackfeed.com/public/trends_rss">';			
			
		
		
	}


	public static function trends_rss($req)
	{
		include LIB."/rss_helper.php";
		
		global $req_login; $req_login = false;
		global $videos_data;
		
		$sql = "SELECT t.trend_id, t.order_by, 
				  (select count(t1.trend_id) FROM google_trend_videos t1 WHERE t1.trend_id = t.trend_id) as vCount,
				t.title as trend_title, t.detail as trend_detail, t.source, t.source_url,
				tv.*
				FROM google_trends t
				  LEFT OUTER JOIN google_trend_videos tv ON t.trend_id = tv.trend_id
				
				WHERE t.order_by <= 20
				ORDER BY FLOOR(UNIX_TIMESTAMP(t.date_updated)/100) DESC, t.order_by, tv.video_type, tv.ts DESC 
					LIMIT 200;";
		
		
		$videos_data = DB::query($sql);
		
		$rss_meta = array();
		$rss_meta['title'] =  "trends  video feed";
		$rss_meta['desc'] = "a taste of the videos on trending on search terms" ;
		$rss_meta['url'] = "http://snackfeed.com/public/trends_rss/";
		
		RssHelper::print_rss($rss_meta, $videos_data);
		
	}


	public static function latest($req)
	{
		global $req_login; $req_login = false;
		
		global $header_block, $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		$header_block .= '<link rel="alternate" type="application/rss+xml" title="snackfeed public feed [RSS]" href="http://snackfeed.com/public/rss">
';
		global $videos_data;
		
		$sql = " SELECT v.*, s.title as show_title, s.title_prefix
				 FROM videos v
					LEFT OUTER JOIN shows s ON v.show_id = s.show_id
				 WHERE  1	
				 ORDER BY v.date_added DESC
				 LIMIT 100 ";
		
		$videos_data = DB::query($sql);
		

		
		$sf_meta_desc .= " - ";
		for ($i=0; $i < count($data) ; $i++) 
		{
			$sf_meta_desc .= substr( $videos_data[$i]['title'] , 0 , 44 ) . " - " . $videos_data[$i]['show_title'] . " - ";
			$sf_meta_keywords .= htmlspecialchars(stripslashes($videos_data[$i]['show_title'])) . ", ";
				if ($i > 20 ) break;
		}
		
		$sf_meta_title = "a taste of what videos are on inside snackfeed right now";	
		$sf_meta_desc = htmlspecialchars(stripslashes($sf_meta_desc));		
		

		
		
	}


	public static function rss($req)
	{
		global $req_login; $req_login = false;
		

		
		include LIB."/rss_helper.php";
		
		$sql = " SELECT f.title, f.detail, f.thumb, f.video_id, f.date_added as date_formatted, 
				s.title as show_title
				 FROM feed_publics f
					LEFT OUTER JOIN shows s ON f.show_id = s.show_id
				 WHERE f.status = 1	
				 ORDER BY ts desc	
				 LIMIT 50 ";
		
		$data = DB::query($sql);		
		
		$rss_meta = array();
		$rss_meta['title'] = "snackfeed public feed";
		$rss_meta['desc'] = "a taste of the videos on snackfeed";
		$rss_meta['url'] = "http://snackfeed.com/public/rss";
		
		RssHelper::print_rss($rss_meta, $data);
	}	
	
	public static function item_delete($req)
	{
		
		if (User::$user_su != '1') die("nonnono....");
		
		$sql = "UPDATE feed_publics SET status = 0 WHERE public_id = {$req['id']} ;";
		DB::query($sql, false);
		header("Location: /public");
			
		
		
	}
	
	
	public static function twitter($req)
	{
		global $req_login; $req_login = false;
		global $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		global $data;
	
		
		
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-2,date("Y")) );
	
		$sql = " 
		SELECT count, youtube_id, tweet, tw_id, from_user, title, date_added, detail
		FROM ext_twitter_youtube
		WHERE status = 1
		 AND date_added > '{$_date}'	
		GROUP BY youtube_id
		ORDER BY count DESC
		LIMIT 100;";
		
		//echo $sql; die();
		
		$data = DB::query($sql);
	
		for ($i=0; $i < count($data) ; $i++) 
		{
			$sf_meta_desc .= substr( $data[$i]['title'] , 0 , 44 ) . " - ";
			$sf_meta_keywords .= htmlspecialchars(stripslashes($data[$i]['title'])) . ", ";
				if ($i > 20 ) break;
		}
		
		$sf_title = "snackfeed - videos that are popular on twitter in last 48 hours";
		$sf_meta_title = "videos that are popular on twitter in last 48 hours";	
		$sf_meta_desc = htmlspecialchars(stripslashes($sf_meta_desc));		
		
		
	}



	public static function friendfeed($req)
	{
		global $req_login; $req_login = false;
		global $sf_title, $sf_meta_title, $sf_meta_keywords, $sf_meta_desc;
		global $data;
	
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-2,date("Y")) );
	
		$sql = " 
		SELECT
		(count(youtube_id)*3 + sum(likes) + sum(comments))/(TIMESTAMPDIFF(HOUR,date_added,now())^1.5)  as points,
	    count(youtube_id) as sCount,
    	(count(youtube_id)*3 + sum(likes) + sum(comments)) as vCount, sum(likes) as likes, sum(comments) as comments,     	youtube_id,
		title, GROUP_CONCAT(DISTINCT ff_id) as ff_id,
		max(date_added) as date_added

		FROM ext_friendfeed_youtube
		WHERE 1
		AND date_added > '{$_date}'	
		GROUP BY youtube_id, title
		ORDER BY points DESC, likes DESC, comments DESC 
		LIMIT 100;";
		
		//echo $sql; die();
		
		$data = DB::query($sql);
	
			for ($i=0; $i < count($data) ; $i++) 
		{
			$sf_meta_desc .= substr( $data[$i]['title'] , 0 , 44 ) . " - ";
			$sf_meta_keywords .= htmlspecialchars(stripslashes($data[$i]['title'])) . ", ";
				if ($i > 20 ) break;
		}
		
		$sf_title = "snackfeed - videos that are popular on friendfeed in last 48 hours";
		$sf_meta_title = "videos that are popular on friendfeed in last 48 hours";	
		$sf_meta_desc = htmlspecialchars(stripslashes($sf_meta_desc));		
		
	}

	public static function popular_friendfeed($req)
	{
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-2,date("Y")) );
		$sql = "
		SELECT count(youtube_id)*3 + sum(likes) + sum(comments) as vCount, youtube_id,
			count(youtube_id) as vCounts,
			sum(likes) as likes,
			sum(comments) as comments
			FROM ext_friendfeed_youtube
			WHERE 1 AND date_added >  '{$_date}'
			GROUP BY youtube_id
			HAVING vCount > 80
			ORDER BY vCount DESC LIMIT 200;
		";
		
		
		$q = DB::query($sql);
		
		foreach ($q as $r) {
			echo "video " . $r['vCount'] . " - " . $r['youtube_id'] . "<br/>" ;
			$_comment = " found {$r['vCounts']} times ";
			if ($r['likes'] > 0 ) $_comment .= " with {$r['likes']} likes and {$r['comments']} comments ";
			self::add_ext(array("id" => $r['youtube_id'], "comment" => $_comment, "type" => "101"   ));
		}
		
		die();
	}


	public static function add_ext($req)
	{
		global $_t; $_t = "empty";
		
		$_date = date("Y-m-d G:i:s");
		
		$_video_id = Video::ext( array( "id" => $req['id'], "t" => "yt", "noredir" => true));

		$req['weight'] =  empty($req['weight']) ? "50" : $req['weight'];


		$sql = "INSERT INTO feed_publics (video_id, show_id, 
							type, title, 
							detail, thumb, comment, weight, date_added,
							source_id, source_title, source_detail
						) 
				SELECT video_id, show_id, '{$req['type']}', title, detail, thumb, '{$req['comment']}' , 
					'{$req['weight']}' , '{$_date}',
					'{$req['source_id']}', '{$req['source_title']}', '{$req['source_detail']}'
				FROM videos WHERE video_id = '{$_video_id}'
				ON DUPLICATE KEY UPDATE comment = '{$req['comment']}'
				;";

		DB::query($sql , false);	
		
		echo "video added to public feed";

	}


	public static function recommend_video($req)
	{
		
		global $_t; $_t = "empty";
		$_date = date("Y-m-d G:i:s");

		$sql = "INSERT INTO feed_publics (video_id, show_id, type, title, 
			detail, thumb, comment, weight, date_added) 
				SELECT video_id, show_id, 2, title, detail, thumb, '{$req['comment']}' , 
					'{$req['weight']}' , '{$_date}'
				FROM videos WHERE video_id = '{$req['video_id']}'
				ON DUPLICATE KEY UPDATE comment = '{$req['comment']}'
				;";

			//echo $sql; 

		DB::query($sql , false);	
		
		echo "video added to public feed";
		
		
		
	}	
	
	
	public static function keywords($req)
	{
		
	global $req_login; $req_login = false;	
	global $wWords, $_max, $_min, $_title	;
	
	$words =  array();
	$wordKey = array();
	$no_words = array();
	$wWords = array();
	
	if ($req['id'] == 'today')
	{
		$_title = "Today's Top Indexes";
		$file = "/var/www/sf-public/webroot/static/data/daily.txt";
	} else {
		$_title = "Top All-Time Video Indexes";
		$file = "/var/www/sf-public/webroot/static/data/all.txt";
	}

	$row = 0;
	$handle = fopen($file, "r");
	while (($data = fgetcsv($handle, 1000, " ")) !== FALSE) {
		$_key = $data[0];
		$words[$row]=  $data[0];
		$wordKey[$_key]=  $data[1];
		//$words[$row][1]=  $data[1];
	    $row++;
	}
	fclose($handle);
	
	$file = "/var/www/sf-public/webroot/static/data/stopwords.txt";
	$row = 0;
	$handle = fopen($file, "r");
	while (($data = fgetcsv($handle, 1000, " ")) !== FALSE) {
		$no_words[$row]=  $data[0];
		//$words[$row][0]=  $data[0];
		//$words[$row][1]=  $data[1];
	    $row++;
	}
	fclose($handle);
	
	$result = array_diff($words, $no_words);
	
	$k=0;
	for ($i=0; $i < count($result) ; $i++) { 
		$_key = $result[$i];
	
		if (strlen($_key) > 0 ) {
		$wWords[$k][0] = $result[$i];
		$wWords[$k][1] =  $wordKey[$_key];
		$k++;
		}
	}
	
	function compare($x, $y)
	{
	if ( $x[1] == $y[1] )
	 return 0;
	else if ( $x[1] < $y[1] )
	 return 1;
	else
	 return -1;
	}
	
	usort($wWords, 'compare');
	
	$_max = $wWords[0][1];
	$_min = $wWords[count($wWords)][1];

	}
	
	
	
	
}

?>