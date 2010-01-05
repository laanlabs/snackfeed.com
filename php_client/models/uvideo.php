<?php



class UVideo {
	
	public static function latest($req)
	{
	
	global $rows;
	
	$options = array( "limit" => 1);	
	
	$rows = self::find($options);
	
	
	}
	public static function hello($req)
	{
		
		require_once LIB."/flv_to_anigif.php";
		$vid = "2d9fe076-8c56-102b-b533-001c23b974f2";
		
		$imgname = FlvToGif::makeJpg( "/var/www/sf-public/webroot/static/flvs/".$vid.".flv" , "/var/www/sf-public/webroot/static/thumbs/" , $vid );
		
		if ( $imgname )
		echo "new image: ".$imgname;
		else 
		echo "errr";
		
		die();
		
	}
	
	public static function getUUID($req)
	{
		
		echo DB::UUID();
		die();
		
	}
	
	public static function insert($req)
	{
		
		
		
		if ( !array_key_exists('uvideo_id', $req) ) {
			throw new Exception("MISSING REQUIRED KEY(S):  uvideo_id", 1); die();
		}
		
		
		
		require_once LIB."/flv_to_anigif.php";
		
		$vid = $req["uvideo_id"];//"2d9fe076-8c56-102b-b533-001c23b974f2";
		$imgname = FlvToGif::makeJpg( "/var/www/sf-public/webroot/static/flvs/".$vid.".flv" , "/var/www/sf-public/webroot/static/thumbs/" , $vid );
		
		$thumb = "/static/thumbs/".$imgname;
		$flv_source = "/static/flvs/".$vid.".flv";
		
		$_date = date("Y-m-d G:i:s");
		
		//$req["show_id"] = '4c056f60-91e0-102b-b533-001c23b974f2';
		
		$_base = 'http://www.snackfeed.com';
		$_player = $_base . $flv_source;
		
		


		
		//insert into videos
		$sql = "
			INSERT INTO videos SET
			video_id = '{$req["uvideo_id"]}',
			show_id = '{$req["show_id"]}',
			title = '{$req["title"]}',
			detail = '{$req["detail"]}',
			thumb =    '{$_base}{$thumb}',
			date_pub = '{$_date}',
			date_air = '{$_date}',
			date_added = '{$_date}',
			url_source = '{$_player}',
			use_embedded = 0
				;";		
		//echo $sql;
		
		DB::query($sql, false);

		$sql = "
			INSERT INTO uvideos SET
			uvideo_id = '{$req["uvideo_id"]}',
			show_code = '{$req["app_code"]}',
			user_id ='{$req["user_id"]}',
			param_1 = '{$req["param_1"]}',
			param_2 = '{$req["param_2"]}',
			param_3 = '{$req["param_3"]}',
			date_created = '{$_date}';
				;";		
		//echo $sql;
		
		DB::query($sql, false);
		
		$data = array( "response" => 1);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
		
	}
	
	
	
	public static function get($req) {
		
		$rows = self::find($req);
		$data = array("videos" => $rows);
		
		if (array_key_exists('json', $req)) {
			echo json_encode($data); die();
		} else {
			render_data_as_xml($data);
		}
		
	
	
	
	}
	
	
	
	public static function find($options = array()) {
		
		
		
		$defaults = array("order" => "uv.date_created-DESC, v.title ", "limit" => 100, "offset" => 0);
		$options = array_merge($defaults, $options);
		
		
		
		$options['order'] = str_replace("-", " ", $options['order']);
		
		foreach ($options as $key => $value) {
			$options[$key] = DB::escape($value);
		}
		
		
		
			$joins = "";
			$columns = "";
			$conditions = "1";
			
		if (array_key_exists("uvideo_id", $options)) {
			$conditions .= " AND uv.uvideo_id = '{$options['uvideo_id']}'";
		}
		
		if (array_key_exists("show_id", $options)) {
			$conditions .= " AND v.show_id = '{$options['show_id']}'";
		}
		
		if (array_key_exists("app_code", $options)) {
			$conditions .= " AND uv.show_code = '{$options['app_code']}'";
		}
		
		
	
			
		if (array_key_exists("date", $options)) {	
			$conditions .= " AND v.date_created > '{$options['date']}' ";
			
		}	
		
		
	
		
		$sql = "
			SELECT *
			{$columns}
			FROM videos v INNER JOIN uvideos uv ON v.video_id = uv.uvideo_id
			{$joins}
			WHERE {$conditions}
			ORDER BY {$options['order']}
			LIMIT {$options['offset']}, {$options['limit']}
			
		";
		

		
		$results = DB::query($sql);
		
		return $results;
		
	}
	
	
	
	
	
	
}

?>