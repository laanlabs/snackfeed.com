<?
$_package_id = isset($_GET['package_id']) ? $_GET['package_id'] : '0';

$rowcount = 0;
$sql = " SELECT  * ";
$sql .= " FROM packages WHERE package_id = '" . $_package_id . "';";
$q = DB::query($sql);


$win_title= "Shows for Package: " . $q[0]['name'];




$rowcount = 0;
$sql = " SELECT *,(SELECT COUNT(*) FROM package_shows WHERE package_shows.show_id = shows.show_id AND package_shows.package_id = '" . $_package_id ."') AS count 
	FROM shows 
	ORDER BY title";

$q = DB::query($sql);



?>