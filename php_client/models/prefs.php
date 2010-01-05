<?php

class Prefs {
	
	
	//public static $username = 'guest';
	public static $default_prefs = array( "feed_view" => "thumbs" );
	public static $current_prefs;
	
	function __construct() {
		self::populate();
	}
	
	public static function populate() {
		
		if ( User::$user_id != '0' ) {
			
			
			// in cookie as prefs23452345 ??
			if ( $_COOKIE["sf_prefs".User::$user_id ] ) {
				
				//echo "has cookie for: ".User::$user_id;
				
				self::$current_prefs = self::deserialize_prefs( $_COOKIE["sf_prefs".User::$user_id ] );
				return;
				
			} else {
				//echo "has no for: ".User::$user_id;
			}
			
			// no..
			// in DB?
			
			
			
			// in prefs0 ?? ( from before signing up? )
			
			
			
			// no..
			// then set defaults for this user in DB and cookie prefs12342134
			// and return default value.
			self::$current_prefs = self::set_defaults( User::$user_id );
			
			
		} else {
			
			// guest user, check for cookie prefs0
			if ( $_COOKIE["sf_prefs0" ] ) {
				
				Prefs::$current_prefs = self::deserialize_prefs( $_COOKIE["sf_prefs0" ] );
				
				//print_r(  Prefs::$current_prefs );
				//return $current_prefs[ $pref_name ];
				
			} else {
				
				
				//echo " no guest cookie, setting defaults...";
				// no, set defaults in cookie prefs0
				Prefs::$current_prefs = self::set_defaults('0');
				//print_r($current_prefs);
				
				//echo "Done setting cookuies: " . Prefs::$current_prefs;
				
			}
			
			
			
			
		}
		
		
	}
	
	public static function get( $pref_name ) {
		//echo "Ewrgt";
		//print_r(Prefs::$current_prefs);
		if ( !self::$current_prefs ) self::populate();
		
		return Prefs::$current_prefs[ $pref_name ];
		
	}
	
	public static function set( $pref_name , $pref_value ) {
		
		if ( !self::$current_prefs ) self::populate();
		
		Prefs::$current_prefs[ $pref_name ] = $pref_value;
		$serialized = self::serialize_prefs( Prefs::$current_prefs );
		
		if ( User::$user_id != '0' ) {
			
			
			// set cookie as prefs23452345 ??
			
			
			// set DB with value
			
			
		}
		
		setcookie("sf_prefs".User::$user_id, $serialized , time()+60*60*24*30, "/" , ".snackfeed.com");
		
		
		
	}
	
	public static function clear_prefs() {
		
		setcookie("sf_prefs".User::$user_id, "" , time()+60*60*24*30, "/" , ".snackfeed.com");
		
	}
	
	public static function set_defaults( $user_id ) {
		
		//echo "setting defaults cookie for: ".User::$user_id;
		
		//db::query( $sql );
		$serialized = self::serialize_prefs( self::$default_prefs );
		//echo "serialized: " . $serialized;
		
		setcookie("sf_prefs".User::$user_id, $serialized , time()+60*60*24*30, "/" , ".snackfeed.com");
		
		
		return self::$default_prefs;
		
	}
	
	
	public static function serialize_prefs( $pref_array ) {
		return http_build_query( $pref_array );
	}
	
	public static function deserialize_prefs( $pref_string ) {
		
		parse_str( $pref_string , $des );
		return $des;
		
	}
	
}
	
new Prefs();

?>
