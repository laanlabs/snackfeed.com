<?php

class Watch {
	

	public static function show($req)
	{
		$conditions = "";

		
		if ( !array_key_exists('show_id', $req) ) {
				$sql = " SELECT * FROM shows WHERE '" . str_replace("_", " ", $req['id']) . "'";
				$q = DB::query($sql);
				$req = array_merge(array("show_id" => $q[0]['show_id']), $req);
		} 
		
		switch ($req["date_range"])
		{
			case "month" :
				$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m")-1,date("d"),date("Y")) );
				break;
			case "week" :
					$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-7,date("Y")) );
					break;
			 default :
				$_date = date("Y-m-d G:i:s", mktime(0,0,0,date("m"),date("d")-12,date("Y")) );
		}
		
		//$req = array_merge(array("date" => $_date), $req);
	
		$req = array_merge(array("nosegments" => 1), $req);

		
		global $show;
		
		$show = Show::find_show_data($req);
		
		
		
	}



	
}

?>
