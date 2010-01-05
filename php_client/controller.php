<?



$GLOBALS['messages'] = array();
$request_path        = $_SERVER['REQUEST_URI'];
$request_path        = preg_replace("/\?.*$/", '', $request_path); // strip off query string
//$request_path        = preg_replace("/\.[^\/]*$/", '', $request_path); // remove .php, .html
$uri_parts           = explode("/", $request_path);
$_REQUEST['controller'] = $uri_parts[1];
$_REQUEST['action']     = $uri_parts[2];
$_REQUEST['id']         = $uri_parts[3];





$User = new User();
$Prefs = new Prefs();

 
$_t = (empty($_REQUEST['_t'])) ? '_default' : $_REQUEST['_t'] ; 

if ( User::$user_id == '0') {
	$_controller = (empty($_REQUEST['controller'])) ? 'public' : $_REQUEST['controller'] ; 
	$_action = (empty($_REQUEST['action'])) ? '_default' : $_REQUEST['action'] ;  
} else {
	$_controller = (empty($_REQUEST['controller'])) ? 'public' : $_REQUEST['controller'] ;
	$_action = (empty($_REQUEST['action'])) ? '_default' : $_REQUEST['action'] ;  
}



switch ($_controller) {
	case 'main':
		global $req_login; $req_login = false;
		break;

	case 'public' :
		require_once MODELS."/feedpublic.php";
		$_t = "public_splash";
		FeedPublic::$_action($_REQUEST);
		break;
		
	case 'groups' :
		require_once MODELS."/group.php";
		Group::$_action($_REQUEST);
		break;
		
	case 'shows':
		Show::$_action($_REQUEST);
		break;
		
	case 'videos':
	  $_t = "watch";
		Video::$_action($_REQUEST);
		break;
	
	case 'channels':
		Channel::$_action($_REQUEST);
		break;
		
	case 'users':
		User::$_action($_REQUEST);
		break;
		
	case 'feed':
		if ( Feed::$actions[ $_action ]  )  {
			// or instead of this approach have a hash of functions to check
			Feed::$_action($_REQUEST);
			
		} else {
			//echo "No action, could be user..." . $_action;
			Feed::get_user_feed($_REQUEST);
		}

		$_action = "_default";
		break;
	
	case 'watch':
			Watch::$_action($_REQUEST);
			break;	

	case 'uvideos':
			UVideo::$_action($_REQUEST);
			break;
		
	case 'search':
			Search::$_action($_REQUEST);
			$searchTab = 'selected';
			break;			
	
	case 'help':
		require_once MODELS."/help.php";	
		Help::get_help_page($_REQUEST, $uri_parts);	
		break;			
	default:
		$_controller = "main";
		$_REQUEST['id'] = "NONE";
		$homeTab = 'error';
		
		break;
}



//force user to login -- this needs to be written more efficiently --
if ( (User::$user_id == '0') && $req_login )
{
	$_controller = 'main';
	$_action = 'error'  ;
}


	

// this gets the _default.php, which then calls the controller/action.php
include TEMPLATES."/{$_t}.php";


//$ts = date("Y-m-d G:i:s");
//elog("{$ts}:  /" . $_REQUEST['controller'] ."/" . $_REQUEST['action'] ."/"  . $_REQUEST['id']);



// exit_and_close_db();

?>