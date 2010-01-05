<?php

class TinyHelper {
	public static $char_for = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	
	public static function decimal_to_base($num, $base) {
		self::check_base_error($base);
	  if ($num < $base) {
	    return self::$char_for[$num];
	  } else {
	    return self::decimal_to_base($num/$base, $base) . self::$char_for[$num % $base];
	  }		
	}
	
	public static function base_to_decimal($str, $base) {
		self::check_base_error($base);
		$sum = 0;
		$l = strlen($str);
		for ($i=0; $i < $l; $i++) { 
			$val = array_search($str[$i], self::$char_for, true);
			$c = $str[$i];
			$m = $l-$i-1;
			$sum += pow($base, $l-$i-1) * $val;
		}
		return $sum;
	}
	
	public static function check_base_error($base) {
		if ($base > 62 || $base < 1) {
			throw new Exception("Base must be between 1 and 62. You tried to use $base", 1);
		}
	}
}

?>