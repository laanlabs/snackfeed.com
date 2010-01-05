<?

$content_type = isset($_REQUEST['content_type']) ? $_REQUEST['content_type'] : 'text/xml';

header("Content-Type: " . $content_type);
header("Location: " . $_REQUEST['url']);

?>