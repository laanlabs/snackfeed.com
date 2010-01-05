<?

class Help {
	
	function __construct()
	{
		global $req_login; $req_login = false;
	}
	

	public static function get_help_page($req, $uri_parts)
	{
		global $req_login; $req_login = false;
		
		global $_action, $data, $toc_data, $_t;
		
		
		
		$_t = "help";
		$_action = "_default";
		
		
		$_h_controller = $uri_parts[2];
		$_h_action    = $uri_parts[3];
		$_h_id        = $uri_parts[5];
		
		
		$send_email = isset($_POST['send_email']) ? $_POST['send_email'] : '0';
		if ($send_email == 1 ) 
		{
			self::send_email($req);
			die();
		}
		
	
		$toc_data =	self::render_toc();
		$data =	self::render_help_page($uri_parts);
			
		
	}


	private static function render_toc()
	{
		

		$sql = "SELECT * FROM helps ORDER BY title asc";
		return DB::query($sql);
		
		
	}


	public static function render_help_page($uri_parts)
	{
		
		
		$_h_controller = $uri_parts[2];
		$_h_action    = $uri_parts[3];
		$_h_id        = $uri_parts[5];
		
		$sql = "SELECT  h.* 
		FROM helps h
		LEFT OUTER JOIN helps h2 on h.help_id = h2.help_id AND h2.controller = '{$_h_controller}'
		LEFT OUTER JOIN helps h3 on h.help_id = h3.help_id AND h3.action = '{$_h_action}'
		ORDER BY h3.action DESC, h2.controller DESC, h.controller
		LIMIT 1";
		
		return DB::query($sql);
		
		
	}
	
	
	public static function send_email($req)
	{
		
		$vMSG = "";

		$mBODY = "<html><body>";
		$mBODY .= "FROM: " . $_POST['input_from'] . "<br/>\r\n";
		$mBODY .= "EMAIL: " . $_POST['input_email'] . "<br/><br/>\r\n";	
		$mBODY .= "MESSAGE: " . $_POST['input_message'] . "\r\n";	
		$mBODY .= "</body></html>";


		/* EMAIL HEADERS */
		$sender = "hello@snackfeed.com";
		$headers = "From: " . $sender . "<" . $sender . ">\n";
		$headers .= "Reply-To: " . $sender ." <" . $sender . ">\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: text/html\n";

		mail("hello@snackfeed.com", "SITE MESSAGE: " . $_POST['input_reason'],      $mBODY,      $headers);		

		echo  "your email has been sent ...";

		
		
		
	}
	


}

?>
