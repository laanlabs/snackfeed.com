<?
$_t = "empty";

$_base = PUBLIC_ROOT;

$sql = "SELECT count(uv.video_id) as video_count,
		v.video_id, v.title, v.detail, v.thumb, s.title as show_title,
    DATE_FORMAT(v.date_added, '%a, %d %b %Y %T')as date_formated
		FROM user_videos uv
			JOIN videos v ON uv.video_id = v.video_id
      JOIN shows s ON v.show_id = s.show_id
      -- AND v.date_added > '{$_date}'
		GROUP BY uv.video_id
		ORDER BY video_count DESC
		LIMIT 1000";
	
//echo $sql;	die();
	
$q = DB::query($sql);

$header = '<?xml version="1.0" encoding="utf-8"?>
<urlset xmlns:video="http://www.google.com/schemas/sitemap-video/1.0" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$output = "";


$k = 0;
$j = 1;
for ($i=0; $i < count($q) ; $i++) { 

$k++; 

$_title = htmlspecialchars(str_replace(" ", "-", $q[$i]['title']));
$_title_1 = htmlspecialchars( $q[$i]['title'] );

$_thumb = $q[$i]['thumb'];
if (strlen($_thumb) < 5 ) $_thumb = "http://www.snackfeed.com/images/default.jpg";
	
$output .= "\r\n<url>
<loc>http://snackfeed.com/video/detail/{$q[$i]['video_id']}/{$_title}</loc>
<changefreq>daily</changefreq>
<priority>0.9</priority>
<video:video>
 <video:title>{$_title_1}</video:title>
 <video:thumbnail_loc><![CDATA[{$_thumb}]]></video:thumbnail_loc>
 <video:description>
 <![CDATA[{$q[$i]['show_title']} - {$q[$i]['detail']} - {$q[$i]['date_formated']} ]]>
 </video:description>
</video:video>
</url>";	
//\t<lastmod>2004-01-14T06:21:47-04:00</lastmod>	

if ($k == 100)
{
	$k=0;
	$output .= "\r\n</urlset>";
	
	$sitemap_xml = $_base . "/sitemap_videos_popular_" . $j . ".xml";
	if (file_exists($sitemap_xml))  unlink($sitemap_xml);
	
	$fh = fopen($sitemap_xml, 'w') or die("can't open file");
	fwrite($fh, $header . $output);
	fclose($fh);
		
	echo "FILE WRITTEN: {$sitemap_xml} <br/>";
	
	
	$output = "";
	$j++;
} 

	
}







//header("Content-type: text/xml");
//echo $header . $output;
?>


