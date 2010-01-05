<?php



define(APP_ENV, "nix");
define(APP_ROOT, $_SERVER["DOCUMENT_ROOT"]."/../");
define(APP_NAME, 'smoothtube');
define(PUBLIC_ROOT, "/var/www/sf-public/webroot");
define(APP_DOMAIN, $_SERVER['HTTP_HOST']);

/** DB VARS **/
$dbhost = "127.0.0.1";
$dbuser = "sf-admin";
$dbpass = "sf-admin";
$db = "db_smoothtube";


/** thumbnail location **/
if ($_SERVER['HTTP_HOST'] == "a.snackfeed.com")
{
	define(PUBLIC_URL, "http://www.snackfeed.com");
} else {
	define(PUBLIC_URL, "http://dev.snackfeed.com");
}




error_reporting(E_ALL ^ E_NOTICE);
define(APP_LOG, APP_ROOT . "/log/error.log");
ini_set('error_log', APP_LOG); // make sure errors get logged
function elog($string) { error_log($string."\n", 3, APP_LOG); } //// MAKE SURE THIS FILE EXISTS AND IS WRITABLE

// elog(implode("\n", $_SERVER));

define(ASSET_BASE_URL, 'http://'.APP_DOMAIN);
define(IMAGE_BASE_URL, ASSET_BASE_URL."/images");

$GLOBALS['messages'] = array();

		

// define(MODELS, APP_ROOT."/models");
define(TEMPLATES, APP_ROOT."/templates");
define(MODELS, APP_ROOT."/models");


define(LIB, APP_ROOT."/lib");
require_once LIB."/utils.php";
require_once LIB."/DB.php";

require_once LIB."/form_helper.php";
// // 
// // require_once LIB."/wt_helper.php";
// $GLOBALS['db_link'] = db_link();
/////////////// defaultss /////////////////////
$win_title = '';




//template
$_t = isset($_REQUEST['t']) ? $_REQUEST['t'] : 'default';


//define
$_a = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main.default';
$_a = explode(".",$_a);
$_m = $_a[0];
$_v = $_a[1];


//include the model file
require MODELS."/".$_m."/".$_v.".php";

//set the template
require TEMPLATES."/" . $_t .".php";




// exit_and_close_db();

?>