<?php



// SINGLETON
class DB {
	
	public static $mysqli_object = null;

	public static function mysqli() {
		if (self::$mysqli_object == null) {
			self::$mysqli_object = self::init_mysqli();
		}
		return self::$mysqli_object;
	}
	
	public static function init_mysqli() {
		global $dbhost, $dbuser, $dbpass, $db;
		$_mysqli = new mysqli($dbhost, $dbuser, $dbpass, $db);
		if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
		}
	  return $_mysqli;		
	}

	public static function close() {
		if (self::$mysqli_object != null) {
			self::$mysqli_object->close();
		}
		
	}
	
	public static function insert_id()
	{
		$mysqli = self::mysqli();
		return $mysqli->insert_id;
	}
	
	public static function query($query, $do_fetch = true) {
		if (array_key_exists('debug', $GLOBALS) && $GLOBALS['debug']) {
			echo "<p>$query</p>";
		}
		$mysqli = self::mysqli();
		
		$result = $mysqli->query($query);
		
		if ($do_fetch && $result) {
			$rows = array();		
			while ($row = $result->fetch_assoc()) {
				array_push($rows, $row);
			}
			$result->close();
			return $rows;
		} else if (!$result) {
			die("<pre>QUERY ERROR:\n".$query."\n------\n".$mysqli->error."</pre>");
		} else {
			return $result;
		}
	}
	
	public static function uuid() {
		$rows = self::query("SELECT UUID() AS u;");
		return $rows[0]['u'];
	}
	
	public static function escape($string) {

		return self::mysqli()->real_escape_string($string);
	}

	public static function assoc_to_sql_arr($assoc) {
		$sql_arr = array();
		foreach ($assoc as $key => $value) {
			array_push($sql_arr, "{$key} = '".self::escape($value)."'");
		}
		return $sql_arr;
	}
	
	
	public static function assoc_to_sql_str($assoc) {
            return implode(", ", self::assoc_to_sql_arr($assoc));
    }
	
	public static function field_defaults($table)
	{
		
		$field_arr = array();
		$sql = "SHOW COLUMNS FROM " . $table;
		$_fields = self::query($sql);

		foreach ($_fields as $r)
		{	

			switch ($r['Type'])
			{
			case 'datetime':
				${"_{$r['Field']}"} =date("Y-m-d G:i:s") ;
				break;
			default:
				${"_{$r['Field']}"} = $r['Default'] ;
				

			}
			$field_arr["_{$r['Field']}"] = ${"_{$r['Field']}"};
 			//array_push($field_arr, "_{$r['Field']} = '".${"_{$r['Field']}"}."'");
			
		}
		
		return $field_arr;
		
	}
	
	
	public static	function close_and_exit() {
		self::close();
		exit;
	}

}

// $rows = DB::query("SELECT * FROM videos WHERE id = '".DB::escape($unclean)."';");
// print_r($rows);

?>
