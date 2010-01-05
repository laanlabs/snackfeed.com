<?

class Search {
	
	
	public static function youtube($req) {
		
		global $req_login; $req_login = false;
		
		global $q, $offset;
		
		global $results, $video_results, $type_data, $source_data, $q, $t, $s, $c, $o, $ob, $vTotal;
		
		global $youtube_top_rated , $youtube_popular_videos , $youtube_hot_searches ;
		
		require_once LIB.'/you_tube_helper.php';
		
		
		$result= false;
		
		$c = 25;
		
		global $results_data;
		$q =  $req['q'];
		
		
		$youtube_hot_searches = YouTubeHelper::get_most_linked_today();
		
		// If they are just hitting the youtube search page for the first time.
		if ( empty($q) ) {
			
			
			
			$youtube_top_rated = YouTubeHelper::get_top_rated_today();
			$youtube_popular_videos = YouTubeHelper::get_most_viewed_today();
			//$youtube_hot_searches = YouTubeHelper::get_most_linked_today();
					
			return;
			
		}
		
		$o = isset( $req['o'] ) ? $req['o'] : 0;
		$ob = isset( $req['ob'] ) ? $req['ob'] : 'relevance';
		
		
		
		$results_data = YouTubeHelper::perform_search( array('query' => $q , 'start-index'=>($o+1) , 'max-results'=>$c , 'orderby'=>$ob ) );
		
		
		$video_results = $results_data['videos'];
		
		
		$vTotal = $results_data['total'];
			
			
			
			if (array_key_exists('json', $req)) {
				
				$data = array( "videos" => $results_data['videos'] , "total" => $results_data['total'] );
				echo json_encode($data); die();
				
			//} else {
			//	render_data_as_xml($data);
			}
		
			
	}
	
	
	
