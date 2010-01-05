<?
$_t = "empty";

$cmd = "indexer delta --rotate";
echo $cmd . "<br/>";
echo exec($cmd);
echo "<br/>";

$file = "/var/www/sf-public/webroot/static/data/daily.txt";
unlink($file);
$cmd = "indexer delta --buildstops {$file} 600 --buildfreqs";
echo $cmd . "<br/>";
echo exec($cmd);
echo "<br/>";




$cmd = "searchd --stop ; indexer --merge videos delta ; searchd";
echo $cmd . "<br/>";
echo exec($cmd);




?>