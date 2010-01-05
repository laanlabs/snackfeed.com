<?



//get id

if (stristr($_vars, 'video_id'))
{
	echo 'WE HAVE VIEDOE ID: ';
	parse_str($_vars);  

	$_youtube_id =  $video_id;
} else {

	$temp2 = explode("&", $_src);
	$_youtube_id = $temp2[0];
	$_youtube_id = str_replace("watch.swf?video_id=", "" ,$_youtube_id );
	$_youtube_id = str_replace("http://www.youtube.com/v/", "" ,$_youtube_id );
	
}

echo  $_youtube_id . "<br/>";




$_youTube_base = "http://www.youtube.com/v/";
$_youTube_get_URL = "http://www.youtube.com/get_video.php?video_id=__VID__&t=__TID__";
$_thumb_base = "http://s2.ytimg.com/vi/__ID__/default.jpg";


$_source_id = "e23bf93e-7fdb-102b-908a-00304897c9c6";
$_show_id = "92a439fe-80bc-102b-908a-00304897c9c6";

$_thumb = str_replace("__ID__", $_youtube_id, $_thumb_base);;

$_org_video_id = $_youtube_id;
$_url_source = $_youTube_base . $_youtube_id;
$_param_1		=  $_youTube_base;
$_param_2		=	$_youtube_id;
$_param_3		=	$_youTube_get_URL;




?>