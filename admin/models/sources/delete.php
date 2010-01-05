<?

$_source_id = $_REQUEST['source_id'];



$sql = "DELETE FROM sources  ";
$sql .= " WHERE source_id = '" . $_source_id . "'";

//echo "dsafds: " . $sql;

$q = mysqli_query($link, $sql);

//echo "Affected rows (UPDATE): " . mysqli_affected_rows($link) . "<br/>";


mysqli_close($link);

header("Location: /?a=sources.list");

?>
  

?>