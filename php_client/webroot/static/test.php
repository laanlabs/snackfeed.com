<?

$txt = file_get_contents('http://youtube.com/watch?v=Z_qBWLAdKoE');

preg_match('/video_id:\'[\w]{11}\'/', $txt, $video_id_temp);
preg_match('/[\w]{11}/',$video_id_temp[0],$video_id_temp2);
$video_id = $video_id_temp2[0];

preg_match('/l:\'[\d]{1,15}\'/',$txt,$l_temp);
preg_match('/[\d]{1,15}/',$l_temp[0],$l_temp2);
$l = $l_temp2[0];

preg_match('/t:\'[\w]{32}\'/',$txt,$t_temp);
preg_match('/[\w]{32}/',$t_temp[0],$t_temp2);
$t = $t_temp2[0];

echo "http://youtube.com/get_video.php?video_id=".$video_id."&l=".$l."&t=".$t;
$url="http://youtube.com/get_video.php?video_id=";

print "<td><tr><a href='".$url.$video_id."'>   Download</a></td></tr>";

$txt = file_get_contents('http://youtube.com/watch?v=Z_qBWLAdKoE');

preg_match('/video_id:\'[\w]{11}\'/', $txt, $video_id_temp);
preg_match('/[\w]{11}/',$video_id_temp[0],$video_id_temp2);
$video_id = $video_id_temp2[0];

preg_match('/l:\'[\d]{1,15}\'/',$txt,$l_temp);
preg_match('/[\d]{1,15}/',$l_temp[0],$l_temp2);
$l = $l_temp2[0];

preg_match('/t:\'[\w]{32}\'/',$txt,$t_temp);
preg_match('/[\w]{32}/',$t_temp[0],$t_temp2);
$t = $t_temp2[0];

echo "http://youtube.com/get_video.php?video_id=".$video_id."&l=".$l."&t=".$t;
$url="http://youtube.com/get_video.php?video_id=";

print "<td><tr><a href='".$url.$video_id."'>   Download</a></td></tr>";


?>