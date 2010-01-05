<?

class RssHelper {
	
	public static function print_rss( $rss_meta , $data) {
			
			// data should have:
			// rss_url
			// title
			
			/*
			rss_meta['title']
			$rss_meta['desc']
			$rss_meta['url']
			
			$item['title']
			$item['detail']
			$item['video_id']
			$item['thumb']
			$item['date_formatted']
			
			*/
			
			
			include LIB."/external_video_helper.php";
			
			$_rss_url = BASE_URL . "/feeds/user/";
		
			//$opts = array ("user_id" => $_user_id);
		
			//$rows = Feed::find_blog_data($opts );
		
			$now = date("D, d M Y H:i:s T");
			
			
			$output = "<?xml version=\"1.0\"?>
			            <rss version=\"2.0\"  xmlns:media=\"http://search.yahoo.com/mrss/\">
			               <channel>
			               <title>{$rss_meta['title']}</title>
			               <link>{$rss_meta['url']}</link>
			               <description>{$rss_meta['desc']}</description>
			               <language>en-us</language>
			               <pubDate>$now</pubDate>
			               <lastBuildDate>$now</lastBuildDate>
			               <docs>http://snackfeed.com/rss/help</docs>
			               <managingEditor>info@snackfeed.com</managingEditor>
			               <webMaster>info@snackfeed.com</webMaster>";
			
			foreach ($data as $item)
			{
				
				$_date = date("r", strtotime($item['date_formatted']));
				$_desc = $item['detail'];
				
				// could be relative in the case of our shows, or for videos might be full path
				$_thumb = $item['thumb'];
				$_link = BASE_URL."/videos/detail/".$item['video_id'];
				// need to add embedded videos here.
				
				$_swf_url = ExternalVideoHelper::get_embed_location( $item , "snackfeed" );
				$_title = preg_replace('/[^A-Za-z0-9-,.]/', ' ', $item['title']);
				
				$output .= "<item><title>{$_title}</title>
<link>{$_link}</link>
<description>
<![CDATA[
<img src=\"{$_thumb}\" align=\"right\" border=\"0\"  width=\"100\"  vspace=\"4\" hspace=\"4\" />".htmlentities(stripslashes($_desc))."
]]></description>
<media:thumbnail url=\"{$_thumb}\" height=\"90\" width=\"120\"/>
<pubDate>{$_date}</pubDate>
<enclosure url=\"{$_swf_url}\" type=\"video/x-shockwave-flash\" />
<guid>{$item['video_id']}</guid>	
</item>";
					
			}
			
				
			$output .= "</channel></rss>";
			header("Content-Type: application/rss+xml");
			echo $output;
		
		die();

	}
	
	
}








?>