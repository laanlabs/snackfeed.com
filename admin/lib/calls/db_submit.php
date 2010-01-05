<?

$sql =  array();
while (list($key,$value) = each($_POST))
{
	$sql[ltrim($key,"_")] = $value;
	//${ltrim($key,"_")} = $value;
	
}


if ($key_org_id == '0') 
{
//INSERT
	$nSQL = "INSERT INTO {$key_table}s SET " . DB::assoc_to_sql_str($sql);



} else {
	//UPDATE
	$nSQL = "UPDATE {$key_table}s SET " . DB::assoc_to_sql_str($sql) . " WHERE {$key_table}_id = '" . $_POST['_' .$key_table .'_id']  . "';";
}

if ($_debug) echo $nSQL;

DB::query($nSQL , false);

?>