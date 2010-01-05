<?

//die("down for for a bit -- its really erin andrews fault -- ");

//####################################################################################################
// ENVIRONMENT
//####################################################################################################
if ($_SERVER["SERVER_NAME"] == "dev.snackfeed.com") {
	define('APP_ENV', "dev");
	define('APP_ROOT', $_SERVER["DOCUMENT_ROOT"]."/..");
	define('APP_NAME', 'snackfeed');
	define('APP_DOMAIN', 'localhost:8080');
	define('BASE_URL', "http://dev.snackfeed.com");
} else {
	define('APP_ENV', "production");
	define('APP_ROOT', $_SERVER["DOCUMENT_ROOT"]."/..");
	define('APP_NAME', 'snackfeed');
	define('APP_DOMAIN', 'localhost:8080');
	define('BASE_URL', "http://www.snackfeed.com");
}


//####################################################################################################
// GLOBAL DEFAULTS
//####################################################################################################

global $response_output, $header_block, $sf_title, $sf_meta_keywords, $sf_meta_desc ;
$req_login = true;
$sf_title = "snackfeed - feeding you good web video";
$sf_meta_title = "";
$sf_meta_keywords = "video, search, online, news, viral, twitter, friendfeed, media, webisodes,  feeds, RSS, channel, guide, directory, podcasts";
$sf_meta_desc = "the best popular videos from around customized to your preferences";




/*
error_reporting(E_ALL ^ E_NOTICE);
define(APP_LOG, APP_ROOT . "/log/error.log");
ini_set('error_log', APP_LOG); // make sure errors get logged
function elog($string) { error_log($string."\n", 3, APP_LOG); } //// MAKE SURE THIS FILE EXISTS AND IS WRITABLE
*/

//####################################################################################################
// EXCEPTION
//####################################################################################################

function exception_handler($exception) {
  //echo "Uncaught exception: " , $exceptiongetMessagedd(), "\n";
}

set_exception_handler('exception_handler');


//####################################################################################################
// APP
//####################################################################################################
define('MODELS', APP_ROOT."/models");
define('VIEWS', APP_ROOT."/views");
define('TEMPLATES', APP_ROOT."/templates");
define('LIB', APP_ROOT."/lib");

//####################################################################################################
// LIBS
//####################################################################################################
require_once LIB."/utils.php";
require_once LIB."/DB.php";
require_once LIB."/partials.php";


//####################################################################################################
// MODELS
//####################################################################################################
require_once MODELS."/video.php";
require_once MODELS."/show.php";
require_once MODELS."/channel.php";
require_once MODELS."/pseudo_user.php";
require_once MODELS."/history.php";
require_once MODELS."/user.php";
require_once MODELS."/prefs.php";
require_once MODELS."/feed.php";
require_once MODELS."/status.php";
require_once MODELS."/watch.php";

require_once MODELS."/uvideo.php";

require_once MODELS."/search.php";

//####################################################################################################
// CONTROLLER
//####################################################################################################
require APP_ROOT."/controller.php";

?>