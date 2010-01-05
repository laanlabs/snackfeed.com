<?
require ( "/var/www/sf-admin/lib/sphinxapi.php" );


$mode = SPH_MATCH_ALL;
$limit = 20;
$ranker = SPH_RANK_PROXIMITY_BM25;

$index = "videos";
$q = "palin";

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
$cl->SetLimits ( 0, 20 );
$cl->SetRankingMode ( $ranker );
$cl->SetArrayResult ( true );
$res = $cl->Query ( $q, $index );



$ids = "0"; 
for ($i=0; $i < count($res['matches']); $i++) { 
	$ids .= "," .$res['matches'][$i]['id'];
}


echo $ids;



if ( $res===false ||  $cl->GetLastWarning() )
{
	print "Query failed: " . $cl->GetLastError() . ".\n";
	print "WARNING: " . $cl->GetLastWarning() . "\n\n";

}		

//$res['matches'][$i]['id']

	print "Query '$q' retrieved $res[total] of $res[total_found] matches in $res[time] sec.\n";
	print "Query stats:\n";
	if ( is_array($res["words"]) )
		foreach ( $res["words"] as $word => $info )
			print "    '$word' found $info[hits] times in $info[docs] documents\n";
	print "\n";

exit;



?>