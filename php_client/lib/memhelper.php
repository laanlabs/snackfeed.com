
<?php

// Memcache singleton object
class MemHelper extends Memcache {
	
	
	static private $m_objMem = NULL;
	
	
	static function getMem() {
		
		if (self::$m_objMem == NULL) {
			
			self::$m_objMem = new Memcache;
			// connect to the memcached on some 
			//host __MEMHOST running it om __MEMPORT
			//self::$m_objMem->connect(__MEMHOST, __MEMPORT) 
			self::$m_objMem->connect("localhost", 11211) or die ("The memcached server");
			
		}
		
		return self::$m_objMem;
	}
}


?>

