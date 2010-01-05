<?php

//header("Content-type: image/jpeg");
$string = $_GET['text'];


$id="http://laan.com/laancom.png";
$sz=$size;
$savefile="tmp/laan".time().".png";

$ch = curl_init ($id);
$fp = fopen ($savefile, "w");
curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_exec ($ch);
curl_close ($ch);
fclose ($fp);


//$im = @ImageCreateFromJPEG ("tmp/button.jpg");
$im = @imagecreatefrompng ($savefile);
imagegif($im,"poop.gif");

?>
