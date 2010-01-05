<?php

class User {
	
	
	public static $username = 'guest';
	public static $user_id = '0';
	public static $user_su = 0;
	public static $user_default_icon = '/static/images/user_icons/default.jpg';
	public static $key = "greatjob";

	
	
 	function __construct()
	{
	
		
		if (!isset($_COOKIE["ssf_user_id"]))
		{
			self::set_user_cookie(self::$user_id, self::$username, 0);
		} else {

			self::$user_id = ($_COOKIE["ssf_user_id"] != '0') ? self::decrypt(self::$key,$_COOKIE["ssf_user_id"]): '0';
			self::$user_su = $_COOKIE["ssf_user_su"];
			self::$username = $_COOKIE["ssf_username"];
		}
		//PseudoUser::set_cookies(self::$user_id);
	}
	
	public static function landing($req){
		global $req_login; $req_login = false;	
	}

	public static function special($req)
	{
		global $req_login; $req_login = false;
		
		global $_t;
		$_t = "home";
		Show::special($req);
	}	
	
	
	private static function set_user_cookie($_user_id, $_username, $_su = 0)
	{
			setcookie("ssf_user_id", self::encrypt(self::$key, $_user_id), time()+60*60*24*30, "/" , ".snackfeed.com");
			setcookie("ssf_user_su", $_su, time()+60*60*24*30, "/" , ".snackfeed.com");
			setcookie("ssf_username", $_username, time()+60*60*24*30, "/" , ".snackfeed.com");
	}
	
