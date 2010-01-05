<?php

class PseudoUser {
	
	public static $pseudo_user_id;
	
	
	public static function set_cookies($user_id) {
		
		if ( $user_id == "0" && !isset($_COOKIE['pseudo'])) {
			
			self::$pseudo_user_id = self::get_new_id();
			setcookie("pseudo", self::$pseudo_user_id, time()+60*60*24*365, "/" , ".snackfeed.com" );
			
		} else if ( $user_id == "0" ) {
			
			self::$pseudo_user_id = $_COOKIE['pseudo'];
			
		}
		
	}
	
	public static function clear_cookies() {
		setcookie("pseudo", "", time()+60*60*24*365, "/" , ".snackfeed.com" );
	}
	
	public static function get_new_id() {
		DB::query("INSERT INTO pseudo_users SET time_created = NOW();", false);
		return DB::last_insert_id();
	}
	
}
?>