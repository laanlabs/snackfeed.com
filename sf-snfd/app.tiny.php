<?php



// phpinfo();
ini_set('display_errors', 1);
define('APP_ROOT', $_SERVER["DOCUMENT_ROOT"]."/..");
//####################################################################################################
// APP
//####################################################################################################
define('MODELS', "/var/www/sf-public/models");
define('VIEWS', APP_ROOT."/views");
define('TEMPLATES', APP_ROOT."/templates");
define('LIB', "/var/www/sf-public/lib");

//####################################################################################################
// LIBS
//####################################################################################################
require_once LIB."/utils.php";
require_once LIB."/DB.php";
require_once LIB."/TinyHelper.php";
require_once MODELS."/video.php";

$tiny_id = TinyHelper::base_to_decimal($_REQUEST['tiny_id'], 62);
$r = DB::query("SELECT video_id FROM videos WHERE video_iid = ".DB::escape($tiny_id)." LIMIT 1");
if (empty($r)) {
	echo "<p>We could not find the video you were looking for.  <a href='http://snackfeed.com'>snackfeed.com</a>.</p>";
	DB::close_and_exit();
} else {
	$url = "http://snackfeed.com/videos/detail/".$r[0]['video_id'];
	DB::close();
	header("Location: $url");
}

// echo "<br>";
// echo TinyHelper::base_to_decimal("2u", 62);
// echo "<br>";
// echo TinyHelper::decimal_to_base(51120, 62);
// echo "<br>";
// print_r($_REQUEST);

?>
