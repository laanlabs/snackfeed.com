<?
$_t = "empty";

$cmd = "indexer videos --rotate";
echo $cmd . "<br/>";
echo exec($cmd);
echo "<br/>";

$file = "/var/www/sf-public/webroot/static/data/all.txt";
unlink($file);
$cmd = "indexer videos --buildstops {$file} 600 --buildfreqs";
echo $cmd . "<br/>";

echo exec($cmd);
 

?>