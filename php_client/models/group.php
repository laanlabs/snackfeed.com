<?

class Group 
{


//lists upcoming groups
public static function _default($req)
{


$sql = "SELECT g.*, v.title as video_title, v.thumb, v.detail as video_detail
		FROM groups g
		LEFT OUTER JOIN videos v ON g.content_id = v.video_id";

}
	

public static function watch($req)
{
	global $req_login; $req_login = false;		


	
	
}

	

public static function users($req)
{
		global $_t; $_t = "empty";
	global $req_login; $req_login = false;		


echo "Buddy_Guy" . rand(0,1000);
	
	
}
	
	

public static function changeNick($req)
{
	global $_t; $_t = "empty";
	
	global $req_login; $req_login = false;		


	
	
}


	
	
}

?>