<?

$_t = "blank";
$conditions = "1";

if ($_REQUEST['errors'] == "1") 
{
	$conditions .= " AND b.status < 1 ";
}

if ($_REQUEST['slow'] == "1") 
{
	$conditions .= " AND b.millseconds > 10 ";
}


$rowcount = 0;
$sql = " SELECT b.*, s.title, sc.name as source_name
FROM batchs b
 LEFT OUTER JOIN shows s ON b.show_id = s.show_id
 LEFT OUTER JOIN sources sc ON b.source_id = sc.source_id
WHERE 
	{$conditions} 
 ORDER BY date_started DESC
 LIMIT 400 ";
$q = DB::query($sql);

?>

