<?php 

//db connection string


function db_link()
{
	global $dbhost, $dbuser, $dbpass, $db;
  $db_link = mysqli_connect($dbhost, $dbuser, $dbpass, $db)
      or die('The site database appears to be down.');
  return $db_link;
}

function close_db_link($db_link)
{
	mysqli_close($db_link);
}

function db_uuid() {
	$r = dbq("SELECT UUID();");
	$row = mysqli_fetch_row($r);
	return $row[0];
}

// connect, execute some sql, & close connection
function dbq($query) {
	if ($GLOBALS['debug']) {
		echo "<p>$query</p>";
	}
	$result = mysqli_query($GLOBALS['db_link'], $query);
	if ($result) {
		return $result;
	} else {
		die("<pre>QUERY ERROR: ".$query."\n".mysqli_error($GLOBALS['db_link'])."</pre>");
	}
}

function db_escape($string) {
	return mysqli_real_escape_string($GLOBALS['db_link'], $string);
}

function assoc_to_sql_arr($assoc)
{
	$sql_arr = array();
	foreach ($assoc as $key => $value) {
		array_push($sql_arr, "{$key} = '".db_escape($value)."'");
	}
	return $sql_arr;
}

// edf50a62-d2ee-102a-9fd1-001c23b974f2
function get_by_id($id, $table) {
	$table = db_escape($table);
	$id = db_escape($id);
	return dbq("SELECT * FROM tbl_{$table} WHERE {$table}_id = '{$id}';");
}

function close_db() {
	mysqli_close($GLOBALS['db_link']);
}

function exit_and_close_db() {
	close_db();
	exit;
}

