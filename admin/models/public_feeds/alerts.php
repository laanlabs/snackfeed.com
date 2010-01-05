<?




$win_title = "News Alerts For Public Feed";


$sql = " 
 SELECT *
 FROM feed_publics p
 WHERE type = 4
 ORDER BY ts DESC;";
$q = DB::query($sql);



?>