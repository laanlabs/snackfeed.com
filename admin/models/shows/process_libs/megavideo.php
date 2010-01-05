<?php

$url = (isset($_GET["url"])) ? strval($_GET["url"]) : "";
$lookup = Array("_" => "b", "I" => "t", "J" => "w", "K" => "v", "M" => "p", "N" => "s", "P" => "m", "Q" => "l", "R" => "o", "T" => "i", "U" => "h", "X" => "e", "Y" => "d", "Z" => "g", "%04" => "9", "%05" => "8", "%07" => ":", "%08" => "5", "%09" => "4", "%0A" => "7", "%0B" => "6", "%0C" => "1", "%0D" => "0", "%0E" => "3", "%0F" => "2", "%12" => "/", "%13" => ".", "%5B" => "f", "%5C" => "a", "%5E" => "c");

if ($html = file("$url"))
{
foreach($html as $value)
{
if(preg_match('/"flv","(.*?)"/', $value, $match))
{
$video_url = strtr($match[1], $lookup);
}
}
header('Location: ' . $video_url);
}

?>



OK, if you guys haven't solved it yet, I guess I'll give you a "little" hint.

This URL:

http://megavideo.com/?v=4R2Y3TWF

contains this "jibberjabber": (paste into your text editor with word wrap OFF)

"flv","UIIM%07%12%12JJJ%0D%08%13PXZ%5CKTYXR%13%5ERP%12%5BTQXN%12X%0DX%5E%09%0CY%0B%5E%05%0B%04X%08%04%0F%0A%0C%0E%08%5E%5E%0C%04%08Y%5B%04%0B%0C%0D%0D%12

which translates into this:

req: http : / / www 0 5 . meg a video . c om / f iles / e 0 e c 4 1 d 6 c 8 6 9 e 5 9 2 7 1 3 5 c c 1 9 5 d f 9 6 1 0 0 /

which (without the spaces) is this URL:

http://www05.megavideo.com/files/e0ec41d6c869e5927135cc195df96100/

which gets the video file.

So just use this lookup table (put it into an aray in PHP) to translate the "jibberjabber" to a good URL.

Lookup table:
_=>b
E=>c
I=>t
J=>w
K=>v
M=>p
N=>s
P=>m
Q=>l
R=>o
T=>i
U=>h
X=>e
Y=>d
Z=>g
%04=>9
%05=>8
%07=>:
%08=>5
%09=>4
%0A=>7
%0B=>6
%0C=>1
%0D=>0
%0E=>3
%0F=>2
%12=>/
%13=>.
%5B=>f
%5C=>a
%5E=>c