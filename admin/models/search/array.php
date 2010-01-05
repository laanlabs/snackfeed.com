<?

//starttime
$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];

$_t = "empty";


$words =  array();
$wordKey = array();
$no_words = array();
$wWords = array();

$file = "/var/www/sf-public/webroot/static/data/all.txt";
$row = 0;
$handle = fopen($file, "r");
while (($data = fgetcsv($handle, 1000, " ")) !== FALSE) {
	$_key = $data[0];
	$words[$row]=  $data[0];
	$wordKey[$_key]=  $data[1];
	//$words[$row][1]=  $data[1];
    $row++;
}
fclose($handle);

$file = "/var/www/sf-public/webroot/static/data/stopwords.txt";
$row = 0;
$handle = fopen($file, "r");
while (($data = fgetcsv($handle, 1000, " ")) !== FALSE) {
	$no_words[$row]=  $data[0];
	//$words[$row][0]=  $data[0];
	//$words[$row][1]=  $data[1];
    $row++;
}
fclose($handle);

$result = array_diff($words, $no_words);

$k=0;
for ($i=0; $i < count($result) ; $i++) { 
	$_key = $result[$i];

	if (strlen($_key) > 0 ) {
	$wWords[$k][0] = $result[$i];
	$wWords[$k][1] =  $wordKey[$_key];
	$k++;
	}
}

function compare($x, $y)
{
if ( $x[1] == $y[1] )
 return 0;
else if ( $x[1] < $y[1] )
 return 1;
else
 return -1;
}

usort($wWords, 'compare');

$_max = $wWords[0][1];
$_min = $wWords[count($wWords)][1];


for ($i=0; $i < count($wWords) ; $i++) { 
?>

<a href=""><?= $wWords[$i][0]?></a>

<?

	
}


$endtime = microtime();
$endarray = explode(" ", $endtime);
$endtime = $endarray[1] + $endarray[0];
$totaltime = $endtime - $starttime;
$totaltime = round($totaltime,5);
echo "This page loaded in $totaltime seconds.";

?>