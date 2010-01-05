<?php

class ExternalVideoHelper {
	
	
	
	public static function get_embed_location( $params , $type ) {
	
		if ( $type == "yt" ) {
			
			return "http://www.youtube.com/v/".$params['video_id'];
			
		} else if ( $type == "snackfeed" ) {
			
			return BASE_URL."/static/swfs/simplePlayer.swf?id=".$params['video_id'];
			
			// the other player?
			//return BASE_URL . "/static/swfs/embedPlayer.swf?id=" . $params['_video_id'];
			
		}
		
	}
	
	public static function get_embed_code( $params , $type  ) {
		
		
		$_embed_base = '<object width="425" height="355"><param name="movie" value="__URL__"></param><param name="wmode" value="transparent"></param><embed src="__URL__" type="application/x-shockwave-flash" wmode="transparent" width="425" height="355"></embed></object>';
		
		
		//determine if is embedded
		if ( $params['use_embedded'] == '1')
		{
			
			$_url = $params['url_source'];
			
		} else {
			
			//use our player
			$_video_id = $params['id'] ? $params['id'] : ( $params['video_id'] ? $params['video_id'] : ($params['_video_id']) );
			
			$_url = BASE_URL . "/static/swfs/embedPlayer.swf?id=" . $_video_id;
			
		}
		
		
		
		$_embed = str_replace("__URL__", $_url, $_embed_base  );
		
		return $_embed;
		
	}

}



?>
