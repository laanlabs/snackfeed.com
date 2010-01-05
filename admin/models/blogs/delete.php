<?
$_blog_id = $_REQUEST['blog_id'];
$sql = "DELETE FROM blogs  ";
$sql .= " WHERE blog_id = '" . $_blog_id . "'";


DB::query($sql , false);

header("Location: /?a=blog.list");

?>