	public static function _default($req)
	{
		
		global $req_login; $req_login = false;
		
		global $results, $results_data, $type_data, $source_data, $q, $t, $s, $c, $o, $ob;
		global $shows_data, $yt_data, $yt_total;
		
			
		$result= false;	
		$c = 25;
	
		if (!empty($req['q']))
		{
			$results = true;
			
			$o = isset($req['o']) ? $req['o'] : 0;
			$s = isset($req['s']) ? $req['s'] : '';
			$t = isset($req['t']) ? $req['t'] : '';
			$ob = isset($req['ob']) ? $req['ob'] : 'rank-DESC';
			
			$_ob = str_replace("-", " " , $ob);
			
			$q =  "" . $req['q'] . "";
			
			
			
		$conditions = "";
		if (!empty($s)) {
			$conditions .= " AND v.show_id = ".quote_csv($s)." ";
			
		}
		
		if (!empty($t)) {
			$conditions .= " AND v.video_type_id = {$t} ";
			
		}
			
		if (array_key_exists("date", $req)) {	
			$conditions .= " AND v.date_added > '{$options['date']}' ";
			
		}
			
		
		$tmp = self::s_search($q, $c, $o);
		$results_data = $tmp[1];
		$results = $tmp[0];
		//print "Query '$q' retrieved $res[total] of $res[total_found] matches in $res[time] sec.\n";

		
		if ($results['total_found'] < $c ) $c = $results['total_found'];

		
		//get show data
		if (!empty($q)) $req['filter'] = $q;	
		$defaults = array("order" => "title-asc", "limit" => 20, "offset" => 0);
		$options = array_merge($defaults, $req);
		$shows_data = Show::find($options);
		

		require_once LIB.'/you_tube_helper.php';
		$yt_resutls = YouTubeHelper::perform_search( array('query' => $q , 'start-index'=>($o+1) , 'max-results'=>20 , 'orderby'=>'relevance' ) );

		$yt_data = $yt_resutls['videos'];
		
		
		$yt_total = $yt_resutls['total'];

		
			
		$q = htmlspecialchars(stripslashes($q));
		
		}
		
		
		
		
		
		if (array_key_exists('json', $req)) {
			
			$data = array( "videos" => $results_data , "total" => $vTotal );
			echo json_encode($data); die();
			
		//} else {
		//	render_data_as_xml($data);
		}
		
	}
	
	
public static function advanced($req)
	{
		
		global $req_login; $req_login = false;
		
		global $results, $results_data, $type_data, $source_data, $q, $t, $s, $c, $o, $ob, $vTotal;
		
			
		$result= false;	
		$c = 25;
	
		if (!empty($req['q']))
		{
			$results = true;
			
			$o = isset($req['o']) ? $req['o'] : 0;
			$s = isset($req['s']) ? $req['s'] : '';
			$t = isset($req['t']) ? $req['t'] : '';
			$ob = isset($req['ob']) ? $req['ob'] : 'rank-DESC';
			
			$_ob = str_replace("-", " " , $ob);
			
			$q =  $req['q'];
			
		$conditions = "";
		if (!empty($s)) {
			$conditions .= " AND v.show_id = ".quote_csv($s)." ";
			
		}
		
		if (!empty($t)) {
			$conditions .= " AND v.video_type_id = {$t} ";
			
		}
			
		if (array_key_exists("date", $req)) {	
			$conditions .= " AND v.date_added > '{$options['date']}' ";
			
		}
			
			
			$sql = "
			SELECT v.title, v.detail, v.video_id, v.show_id,
			v.season, v.episode, 
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
		
			
			FROM videos AS v
			LEFT OUTER JOIN sources ON v.source_id = sources.source_id
			JOIN shows ON v.show_id = shows.show_id
		
			WHERE {$conditions}
			AND v.parent_id = '0'
			ORDER BY title
		
			
		";
			
		
		$sql = "
			SELECT v.video_id, v.title, v.detail, v.thumb, 
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub,
			MATCH( v.title, v.detail, s.title ) AGAINST ('{$q}' IN BOOLEAN MODE) AS rank
			FROM videos v INNER JOIN shows s on v.show_id = s.show_id
			WHERE MATCH( v.title, v.detail, s.title ) AGAINST ('{$q}' IN BOOLEAN MODE) > 0
			AND v.parent_id = '0'
			{$conditions}
			ORDER BY {$_ob }
			LIMIT {$o}, {$c}
		";
			
		
		$results_data = DB::query($sql);
		
		$sql = "
		SELECT lkp.video_type, v.video_type_id, count(v.video_type_id) as vCount
		FROM videos v INNER JOIN shows s on v.show_id = s.show_id
			INNER JOIN lkp_video_type lkp ON v.video_type_id = lkp.video_type_id
		WHERE MATCH( v.title, v.detail, s.title  ) AGAINST ('{$q}' IN BOOLEAN MODE) > 0
		AND v.parent_id = '0'
		{$conditions}
		GROUP BY v.video_type_id
		ORDER BY v.video_type_id
			";
		
		$type_data = DB::query($sql);
		
		
		$sql = "
		SELECT s.title, v.show_id, count(v.video_id) as vCount
		FROM videos v INNER JOIN shows s on v.show_id = s.show_id
		WHERE MATCH( v.title, v.detail, s.title  ) AGAINST ('{$q}' IN BOOLEAN MODE) > 0
		AND v.parent_id = '0'
		{$conditions}
		GROUP BY v.show_id
		ORDER BY s.title
			";
		
		$source_data = DB::query($sql);
		
		
		$vTotal = 0;
		for ($i = 0 ; $i < count($type_data) ; $i++) { $vTotal += $type_data[$i]['vCount']; } 
		
		
		
		if (!empty($q)) $req['filter'] = $q;	
		$defaults = array("order" => "title-asc", "limit" => $c, "offset" => $o);
		$options = array_merge($defaults, $req);
		
		$shows_data = self::find($options);
		
		
		
		
		
			
		$q = htmlspecialchars(stripslashes($q));
		
		
		
		
		
		
		}
		
		if (array_key_exists('json', $req)) {
			
			$data = array( "videos" => $results_data , "total" => $vTotal );
			echo json_encode($data); die();
			
		//} else {
		//	render_data_as_xml($data);
		}
		
	}	


private static function s_search($q, $limit=20, $offset=0 )
{

	require_once ( "/var/www/sf-admin/lib/sphinxapi.php" );	
	$mode = SPH_MATCH_ALL;
	
	$q= stripslashes($q);

	
	if (ereg('^\"(.*)\"+$', $q)) $mode = SPH_MATCH_PHRASE;
	if (ereg("^\'(.*)\'+$", $q)) $mode = SPH_MATCH_PHRASE;
	
	
	$ranker = SPH_RANK_PROXIMITY_BM25;
	$index = "videos";
	
	$cl = new SphinxClient();
	$cl->SetServer( "localhost", 3312 );
	$cl->SetConnectTimeout ( 1 );
	$cl->SetWeights ( array ( 100, 1 ) );
	$cl->SetMatchMode ( $mode );
	if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
	if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
	if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
	if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
	if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
	$cl->SetLimits ( (int)$offset, (int)$limit );
	$cl->SetRankingMode ( $ranker );
	$cl->SetArrayResult ( true );
	$res = $cl->Query ( $q, $index );
	
	
	//print "Query '$q' retrieved $res[total] of $res[total_found] matches in $res[time] sec.\n";
	

	
	$ids = "0"; 
	for ($i=0; $i < count($res['matches']); $i++) { 
		$ids .= "," .$res['matches'][$i]['id'];
	}

	
	
	$sql = "SELECT  v.video_id, v.title, v.detail, v.show_id, v.thumb, s.title as show_title,
			if ( (DATEDIFF(v.date_pub, now()) = 0), DATE_FORMAT(v.date_pub, '%l:%i %p'), DATE_FORMAT(v.date_pub, '%b %e') ) as date_pub
			FROM videos v INNER JOIN shows s on v.show_id = s.show_id
			WHERE video_iid IN ($ids);";
	
	$results = array();
	$results[0] = $res;			
	$results[1] = DB::query($sql);			
	
	return $results;
	
}











	
}





?>