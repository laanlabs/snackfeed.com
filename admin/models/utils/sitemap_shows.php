<?
$_t = "empty";

$_base = PUBLIC_ROOT;

$sql = " SELECT DISTINCT s.show_id, s.title, s.detail, s.thumb, sc.source_id, sc.name as source_name 
 	FROM shows s LEFT OUTER JOIN sources sc ON s.source_id = sc.source_id
 	WHERE 1  
 	ORDER BY s.title, s.order_by, s.title DESC
	-- LIMIT 120 ;";
	
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
	
$output .= "\r\n<url>
\t<loc>http://snackfeed.com/shows/detail/{$q[$i]['show_id']}/{$_title}</loc>
\t<changefreq>weekly</changefreq>
</url>";	
//\t<priority>1.0</priority>
//\t<lastmod>2004-01-14T06:21:47-04:00</lastmod>	
 
if ($k == 100)
{
	$k=0;
	$output .= "\r\n</urlset>";
	
	$sitemap_xml = $_base . "/sitemap_shows_" . $j . ".xml";
	if (file_exists($sitemap_xml))  unlink($sitemap_xml);
	
	$fh = fopen($sitemap_xml, 'w') or die("can't open file");
	fwrite($fh, $header . $output);
	fclose($fh);
		
	echo "FILE WRITTEN: {$sitemap_xml} <br/>";
	
	
	$output = "";
	$j++;
} 

	
}

//finish rement
if ($k > 0 )
{
		
	$output .= "\r\n</urlset>";
	
	$sitemap_xml = $_base . "/sitemap_shows_" . $j . ".xml";
	if (file_exists($sitemap_xml))  unlink($sitemap_xml);
	
	$fh = fopen($sitemap_xml, 'w') or die("can't open file");
	fwrite($fh, $header . $output);
	fclose($fh);
		
	echo "FILE WRITTEN: {$sitemap_xml} <br/>";		
}





//header("Content-type: text/xml");
//echo $header . $output;
?>


