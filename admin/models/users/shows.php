<?
$_user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '0';

$rowcount = 0;
$sql = " SELECT  * ";
$sql .= " FROM users WHERE user_id = '" . $_user_id . "';";
$q = DB::query($sql);


$win_title= "Shows for user: " . $q[0]['email'];




$rowcount = 0;
$sql = " SELECT *,(SELECT COUNT(*) FROM user_shows WHERE user_shows.show_id = shows.show_id AND user_shows.user_id = '" . $_user_id ."') AS count 
	FROM shows 
	ORDER BY title";

$q = DB::query($sql);



?>