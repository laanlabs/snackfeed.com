<?

$win_title = "Invite Code List";

$rowcount = 0;
$sql = " SELECT * 
 	FROM invites
	ORDER BY code ASC;";
$q = DB::query($sql);



  

?>