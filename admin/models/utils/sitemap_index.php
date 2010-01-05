<?
$_t = "empty";

$_base = PUBLIC_ROOT;

$sql = " SELECT count(show_id) as vCount FROM shows";
$q = DB::query($sql);

$_vcount = $q[0]['vCount'];

$_show_count = ceil($_vcount/100);

$header = '<?xml version="1.0" encoding="utf-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<sitemap>
<loc>http://snackfeed.com/sitemap_custom.xml</loc>
</sitemap>';
$output = "";

// SHOWS SITEMAPS
for ($i=1; $i < $_show_count+1 ; $i++) { 
	
$output .= "\r\n<sitemap>
\t<loc>http://snackfeed.com/sitemap_shows_{$i}.xml</loc>
</sitemap>";	
}

//POPULAR VIDEOS INDEX
for ($i=1; $i < 11 ; $i++) { 
	
$output .= "\r\n<sitemap>
\t<loc>http://snackfeed.com/sitemap_videos_popular_{$i}.xml</loc>
</sitemap>";	
}

//NEW VIDEOS INDEX
for ($i=1; $i < 21 ; $i++) { 
	
$output .= "\r\n<sitemap>
\t<loc>http://snackfeed.com/sitemap_videos_new_{$i}.xml</loc>
</sitemap>";	
}

$output .= "\r\n</sitemapindex>";

$sitemap_xml = $_base . "/sitemap_index.xml";
if (file_exists($sitemap_xml))  unlink($sitemap_xml);

$fh = fopen($sitemap_xml, 'w') or die("can't open file");
fwrite($fh, $header . $output);
fclose($fh);
	
echo "FILE WRITTEN: {$sitemap_xml} <br/>";		





//header("Content-type: text/xml");
//echo $header . $output;
?>


