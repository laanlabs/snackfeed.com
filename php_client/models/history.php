<?php

class History {
	
	// NOTES ....
	
	//  we may need to have the parent/child system use history_item_ids rather than 
	// the user stuff as the name, because getting trees back where the same ppl do
	// a few actions within the tree makes it tough.
	/// like if i watch it, and my friends see it my feed, then 3 days later i send
	// it out to ppl, how will that work? get the most recent history?
	
	public static function get_new_id() {
		
		DB::query("INSERT INTO history_ids SET time_created = NOW();", false);
		return DB::last_insert_id();
		
	}
	
	public function process() {
		
		
		if ( $this->url_user_nickname || $this->url_pseudo_user_id ) {
			
			// look up based on these and the video id.
			
			$this->get_user_history();
			$this->update_user_history();
			
			// if there is an item, we will create another history using that ID, otherwise, begin a new history.
			
			
		} else {
			
			// generate a new history using the pseudo id, or logged in id.
			
			// and redirect.
			//insert history item, setting parent_id to u/p
			
			
		}
		
	}
	
	public function get_user_history() {
		
		
		$video_id = DB::escape($this->video_id);
		
		if ($this->url_user_nickname) {
			// lookup and set this->url_user_id
			$nickname = DB::escape($this->url_user_nickname);
			$r = DB::query("SELECT user_id FROM users WHERE nickname = '$nickname'");
			
			if (!empty($r)) {
				
				//echo "Got a user id for the referrer: ". $r[0]['user_id'];
				
				$this->url_user_id = $r[0]['user_id'];
				
				// lookup on user_id and video_id
				
				
				$user_id = DB::escape($this->url_user_id);
				$rows = DB::query("SELECT history_id 
													 FROM history_items 
													 WHERE video_id = '{$video_id}' 
													 AND user_id = '{$user_id}'
													 ORDER BY time_created DESC
													 LIMIT 1");
				//echo "Printing the retrieved history <br/>";
				
				//print_r($rows);
				
				if (!empty($rows)) {
					$this->history_id = $rows[0]['history_id'];
					//echo "Not empty!!! ".$this->history_id;
				}
				
			}
			
			
		} elseif ( $this->url_pseudo_user_id ) {
			
			$pseudo_user_id = DB::escape($this->url_pseudo_user_id);
			$rows = DB::query("SELECT history_id 
												 FROM history_items 
												WHERE video_id = '{$video_id}' 
												AND pseudo_user_id = '{$pseudo_user_id}'
												ORDER BY time_created DESC
												LIMIT 1");
			if (!empty($rows)) {
				$this->history_id = $rows[0]['history_id'];
			}
			
		}
		return $this->history_id;
	}
	
	public function update_user_history() {
		
		
			$user_id = DB::escape($this->viewing_user_id);
			$pseudo_user_id = DB::escape($this->viewing_pseudo_user_id);
			$video_id = DB::escape($this->video_id);
			if ($this->url_user_id) {
				$parent_id = DB::escape($this->url_user_id);
			} else {
				$parent_id = DB::escape($this->url_pseudo_user_id);
			}
			
			// dump($this);exit;
			if ( !$this->history_id ) {
				
				$this->history_id = self::get_new_id();
				
				if ($this->url_user_id) {
					// legacy, this shouldnt really happen...
					// create the item for the parent, the "root" history item... then attach this viewing_user_id to it.
					DB::query("INSERT INTO history_items
						SET history_id = '{$this->history_id}',
						video_id = '$video_id',
						user_id = '$parent_id',
						pseudo_user_id = '$pseudo_user_id'
					", false);
				
				}
				
			} else {
				
				if ( $this->viewing_user_id != "" && ($this->viewing_user_id == $this->url_user_id) ) {
					///echo "Quitting!! ";
					return;
					 // don't do another insert if there is already a history item for someone watching their own video
				} else if ( $this->viewing_pseudo_user_id != "" && ($this->viewing_pseudo_user_id == $this->pseudo_user_id) ) {
					//echo "Quitting 2 ".$this->viewing_pseudo_user_id;
					return;
					
				}
			}
			
			//echo "AGAIN: hist id: ".$this->history_id;
			//echo "<br/>Pseudo? :".$pseudo_user_id;
			
			DB::query("INSERT INTO history_items
				SET history_id = '{$this->history_id}',
				video_id = '$video_id',
				user_id = '$user_id',
				parent_id = '$parent_id',
				pseudo_user_id = '$pseudo_user_id'
			", false);
			
	}
	
	
	public function get_history_from_history_id( $id , $_viewer_id ) {
		
		//echo "Getting history: ".$this->history_id;
		
		$rows = DB::query("SELECT u.nickname, u.thumb, h.pseudo_user_id, h.parent_id, h.user_id
											 FROM history_items h 
											 left join users u on u.user_id = h.user_id
											 WHERE h.history_id = '{$id}' 
										 	 ORDER BY h.time_created asc
											 LIMIT 100");
											
		//dump( $rows );
		
		//echo "OK<br/>";
		
		//$new_array = $this->full_thread( $rows , "" );
		
		$_referrer_id = $this->url_user_id;
		//echo "WET: ".$_referrer_id ;
		$new_array = $this->get_linear_viewing_history( $rows , $_viewer_id , $_referrer_id );
		
		//$this->print_recursive( $new_array );
		//dump( $rows );
		
		return $new_array;
		//die();
	}
	
	public function print_recursive( $arr , $depth = "" ) {
		
			
			foreach ( $arr as $item ) {
				
				$namer = $item["nickname"] != "" ? $item["nickname"] : $item["pseudo_user_id"];
				
				echo $depth." " . $namer."</br>";
				
				if ( $item["children"] ) {
					//echo "+<br/>";
					$this->print_recursive( $item["children"] , $depth."--" );
				}
			}
		
	}
	
	
	public function full_thread( $start_array , $seed_parent ) {
		
		foreach ( $start_array as $item ) {
			
			//echo "Checking item with pid: ".$item["parent_id"]."- <br/>";
			
			if ( $item["parent_id"] == $seed_parent ) {
				
				//echo "found parent<br/>";
				
				// got the parent node...
				
				if ( !$current_array )
				$current_array = array();
				
				
				$new_item = array();
				$new_item["nickname"] = $item["nickname"];
				$new_item["user_id"] = $item["user_id"];
				$new_item["pseudo_user_id"] = $item["pseudo_user_id"];
				
				
				// remove the thing we just found from the master array...
				$indexx = (int) array_search( $item, $start_array );
				array_splice( $start_array , $indexx , 1 );
				
				//echo "gettign children with pid=".$new_item["user_id"]."<br/>";
				// get all children
				$new_item["children"] = $this->full_thread( $start_array , $new_item["user_id"] );
				
				$current_array[] = $new_item;
				
			}
			
		}
		
		return $current_array;
		
	}
	
	public function get_linear_viewing_history( $_rows , $_end_user_id , $_ref_id ) {
		
		$_return_arr = array();
		
		$_count = count($_rows);
		
		$_current_id = $_end_user_id;
		
		$_num_branches = 0;
		
		for ( $r = 0; $r < $_count ; $r++ ) {
			
			if ( $_rows[$r]["user_id"] == $_current_id ) {
				
				$_return_arr[] = $_rows[$r];
				
				$_current_id = $_rows[$r]["parent_id"];
				
				// remove the item and keep going
				array_splice( $_rows , $r , 1 );
			
				//$_num_branches ++;
				
				//if ( $_num_branches == 1 ) 
				//$_current_id = $_ref_id; // this is a hack, it just gaurantees that the second link is the one from the referrer in the url, and not one that was found internally
				
				$r = -1;
				$_count = count( $_rows );
				
			} 
			
		}
		
		
		return array_reverse( $_return_arr );
		
	}
	
	
	public static function get_views_user_is_responsible_for( $_user_id ) {
		
		
		$rows = DB::query("SELECT count( h.history_item_id ) as views
											 FROM history_items h 
											 WHERE h.parent_id = '{$_user_id}'
										 ");
											
											
		return $rows[0]["views"];
		
	}
	
	
}
?>