	private static function encrypt($key, $plain_text) {
	  $plain_text = trim($plain_text);
	  $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));
	  $c_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $plain_text, MCRYPT_ENCRYPT, $iv);
	  return base64_encode($c_t);
	}

	private static function decrypt($key, $c_t) {
	  $c_t = base64_decode($c_t);
	  $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_CAST_256,MCRYPT_MODE_CFB));
	  $p_t = mcrypt_cfb (MCRYPT_CAST_256, $key, $c_t, MCRYPT_DECRYPT, $iv);
	  return trim($p_t);
	}
		
	public static function _default($req)
	{
		
		global $data_similar, $data_know;
		
		$_user_id = User::$user_id;
		
		$sql = "
			SELECT DISTINCT u.user_id, u.email, u.name_first, u.name_last, u.nickname, u.thumb, u.bio, u.location, u.url,
			(IF((f.user_id IS NULL ), .3, .9)) * (IF((uf.user_id IS NULL ), .2, .9)) as rank
			FROM users u
			LEFT OUTER 	  JOIN user_followers f ON u.user_id = f.follower_id AND f.user_id = '{$_user_id}'
			LEFT OUTER JOIN user_followers uf ON u.user_id = uf.user_id
					AND uf.follower_id IN 
					(SELECT uf2.user_id FROM user_followers uf2 WHERE uf2.follower_id = '{$_user_id}' )
			WHERE 1
			AND u.user_id != '{$_user_id}'
			-- no following
			AND u.user_id NOT IN (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}') 
			ORDER BY rank DESC
			LIMIT 8";
			
		$data_know = DB::query($sql);	

		$sql = "SELECT u.user_id, count(u.user_id) as vCount,
		 u.nickname, u.email, u.name_first, u.name_last, u.nickname, u.thumb, u.bio, u.location, u.url
		FROM users u
		JOIN user_shows su ON u.user_id = su.user_id AND su.show_id in 

		(SELECT su2.show_id
		FROM user_shows su2 WHERE su2.user_id = '{$_user_id}' )
		WHERE 1
		AND u.user_id != '{$_user_id}'
		AND u.user_id NOT IN (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}')
		GROUP BY u.nickname
		ORDER BY vCount DESC 
		LIMIT 8";
		
		$data_similar = DB::query($sql);	


		
	}	
	
	
	public static function playlists($req)
	{
		
		global $_nav_playlist; $_nav_playlist = "_on";
		
		global $videos_data, $playlist_title, $group_id, $playlists_data;
		
		
		$group_id = isset($req['group_id']) ? $req['group_id'] : 0 ;
		
		
		if (!empty($req['save_playlist'])) $group_id = Video::playlist_save($req['group_title']);
		
		//remove a video from playlist
		if (!empty($req['rem_playlist_id'])) Video::playlist_remove($req['rem_playlist_id']);
		
		//clear the whole playlist
		if (array_key_exists("rem_group_id", $req))Video::playlist_clear($req);
		
		//get playlist
		$playlists_data = Video::playlists_get();
		
		
		$videos_data = Video::playlist_get($group_id);
		$playlist_title = ($group_id != '0') ? $videos_data[0]['group_title']: "default" ;
		
		
		if (array_key_exists("play", $req)) {
			$_url = "/videos/detail/" . $videos_data[0]['video_id'] . "?pl=0&group_id=0&u=" . User::$username  ;
			header("Location: {$_url}");
		}
		
		
		
		
	}
	
	
	
	public static function register_2($req)
	{
		
		global $packages_data;
			
		$packages_data = Show::get_packages(array("limit"=> "3"));
		
	}
	
	public static function register_3($req)
	{
		
		global $users_data;
		
		$sql = "SELECT u.user_id, u.nickname, u.thumb
		FROM users u
		WHERE user_id IN ('fa5a4e3c-474e-102b-9839-001c23b974f2','dfb6d566-3c52-102b-9a93-001c23b974f2','c34e4eb4-83dc-102b-908a-00304897c9c6', '4dfb0b7c-4145-102b-9839-001c23b974f2')
		ORDER BY rand()
		LIMIT 3";
		
		
		$users_data = DB::query($sql);
	
	
		global $data_similar, $data_know;
		
		$_user_id = User::$user_id;
		
		$sql = "
			SELECT DISTINCT u.user_id, u.email, u.name_first, u.name_last, u.nickname, u.thumb, u.bio, u.location, u.url,
			(IF((f.user_id IS NULL ), .3, .9)) * (IF((uf.user_id IS NULL ), .2, .9)) as rank
			FROM users u
			LEFT OUTER 	  JOIN user_followers f ON u.user_id = f.follower_id AND f.user_id = '{$_user_id}'
			LEFT OUTER JOIN user_followers uf ON u.user_id = uf.user_id
					AND uf.follower_id IN 
					(SELECT uf2.user_id FROM user_followers uf2 WHERE uf2.follower_id = '{$_user_id}' )
			WHERE 1
			AND u.user_id != '{$_user_id}'
			-- no following
			AND u.user_id NOT IN (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}') 
			ORDER BY rank DESC
			LIMIT 3";
			
		$data_know = DB::query($sql);	

		$sql = "SELECT u.user_id, count(u.user_id) as vCount,
		 u.nickname, u.email, u.name_first, u.name_last, u.nickname, u.thumb, u.bio, u.location, u.url
		FROM users u
		LEFT OUTER JOIN user_shows su ON u.user_id = su.user_id AND su.show_id in 

		(SELECT su2.show_id
		FROM user_shows su2 WHERE su2.user_id = '{$_user_id}' )
		WHERE 1
		AND u.user_id != '{$_user_id}'
		AND u.user_id NOT IN (SELECT uf.user_id FROM user_followers uf WHERE uf.follower_id = '{$_user_id}')
		GROUP BY u.nickname
		ORDER BY vCount DESC 
		LIMIT 3";
		
		$data_similar = DB::query($sql);
	
		
	}	
	
	
	public static function ls($req)
	{
		
		global $data, $q;
		
		$options = array();
		
		$q =  $req['q'];
		if (!empty($q)) $options['filter'] = $q;
		
		$data = self::find($options);
		
				
	}
	
	public static function find($options = array()) {
		
		
		$defaults = array("order" => "nickname-asc", "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
		
		$options['order'] = str_replace("-", " ", $options['order']);
		
		
		$conditions = "1 ";
		
		if (array_key_exists("filter", $options)) {
			$conditions .= " AND ( (u.nickname LIKE '%{$options['filter']}%') 
				 OR (u.email LIKE '%{$options['filter']}%') )
			";
		}
		
		if (array_key_exists("user_ids", $options)) {
			$conditions .= " AND u.user_id IN  (" . quote_csv($options['user_ids']) . ")";
			
		}
		
	
	
		$sql = "
			SELECT u.user_id, u.email, u.thumb, u.nickname, u.name_first, u.name_last,
				u.bio, u.location, u.bio

			FROM users u
			WHERE {$conditions}
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
		";
		
		return DB::query($sql);
	}	
	
	public static function get_user_popup_info( $req ) {
		
		// is subscribed by logged in user?
		
		// is following logged in user?
		
		// profile link
		
		// profile picture link
		
		// number of updates? / shows?
		$_user_id = $req["uid"];
		$_your_id = User::$user_id;
		
		if ( $_your_id ) {
		
			$sql = "
				SELECT count(uf.user_id) as count
				FROM user_followers uf
				WHERE uf.user_id = '{$_user_id}' and uf.follower_id = '{$_your_id}'
				LIMIT 1
			";
			$res = DB::query($sql);
			$_youre_following = $res[0]["count"];
			
			$sql = "
				SELECT count(uf.user_id) as count
				FROM user_followers uf
				WHERE uf.user_id = '{$_your_id}' and uf.follower_id = '{$_user_id}'
				LIMIT 1
			";
			
			$res2 = DB::query($sql);	
			$_following_you = $res2[0]["count"];
			
		}
		
		$_user_info = self::find( array("user_ids" => $req["uid"] ) );
		
		$data = array("following_you" => $_following_you , "youre_following" => $_youre_following , "user_info" => $_user_info[0] );
		
		
		echo json_encode($data); die();
		
		
	}
	
	public static function unfollow($req)
	{
	
		$_user_id =  self::$user_id ;
		
		$sql = " DELETE FROM user_followers 
		WHERE user_id = '{$req['user_id']}'
		AND follower_id = '{$_user_id}'
		";	
		
		//echo $sql; die();
		
		DB::query($sql, false);
		
		
	}


	public static function follow($req)
	{
	
		$_user_id =  self::$user_id ;
		
		$sql = " INSERT INTO user_followers SET
		user_id = '{$_REQUEST['id']}',
		follower_id = '{$_user_id}'
		ON DUPLICATE KEY UPDATE date_added = date_added	
		";	
		
		//echo $sql; die();
		
		DB::query($sql, false);
		
		if ($req['plain'] == '1')
		{
			die('saved');
		} else {
			header("Location: {$req['_r']}");
			
		}
		
		//Status::follow_user();
		
	}
	
	
	public static function profile($req)
	{
		
		global $_nav_profile; $_nav_profile = "_on";
		
		global $data, $favorite_type, $user_data, $user_channels, $_user_id, $recent_status ;
		
		$_user_id = $_REQUEST['id'];
		$user_data =  self::get_user_data($_user_id);
		
		
		$favorite_type =  (!empty($req['t'])) ? $_REQUEST['t'] : 'shows' ;
		
		$recent_status = Status::get_recent_status( $_user_id );
		
		switch ($favorite_type)
		{
		case 'channels':
			if (!empty($req['rem_channel_id']))
			{
				$options = array("channel_id" => $req['rem_channel_id'], "data" => "1");
				Channel::unfollow($options);
			}
			
			$user_channels = Channel::find(array("owner_id" => $_user_id));
			
			break;	
			
			
		case 'shows':
			if (!empty($req['rem_show_id']))
			{
				$options = array("user_id" => $_user_id, "show_id" => $req['rem_show_id'], "data" => "1");
				self::remove_show_from_favorites($options);
			}
			
			$options = array("user_id" => $_user_id, "data" => 1);
			$data = Show::get_show_list($options);
			break;
		
		case 'videos':
		
			//remove
			if (!empty($req['rem_video_id']))
			{
			$options = array("user_id" => $_user_id, "video_id" => $req['rem_video_id'], "data" => "1", "rating" => "0");
			self::flag_video($options);
			}
			
			$options = array("user_id" => $_user_id, "data" => 1);
			$data =	self::show_favorite_videos($options);
			break;
			
		case 'following':
			
			if (!empty($req['rem_user_id']))
			{
				$options = array("user_id" => $req['rem_user_id'], "data" => "1");
				self::unfollow($options);
			}
			
			
			
			$data = self::get_people_following($_user_id);	
			break;

		case 'followers':
			
			$data = self::get_people_followers($_user_id);
			break;			
		
		}
		

		
		
		
	}
	
	public static function get_people_followers($_user_id)
	{
				$sql = " SELECT u.user_id, u.email, u.name_first, u.name_last, u.nickname, thumb, bio, location, url
			 	FROM users u
				 		INNER JOIN user_followers uf ON u.user_id = uf.follower_id
				WHERE uf.user_id = '{$_user_id}'
				ORDER BY u.nickname";

				return  DB::query($sql);
	}
	
	public static function get_people_following($_user_id)
	{
				$sql = " SELECT u.user_id, u.email, u.name_first, u.name_last, u.nickname, thumb, bio, location, url
			 	FROM users u
				 		INNER JOIN user_followers uf ON u.user_id = uf.user_id
				WHERE uf.follower_id = '{$_user_id}'
				ORDER BY u.nickname";

				return  DB::query($sql);
	}
	
	
	
	public static function get_stuff() {
		echo "STUFFF";
	}

	public static function editRoom($req)
	{
		global $_t, $_channel_id, $channel_data;
		
		global $_section, $current_channel;
		
		//echo $req['controller'];
		//echo $req['action'];
		// echo $req['section'];
		
		$_section = empty($req['section']) ? "search" : $req['section'];
		
		$_t = "editRoom";
		
		
		$channel_data = self::get_user_channels( array("user_id" => User::$user_id, "data" => true) );
		
		$_channel_id = $channel_data[0]['channel_id'];
		
		if ( !empty($req["id"])  ) {
			
			foreach( $channel_data as $_t_channel )
			{
				
				//echo "cc".$_t_channel['channel_id'];
				
				if ( $_t_channel['channel_id'] == $req['id'] ) {
					
					//echo "XXX\n".$_t_channel['title'];
					
					$current_channel = $_t_channel;
					
				}
				
			}
			
		} else {
			
			$current_channel = $channel_data[0];
			
		}
		
		//echo "title ".$current_channel['title'];
		
		
		
		
	}




	public static function images($req) {
		

		global $user_images, $vMsg, $data ;
		
		$data = self::get_user_data(self::$user_id);
		
		$user_images = array();
		
		$web_dir = "/static/images/user_icons/";
		
		$icon_dir = APP_ROOT . "/webroot/{$web_dir}";
		$upload_root = "/var/www/sf-public/webroot";
		
				
			if ($handle = opendir($icon_dir)) {
			
			    /* This is the correct way to loop over the directory. */
			    while (false !== ($file = readdir($handle))) {
			        if (strpos($file, '.gif',1)||strpos($file, '.jpg',1) ) {
			                    array_push($user_images, $web_dir. $file);
			        }
			    }
			    closedir($handle);
			}		
		
			
		
		

					
		if ($req['user_update'] == 1 )
		{
			
			
		//upload image
		$_POST['user_thumb']=  empty($_FILES["file"]["name"]) ? $_POST['user_thumb'] : image_upload_jpg( $upload_root, "/static/users/", self::$user_id );
	
		list($width,$height)=getimagesize($upload_root . $_POST['user_thumb']);
		
			if ( ($width != 160) || ($width != 130) )
			{
	
				$_thumb =  "/static/users/" . self::$user_id 	. "_th.jpg";
			
				
				$save = $upload_root .$_thumb;
				$file = $upload_root . $_POST['user_thumb'];
				
				$image = new Imagick($file);
				$image->cropThumbnailImage(145,80); // Crop image and thumb
				$image->writeImage($save);
				
				$_POST['user_thumb'] = $_thumb;
			}	

			
			$sql = "UPDATE users SET 
			thumb = '{$_POST['user_thumb']}'
			WHERE user_id = '". self::$user_id . "';";

			DB::query($sql , false);

			$vMsg = "your image has been updated";
		
		
		
		}		
		
	}


	public static function logout($req)
	{
		
		global $req_login; $req_login = false;
		
		self::$user_id = '0';
		self::$user_su = '0';
		self::$username = 'guest';
		setcookie("ssf_user_id", self::$user_id, time()-3600, "/" , ".snackfeed.com");
		setcookie("ssf_user_su", self::$user_id, time()-3600, "/" , ".snackfeed.com");
		setcookie("ssf_username", self::$username, time()-3600, "/" , ".snackfeed.com");
	}


	public static function password($req)
	{
		global $data, $vMsg;
		
		
		
		$data = self::get_user_data(self::$user_id);
		
		if( $req['user_update'] == 1 ) $valid = true;
		
	
		if ($valid && ($req['old_password'] != $data['password']))
		{
			$valid = false;
			$vMsg = "you did not match your old password";
		}
		
		if ($valid && ($req['new_password'] != $req['new_password_confirm']))
		{
			$valid = false;
			$vMsg = "your password did not match";
		}
		
		if ($valid &&  ( (strlen($req['new_password']) > 0) && (strlen($req['new_password']) < 6 ) ))
		{
				$vMsg = "if you are going to use a password, pick one with more than 5 characters (please)";
				$email = $req['email'];
				$valid = false;	
		} 
		
		if ($valid)
		{
		
			$sql = "UPDATE users SET 
			password = '{$req['new_password']}'
			WHERE user_id = '". self::$user_id . "';";

			DB::query($sql , false);

			$vMsg = "password updated";
			
		}
		
		
		
	}	

	public static function alerts($req)
	{
		global $data;
		$data = self::get_user_data(self::$user_id);
		
		//http://dev.snackfeed.com/users/email_pref?&user_id=dfb6d566-3c52-102b-9a93-001c23b974f2
		
		global $_advanced_view;
		$_advanced_view = array_key_exists('adv', $req) ? true : false;
		$_user_id = User::$user_id;
	
	
		//if update
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$_POST['_email_days']  = empty($_POST['_email_days']) ? $_POST['_email_days'] : implode(",", $_POST['_email_days']);
			$_POST['_email_hours']  = empty($_POST['_email_hours']) ? $_POST['_email_hours'] : implode(",", $_POST['_email_hours']);

			$sql =  array();
			while (list($key,$value) = each($_POST))
			{ $sql[ltrim($key,"_")] = $value; }
			$nSQL = "UPDATE users SET " . DB::assoc_to_sql_str($sql) . " WHERE user_id = '{$_POST['_user_id']}';";
			//echo $nSQL;

			DB::query($nSQL , false);
		}
	
	
	
	
		$sql = " SELECT *  FROM users WHERE user_id = '{$_user_id}' ";
		$q = DB::query($sql);

		foreach ($q[0] as $field_name => $field_value)
		{
			global	${"_{$field_name}"}; 	
			${"_{$field_name}"} = stripslashes($field_value);
		}
		
		
		
	}

	public static function edit($req)
	{
		
		global $data, $vMsg;
		
		$valid = false;		
		
		if( $req['user_update'] == 1 ) $valid = true;
		
		if ($valid && (User::$user_id  != $req['user_id']))
		{
			$valid = false;
			$vMsg = "there was an error updating your profile info";
			
		}
		
		if ($valid && !ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $req['email']))
		{
			$valid = false;	
			$vMsg = "please enter a valid email address";
		}
		
		if ($valid && (strlen($req['nickname']) < 3 ))
		{
				$vMsg = "we need a nickname that is longer than 2 chars";
				$valid = false;
			
		}
		
		if ($valid &&  (!ereg("^[_a-z0-9-]+$", $req['nickname'])))
		{
			$vMsg = "please enter a valid nickname";
			$valid = false;	
		}
		
		if ($valid) 
		{
			
			//make sure email is not already in system
			$sql = " SELECT u.user_id, u.email, name_first, name_last
		 	FROM users u
			WHERE u.nickname = '{$req['nickname']}'
			AND user_id !=  '". User::$user_id . "'
			";

			$q = DB::query($sql);
			if (count($q) >0 ) 
			{
			$vMsg = "Nickname already exists in system, please use another";
			$valid = false;	
				
			} 
		}
		
		if ($valid && ($req['email_old']  != $req['email']) )
		{
		
				//make sure email is not already in system
				$sql = " SELECT u.user_id, u.email, name_first, name_last
			 	FROM users u
				WHERE u.email = '{$req['email']}'";

				$q = DB::query($sql);
				if (count($q) >0 ) 
				{
					
				$vMsg = "Email already exists in system, please use another";
				$valid = false;	
					
				} 
			
		}	
				
		if ($valid)
		{	
			$sql = "UPDATE users SET 
					name_first = '{$req['name_first']}',
					name_last = '{$req['name_last']}',
					nickname = '{$req['nickname']}',
					url = '{$req['url']}',
					location = '{$req['location']}',
					bio = '{$req['bio']}',
					email = '{$req['email']}'
				WHERE user_id = '{$req['user_id']}';";
	
			//echo $sql;
			
			$vMsg = "profile updated";
			
			self::$username = (!empty($req['nickname'])) ? $req['nickname'] : $req['email'];

			setcookie("ssf_username", self::$username, time()+60*60*24*30, "/" , ".snackfeed.com");

			
			DB::query($sql , false);
	
		}
			
		$data = self::get_user_data(self::$user_id);

	}

	private static function get_user_data($_user_id)
	{
		
		$sql = " SELECT u.user_id, u.email, name_first, name_last, password, 
		thumb, nickname, url, bio, location
		FROM users u
		WHERE u.user_id = '" . $_user_id . "';";
		
		$data = DB::query($sql);	
		return $data[0];
	}


	public static function forgot($req)
	{
		
		global $req_login; $req_login = false;
		
		global $vMsg, $email_sent;
		
		$email_sent = false;
		$vMsg = "";
		if ($req['email_user'] == '1' )
		{
			
			//look for pass
				//make sure email is not already in system
				$sql = " SELECT u.user_id, u.email, name_first, name_last, password
			 	FROM users u
				WHERE u.email = '{$req['email']}'
				";

				$q = DB::query($sql);
			
			
			
			if (count($q) == 1 ) {
				
				//send pass
					if (strlen($q[0]['password']) == 0 ) {
						$message = "you did not set a password -- just leave the password field blank on login -- if you want one -- please login and then go to your profile settings." ;	
					} else {
						$message = "your snackfeed.com password is: " . $q[0]['password']  ;	
					}
					
					
					$to = $q[0]['email'];
					$sender =  "hello@snackfeed";
					$subject = "your snackfeed password. sshhh....."; 
					
					doMail($to, $sender, $subject,$message);
										
					$email_sent = true;
					
			
				
				
				
			} else {
			
			
				$vMsg = "we don't have that email in files - who are you?";
			
			}	
				
		}
	}


	public static function register($req)
	{
		
		global $req_login; $req_login = false;
		
		global $vMsg, $email, $nickname, $invite;
		$vMsg = "";
		
		$invite = (!empty($req['invite'])) ? $req['invite'] : "";
		
		if ($req['new_user'] == '1' )
		{
			
			
			//set defaults
			$valid = true;
			$_invite_id = '0';
			$_source_type = '1';
			$_source_detail = '';
			
			
			
			
			if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $req['email']))
			{
				$vMsg = "please enter a valid email address";
				$valid = false;	
			} 

			if ($valid &&  (!ereg("^[_a-z0-9-]+$", $req['nickname'])))
			{
				$vMsg = "please enter a valid nickname - all lowercase - no spaces - no special chars ";
				$nickname = $req['nickname'];
				$email = $req['email'];
				$valid = false;	
			}
			
			if ($valid &&  (strlen($req['invite']) == 0))
			{
				$vMsg = "please enter an  invite code";
				$nickname = $req['nickname'];
				$email = $req['email'];
				$valid = false;	
			} 
			
			
			if ($valid &&  (strlen($req['password']) > 0) && (strlen($req['password']) < 6 ))
			{
				$vMsg = "if you are going to use a password, pick one with more than 5 characters (please)";
				$nickname = $req['nickname'];
				$email = $req['email'];
				$valid = false;	
			} 
			
			
			//check for valid invite code
			if ($valid &&  (strlen($req['invite']) > 2))
			{
				//match valid invite code
				$sql = " SELECT invite_id, code
			 	FROM invites
				WHERE code = '{$req['invite']}'
				AND invite_count < invite_limit
				";
			

				$invite_result = DB::query($sql);

				if (count($invite_result) == 1 )
				{
					$_invite_id = $invite_result[0]['invite_id'];
					$_source_type = '2';
					$_source_detail = $invite_result[0]['code'];

					
					
				} else {
					
					$vMsg = "please enter a valid invite code";
					$email = $req['email'];
					$nickname = $req['nickname'];
					$valid = false;
					
				}		


			} 
			
			
			if ($valid) 
			{
				
				//make sure email is not already in system
				$sql = " SELECT u.user_id, u.email, name_first, name_last
			 	FROM users u
				WHERE u.email = '{$req['email']}'
				";

				$q = DB::query($sql);
				if (count($q) >0 ) 
				{
					
				$vMsg = "Email already exists in system, please use another";
				$valid = false;	
					
				} 
			}	
		
		
			if ($valid) 
			{
				
				//make sure email is not already in system
				$sql = " SELECT u.user_id, u.email, name_first, name_last
			 	FROM users u
				WHERE u.nickname = '{$req['nickname']}'
				";

				$q = DB::query($sql);
				if (count($q) >0 ) 
				{
				$email = $req['email'];	
				$invite = $req['invites'];
				$vMsg = "Nickname already exists in system, please use another";
				$valid = false;	
					
				} 
			}
			
			if ($valid)
			{	
			
				$_user_id =  DB::UUID();
				$_nickname = $req['nickname'];
				$_date = date("Y-m-d G:i:s" );
				
				$sql = " INSERT INTO users SET
					user_id = '{$_user_id}',
					password = '{$req['password']}',
					thumb = '". self::$user_default_icon . "',
					email = '{$req['email']}',
					nickname = '{$_nickname}',
					date_created = '{$_date}',
					date_updated = '{$_date}',
					source_type = '{$_source_type}',
					source_detail = '{$_source_detail}'
				";	
				
				DB::query($sql, false);
				self::$user_id = $_user_id;
				self::$username = $_nickname;
			
				self::set_user_cookie(self::$user_id, self::$username, 0);
				


				
				
				//upate that the invite code was used

				$sql = " UPDATE invites 
				SET invite_count = invite_count + 1
					WHERE invite_id = '{$_invite_id}';
				";

				$invite_result = DB::query($sql, false);
				
				
				header('Location: /users/register_2');
				
				
			
			}
			
			
			
		}
			
			
	
		
		
	}
	
	
	public static function login($req)
	{
		
		global $req_login; $req_login = false;

		global $vMsg, $email;
		
		$vMsg = "No Message";
		$email = $req["email"];
		
		if( !empty($req["email"]) )
		{
			
				$sql = " SELECT u.user_id, u.email, u.password, name_first, name_last, show_welcome, nickname,  su
			 	FROM users u
				WHERE u.email = '{$req['email']}'
				";


			$data =  DB::query($sql);
			
			//md5($str)
			
			if (count($data) == 0 )
			{
				$vMsg =  "no email found";
			} elseif (count($data) == 1) {
				
				$_pass = $data[0]['password'];
				
				if ($_pass == $req['password'])
				{
					$vMsg =  "LOGIN SUCCESS";

					
					

					self::$user_id = $data[0]['user_id'];
					self::$user_su = $data[0]['su'];
					self::$username = (!empty($data[0]['nickname'])) ? $data[0]['nickname'] : $data[0]['email'];
					
					$sql = "UPDATE users SET login_last = '" . date("Y-m-d G:i:s") . "' WHERE user_id = '" . self::$user_id  . "';";
					DB::query($sql, false);
					
					self::set_user_cookie(self::$user_id, self::$username, self::$user_su);

					//PseudoUser::clear_cookies();
					
					global $_action;
					
					//$data[0]['show_welcome'] == 1) -- if we want to reimplement
					
					if (!empty($req['user_where'])) {
							header("Location: {$req['user_where']}");
						
					} else {
						header('Location: /feed');
					}
						
						
						
				} else {
					$vMsg =  "Password and email do not match";
				}
				
				
			} else {
				$vMsg =  "ERROR";
			}
			
			//md5($str)
			
			
		} else {
			
			$vMsg =  "please enter an email";
			
		}
		
	}
	
	public static function welcome_off($req)
	{
		header('Location: /users');
	}	

	public static function cookie_user($req)
	{
		if (isset($_COOKIE["sf_user_id"]))
		{
			echo "user_id cookie sett";
		} else {
			
			setcookie("ssf_user_id", "adsfsd____dsadfsd", time()+3600);
			echo "no cookie set";
		}
	}	
	
	
	
	
	public static function get_inbox($req) {
		if (!array_key_exists('user_id', $req)) {
			throw new Exception("MISSING REQUIRED KEY user_id", 1); // abstract this
		} else {

			
			//print_r($vid_opts); die();
			
			//$meta = self::find($opts);
			$videos = self::get_videos_for_inbox($req);

			
			
			$total_results =  self::get_total_messages( $req["user_id"]);
			
			
			$data = array( "total_results" => $total_results, "videos" => $videos);
			
			render_data_as_xml($data);
		}
	
	
	}
	
	public static function signup_newsletter( $req ) {
		
		
		$_email = $req['email'];
		
		if ( ! ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",  $_email  ) )
		{
			
			echo "{ error: '1' , message : 'please enter a valid email' }";
			exit();
			
		}
		
		$_res = DB::query(
				
			 "SELECT DISTINCT u.user_id, u.email
			 	FROM users u
				WHERE u.email = '{$_email}'
				"
			);
		
		$_email_exists = $_res[0]["email"];
		$_id_exists = $_res[0]["user_id"];
		
		if ( !empty($_res[0]["email"]) ) {
			
			echo "{ error: '0' , message : 'Thanks' }";
			
			
			DB::query("UPDATE users u
				SET u.newsletter = 1
				WHERE u.user_id = '{$_id_exists}'
			", false);
			
		} else {
			
			echo "{ error: '0' , message : 'Thanks' }";
			
			DB::query("INSERT INTO newsletters
				SET email = '{$_email}'
			", false);
			
		}
		
		die();
		
	}
	
	public static function get_number_new_messages() {
		// or  (up.user_id = '{$_user_id}' and up.action_id = 5) 
		$_user_id = User::$user_id;
		$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-1,date("Y")) );
		$sql = " SELECT count( content_id ) as new_messages from user_updates up where up.user_id = '{$_user_id}' and up.action_id = 5 and up.date_added > '{$_date}'
		ORDER BY up.date_added DESC
		
		";
		
		$results = DB::query($sql);	
		
		return $results[0]["new_messages"];
		
	}
	
	
	public static function get_videos_for_inbox($options) {
		$defaults = array("order" => '', "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
	
	
	
		
	
		$sql = " SELECT m.message_body , u.email as sender_email, 
			if ( (DATEDIFF(m.date_created, now()) = 0), DATE_FORMAT(m.date_created, '%l:%i %p'), DATE_FORMAT(m.date_created, '%b %e') ) as date_sent,
			v.title, v.detail, v.video_id, v.show_id,
			v.season, v.episode, v.date_air, v.date_pub, v.url_link, v.url_source, v.thumb, v.duration,
			sources.client_lib, IF((sources.client_lib IS NULL OR sources.client_lib = ''), 0, 1) AS use_client_lib,
			v.use_embedded,
			sources.proxy_url, IF((sources.proxy_url IS NULL OR sources.proxy_url = ''), 0, 1) AS use_proxy_url,
			shows.title AS show_title, v.has_children, v.video_type_id, v.param_1, v.param_2, param_3, param_4
		 	FROM messages m, users u, videos v
			JOIN sources ON v.source_id = sources.source_id
			JOIN shows ON v.show_id = shows.show_id
			WHERE m.message_id in (SELECT message_id FROM message_users where user_id = '" . $options["user_id"] ."')
			AND m.user_id = u.user_id
			AND m.video_id = v.video_id
			ORDER BY m.date_created DESC
			LIMIT {$options['offset']}, {$options['limit']};";
			
			
		
			
			
		$results = DB::query($sql);	
			
		//put segments in video list if necessary
		//insert channel videos as nested queries
		for ($i = 0 ; $i < count($results) ; $i++)
		{
			$id =  $results[$i]['video_id'];
			if ($results[$i]['has_children'] == '1')
			{
				$segments = Video::get_segments($id);
				array_push($results[$i], $segments);
			}	
		}	
			
			

		return $results;
		
		
	}	
	
	private static function get_total_messages($user_id) {
	
	
		$sql = " SELECT count(m.message_id) as rCount
		 	FROM messages m, users u
			WHERE m.message_id in (SELECT message_id FROM message_users where user_id = '" . $user_id ."')
			AND m.user_id = u.user_id
			";
			
			
		$q = DB::query($sql);
		return $q[0]["rCount"];
	}	
	
	
	public static function get_users($options) {
		
		$defaults = array("order" => '', "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
	
		$sql = " SELECT u.user_id, u.email, name_first, name_last
		 	FROM users u
			ORDER BY email
			LIMIT {$options['offset']}, {$options['limit']}
			";
			
			
		$q = DB::query($sql);
		render_data_as_xml($q);
	}	
	
	public static function get_related_users($req)
	{
		
		$_user_id = User::$user_id;
		
		$sql = "SELECT DISTINCT u.user_id, u.nickname 
		FROM users u, user_followers f2, user_followers f
		WHERE 1
		AND (f.follower_id = u.user_id AND f.user_id = '{$_user_id}' )
		OR (f2.user_id = u.user_id AND f2.follower_id = '{$_user_id}' )
		ORDER BY u.nickname;";
		
		return DB::query($sql);
		
		
	}

	public static function send_message($req) {
		

		$_message_id = DB::UUID();
		
		$user_data = self::get_user_data($req["s_user_id"] );	

		$sql = "
			INSERT INTO messages SET  
			message_id = '" . $_message_id. "',
			user_id = '" . $req["s_user_id"] . "',
			video_id = '" . $req["video_id"] . "',
			message_body = '" . $req["message_body"] . "'
		;";		


		DB::query($sql, false);
		
		if (!empty($req['r_user_ids']))
		{
		foreach($req['r_user_ids'] as $_r_user_id)
		{

				$sql = "
					INSERT INTO message_users SET  
					user_id = '{$_r_user_id}',
					message_id = '{$_message_id}';";		
				DB::query($sql, false);
				
				$_message = $req["message_body"] ;
				
				// cc replaced this with the model call...
				/*
				$sql = " INSERT INTO user_updates (user_id, action_id, content_type, content_id, scope, detail, date_added, location_type, location_id, location_title)
							values (
							'{$_r_user_id}',
							'5',
							'0',
							'{$req["video_id"]}',
							'0',
							'{$_message}',
							now(),
							'2',
							'{$req["s_user_id"]}',
							'{$user_data['nickname']}'	
								);";							
				DB::query($sql, false);
				*/
				
				$sql_video = "SELECT title, detail, thumb FROM videos WHERE videos.video_id = '{$req['video_id']}'";
				$vq = DB::query($sql_video);
				$video_details = $vq[0]['detail'];
				$video_title = $vq[0]['title'];
				$video_thumb = $vq[0]['thumb'];
				
				
				Status::insert_status( 
					array( 
					"user_id" => $_r_user_id , 
					"user_nickname" => $user_data['nickname'] , 
					"scope" => "2",
					"content_type" => "0",
					"action_id" => "5",
					"detail" => $_message,
					"content_id" => $req["video_id"],
					"content_title" => $video_title,
					"content_detail" => $video_details,
					"content_thumb" => $video_thumb
				) );
				
				
				
				$_link = "http://www.snackfeed.com/videos/detail/" . $req["video_id"] ;
				$message = $user_data['nickname'] . " says: " . $req["message_body"] . "\r\n<br/>    " . $_link  ;
				
				$r_data = self::get_user_data($_r_user_id );
				
				$to = $r_data['email'];
				$sender =  $user_data['email'];
				$subject = $user_data['nickname'] . " has send you a video from SnackFeed"; 

				doMail($to, $sender, $subject,$message);
				
				
				
				
				
		}
		}

		
		echo "comment sent";
		die();
		
		
	}


	public static function get_user_id($req) {
		if (!array_key_exists('email', $req)) {
			throw new Exception("MISSING REQUIRED KEY email", 1); // abstract this
		} else {

				
			$sql = " SELECT u.user_id, u.email, name_first, name_last
			 	FROM users u
				WHERE u.email = '{$req['email']}'
				";


			$data =  DB::query($sql);

			if (count($data) == 0 ) 
			{
				$data = array( "response" => "0", "message" => "email not found");
			} else {
				$_response = array( "response" => "1");
				$data = array_merge($_response, $data);
			}
		
		
			if (array_key_exists('plain', $req)) {
					echo $data[0]['user_id']; die();
			} else if (array_key_exists('data', $req)) {
				return $data[0]['user_id'];
			} else if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else {
				render_data_as_xml($data);
			}

		}
	
	
	}

	public static function ext($req) 
	{
		
		global $data, $vMsg;
		$_user_id = User::$user_id;
		$_now = date("Y-m-d G:i:s");
		
		if ($req['ext_update'] == '1' )
		{
			$sql = "SELECT ext_id FROM exts WHERE status = 1;";
			$q = DB::query($sql);
			for ($i = 0 ; $i < count($q) ; $i++)
			{
				$_ext_id = $q[$i]['ext_id'];
				$_username =  $_POST['ext_id_' .$_ext_id ];
				
				if (!empty($_username))
				{

					  $sql = " INSERT INTO ext_users SET 
						user_id = '{$_user_id}',
						ext_id = '{$_ext_id}', 
						username = '{$_username}', 
						param_1 = '', 
						process_hour_interval = '21', 
						process_date_last = '{$_now}', 
						process_date_next = '{$_now}', 
						status = '1' 
					ON DUPLICATE KEY UPDATE username = '{$_username}'
			;";		
	
			DB::query($sql, false);					
					
					
				} else {
					
					//DELETE the entyr????
					$sql = "DELETE FROM ext_users 
					WHERE 1
					AND user_id = '{$_user_id}'
					AND ext_id = '{$_ext_id}' ;";
					DB::query($sql,false);
				}
				
				
			}
			
			$vMsg = "External Accounts Updated.";
		}
		
		
	

		$sql = "SELECT e.ext_id, e.name, e.detail, eu.username
				FROM exts e
				   LEFT OUTER JOIN ext_users eu ON e.ext_id = eu.ext_id
				   AND eu.user_id = '{$_user_id}'
				WHERE e.status = 1
				ORDER BY e.name";
		$data = DB::query($sql);		
			
		
	}


	
	public static function packages($req) 
	{
		
		global $data, $shows_count, $results;
		
		
		$results = false;
		$data = Show::get_packages($req);
		
		if ($req['package_update'] == '1' )
		{
			$results = true;
			$_user_id = User::$user_id;

			if (!empty($_POST['_package_ids']))
			{

			foreach ($_POST['_package_ids'] as $_package_id)
			{

			$sql = "
				INSERT INTO user_shows (user_id, show_id, reason)
					(	SELECT '{$_user_id}', ps.show_id, p.name
						FROM package_shows ps, packages p
						WHERE ps.package_id = p.package_id
						AND p.package_id = '{$_package_id}'
						AND ps.show_id not in (SELECT show_id FROM user_shows WHERE user_id = '{$_user_id}')
					)
				ON DUPLICATE KEY UPDATE reason = p.name
			;";		
	
			DB::query($sql, false);
			}
		
			}
			
			
			$shows_count = self::get_favorites_count($_user_id);

		}	
		
	}


	public static function get_favorites_count($_user_id)
	{
				$sql = "SELECT count(show_id) as vCount FROM user_shows WHERE user_id = '{$_user_id}';";
				$q = DB::query($sql);
				return $q[0]['vCount'];
	}

	public static function save_show_to_favorites($req) {
		
		if ( !array_key_exists('show_id', $req) || !array_key_exists('user_id', $req) ) {
			
			throw new Exception("MISSING REQUIRED KEYS: SHOW_ID , USER_ID", 1); // abstract this
			
		} else {
			
					$sql = "
						INSERT INTO user_shows SET  
							user_id = '{$req["user_id"]}',
							show_id = '{$req["show_id"]}'
						ON DUPLICATE KEY UPDATE order_by = order_by	
					;";		
					
					//echo $sql;
					
					DB::query($sql, false);
					
					//REMOVE SHOW FROM RECOMMENDATIONS
					$sql = "
						DELETE FROM user_recommendations
						WHERE user_id = '{$req["user_id"]}'
						AND show_id = '{$req["show_id"]}'
						
					;";
					
					//echo $sql;
					
					Status::user_followed_show( array("show_id" => $req["show_id"] , "user_id" => $req["user_id"] ) );
					
					
					DB::query($sql, false);
					
			$data = array( "response" => 1);
		
		
			if (array_key_exists('json', $req)) {
				
				echo json_encode($data); die();
				
			} else if (array_key_exists('plain', $req)) {	
				
				echo "saved"; die();
				
			} else if ( array_key_exists('_r', $req) )	 {
				
					header("Location: {$req['_r']}");
				
			} else {
				render_data_as_xml($data);
			}
		
		

		}
	
	
	}



	public static function remove_show_from_favorites($req) {
		if ( !array_key_exists('show_id', $req) || !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEYS: SHOW_ID , USER_ID", 1); // abstract this
		} else {

					
					//REMOVE SHOW FROM RECOMMENDATIONS
					$sql = "
						DELETE FROM user_shows
						WHERE user_id = '{$req["user_id"]}'
						AND show_id = '{$req["show_id"]}'
						
					;";		

					//echo $sql;

					DB::query($sql, false);

			$data = array( "response" => 1);
		
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else if (array_key_exists('plain', $req)) {	
				echo "saved"; die();	
			} else if (array_key_exists('data', $req)) {
				return;
			} else {
				render_data_as_xml($data);
			}

		}
	
	
	}





	public static function save_package($req) {
		if ( !array_key_exists('package_id', $req) || !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  package_id, user_id ", 1); // abstract this
		} else {

					$sql = "
						INSERT INTO user_shows (user_id, show_id, reason)
							(	SELECT '{$req["user_id"]}', ps.show_id, p.name
								FROM package_shows ps, packages p
								WHERE ps.package_id = p.package_id
								AND p.package_id = '{$req["package_id"]}'
								AND ps.show_id not in (SELECT show_id FROM user_shows WHERE user_id = '{$req["user_id"]}')
							)
						ON DUPLICATE KEY UPDATE reason = p.name
					;";		

					//echo $sql;
					//die();
					DB::query($sql, false);


			$data = array( "response" => 1);
			
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else if (array_key_exists('plain', $req)) {
					echo "saved"; die();				
			} else {
				render_data_as_xml($data);
			}
			

		}
	
	
	}


	public static function mark_all_as_watched($req) {
		if ( !array_key_exists('video_ids', $req) || !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  video_ids, user_id", 1); // abstract this
		} else {


				$videos_array = explode("," , $req["video_ids"]);
		

				foreach ($videos_array as $video_id)
				{
					
					
			
					$sql = "
						INSERT INTO user_videos SET
							user_id = '{$req["user_id"]}',
							video_id = '{$video_id}'
							ON DUPLICATE KEY UPDATE count = count+1	
							;";		

					//echo $sql;

					DB::query($sql, false);
					}

			$data = array( "response" => 1);
			
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else {
				render_data_as_xml($data);
			}

		}
	
	
	}

	public static function mark_video_watched($req) {
		if ( !array_key_exists('video_id', $req) || !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  video_id, user_id", 1); // abstract this
		} else {

			
					$sql = "
						INSERT INTO user_videos SET
							user_id = '{$req["user_id"]}',
							video_id = '{$req["video_id"]}'
						ON DUPLICATE KEY UPDATE count = count+1	
							;";		

					//echo $sql;

					DB::query($sql, false);
					echo "saved";die();
		}
	
	
	}



	public static function welcome_user($req)
	{
		
		if (!empty($req['user_id']))
		{
			$_date = date("Y-m-d G:i:s");
			
			$sql = " SELECT *
					FROM notifications
					WHERE date_start < '{$_date}'
					AND date_end >  '{$_date}'
			 		ORDER BY  date_start DESC
					LIMIT 1;";

			$q = DB::query($sql);
			if ( !empty($q)){
			foreach ($q[0] as $field_name => $field_value)
			{
				global	${"_{$field_name}"}; 	
				${"_{$field_name}"} = stripslashes($field_value);
			}		
			}
			
		}
		
	}

	public static function send_to_friend($req)
	{
	
		global $req_login; $req_login = false;
		
		global $_email, $_email_message, $_video_id, $_thumb, $_title, $_detail, $_link, $email_sent;
		$email_sent = false;
		
		if (array_key_exists('_send_email', $req) ) 
		{
			$message = $sender . " " . stripslashes($req['_email_message']) . "\r\n<br/>    " . $req['_link']  ;
			$to = $req['_email_to'];
			$sender =  $req['_email_from'];
			$subject = "{$sender} has send you a video from SnackFeed"; 
			

			doMail($to, $sender, $subject,$message);
			
			$email_sent = true;
			return;
		}	
	
		$video = Video::find($req);
		$_video_id = $video[0]['video_id'];
		$_show_id = $video[0]['show_id'];
		$_title = stripslashes($video[0]['title']);
		$_detail = stripslashes($video[0]['detail']);
		$_thumb = stripslashes($video[0]['thumb']);
		$_link = BASE_URL . "/videos/detail/{$_video_id}";
	
		$_email = $req['user_email'];
		$_email_message = "wants you to check out this video: " . $_title  ;



	}
	
	public static function send_to_tumblr($req)
	{
	
		global $req_login; $req_login = false;
	
		global $_email, $_email_message, $_video_id, $_thumb, $_title, $_detail, $_link, $_url_source, $_use_embedded, $processed;
		$processed = false;
		
		if (array_key_exists('_send_tumblr', $req) ) 
		{

			$tumblr_email    = 'jason@laan.com';
			$tumblr_password = 'rufruf';

			$_embed_base = '<object width="425" height="355"><param name="movie" value="__URL__"></param><param name="wmode" value="transparent"></param><embed src="__URL__" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>';
			
			
			//determine if is embedded
			if ($req['_use_embedded'] == '1')
			{
				
				$_url = $req['_url_source'];
				
			} else {
				//use our player
				$_url = BASE_URL . "/static/swfs/embedPlayer.swf?id=" . $req['_video_id'];
			}
			
			$_embed = str_replace("__URL__", $_url, $_embed_base  );
			//echo "EMBED" . $_embed; 

			// Data for new record
			$post_type  = 'video';
			$post_title = 'The post title';
			$post_body  = 'This is the body of the post.';


			// Prepare POST request
			$request_data = http_build_query(
			    array(
			        'email'     => $req['_email'],
			        'password'  => $req['_tumblr_password'],
			        'type'      => $post_type,
			        'title'     => $req['_title'],
			        'caption'   => $req['_email_message'],
					'embed'		=> $_embed,	
			        'generator' => 'API example'
			    )
			);

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
			$processed = true;
		}	
	
		$video = Video::find($req);
		$_video_id = $video[0]['video_id'];
		$_show_id = $video[0]['show_id'];
		$_title = stripslashes($video[0]['title']);
		$_detail = stripslashes($video[0]['detail']);
		$_thumb = $video[0]['thumb'];
		$_link = BASE_URL . "/beta/#?sid={$_show_id}&vid={$_video_id}";
		$_url_source = $video[0]['url_source'];
		
		if ( stristr($_url_source, "hulu")  ) $_url_source = str_replace("player", "playerembed", $_url_source);
		
		$_use_embedded = $video[0]['use_embedded'];
	
		$_email = $req['user_email'];
		$_email_message = "a video from snackfeed: " . $_title  ;



	}
	
	
	
	public static function flag_video($req)
	{
		
			if ( !array_key_exists('video_id', $req) || !array_key_exists('user_id', $req) || !array_key_exists('rating', $req)) {
				
				throw new Exception("MISSING REQUIRED KEY(S):  video_id, user_id, rating", 1); // abstract this
			
			} else {
				
						$sql = "
							INSERT INTO user_videos SET
								user_id = '{$req["user_id"]}',
								video_id = '{$req["video_id"]}',
								rating = '{$req["rating"]}'
								
							ON DUPLICATE KEY UPDATE rating = '{$req["rating"]}'	
								;";		
								
						//echo $sql;
						DB::query($sql, false);
						
						Status::user_favorited_video( array( "action_icon" => $req['action_icon'] , "video_id" => $req['video_id'] , "comment" => $req['comment']) );
						
						if (!empty($req['data'])) {
							return;
						} else {
							echo "saved";die();
						}
						
			}

	
		
	}
	
	
	public static function show_favorite_videos($req)
	{
		$defaults = array("order" => "uv.date_added-DESC, v.title ", "limit" => 10, "offset" => 0);
		$options = array_merge($defaults, $req);
		$options['order'] = str_replace("-", " ", $options['order']);
		
		$conditions = "1";
		
		$sql = "
			SELECT v.video_id, v.title, v.detail,  v.show_id, v.thumb
			FROM videos v
			INNER JOIN user_videos uv ON uv.video_id = v.video_id 
			WHERE {$conditions}
			AND uv.user_id = '{$options['user_id']}'
			AND uv.rating > 0
			AND v.parent_id = '0'
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
			
		";
		
		global $video;
		
		$video = DB::query($sql);
		
			if (array_key_exists('json', $req)) {
				echo json_encode($video); die();
			} elseif (array_key_exists('data', $req)) {
				return $video;	
			} else {
				render_data_as_xml($video);
			}

		
		
	}
	
	public static function get_user_channels($req)
	{
		
		if ( !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  user_id", 1); // abstract this
		} else {
			
			
			
			$sql = " SELECT c.channel_id, c.title, cu.role, cu.status
			 	FROM channels c INNER JOIN channel_users cu ON c.channel_id = cu.channel_id 
				WHERE cu.user_id = '{$req['user_id']}' 
				ORDER BY c.title
				";

			//echo $sql; die();

			$data = DB::query($sql);
			
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} elseif (array_key_exists('data', $req)) {
				return $data;	
			} else {
				render_data_as_xml($data);
			}
			
				
			
		}
		
	}
	
	
	public static function get_user_shows($req)
	{
		
		if ( !array_key_exists('user_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  user_id", 1); // abstract this
		} else {
			
			
			
			$sql = " SELECT s.show_id, s.title
			 	FROM shows s INNER JOIN show_users su ON s.show_id = su.show_id 
				WHERE su.user_id = '{$req['user_id']}' 
				ORDER BY s.title
				";

			//echo $sql; die();

			$data = DB::query($sql);
			
			if (array_key_exists('json', $req)) {
				echo json_encode($data); die();
			} else {
				render_data_as_xml($data);
			}
			
				
			
		}
		
	}
	
	
}

?>
