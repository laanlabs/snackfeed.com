<?php

function dump($object)
{
	echo "<pre>";
	if (gettype($object) == "string") {
		echo $object;
	} else {
		print_r($object);
	}
	echo "</pre>";
}


function image_upload_jpg($server_root, $path, $name )
{
	
	$target_path = $server_root . $path;
	$target_file = $target_path . $name . ".jpg";
	$target_thumb = $path . $name . ".jpg";

	  if ($_FILES["file"]["error"] > 0)
	    {
	   // echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    }
	  else
	    {
	    //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	    //echo "Type: " . $_FILES["file"]["type"] . "<br />";
	    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	    if (file_exists($target_file))
	      {

		  //delete file if exists
	      //echo $target_file . " already exists. ";
		  unlink($target_file);
	      }

	      move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	      // echo "Stored in: " . $target_file;
		 
		  return $target_thumb;

	    }
	
}


function _makesqldate($_old_date)
{
	
	
		$dtmp = explode("/", $_old_date);
		$_month = $dtmp[0];
		$_day = $dtmp[1];
		$_year = $dtmp[2];

		$_date=  $_year . "-" . $_month . "-" . $_day;
		
		return $_date;
	
}


 function _normaliseDate($date)
{
    $date =  preg_replace("/([0-9])T([0-9])/", "$1 $2", $date);
    $date =  preg_replace("/([\+\-][0-9]{2}):([0-9]{2})/", "$1$2", $date);
    $time = strtotime($date);                       
    if (($time - time()) > 3600) {             
        $time = time();             
    }
    $date = gmdate("Y-m-d H:i:s O", $time);
    return $date;
}

function __removeEvilAttributes($tagSource)
{
       $stripAttrib = "' (style|class)=\"(.*?)\"'i";
       $tagSource = stripslashes($tagSource);
       $tagSource = preg_replace($stripAttrib, '', $tagSource);
       return $tagSource;
}

function _removeEvilTags($source)
{
   $allowedTags='<b><i>' .
             '<strong><u><em>';
   $source = strip_tags($source, $allowedTags);
   return trim(preg_replace('/<(.*?)>/ie', "'<'.__removeEvilAttributes('\\1').'>'", $source));
}

function quote_csv($string) {
	$arr = explode(",", $string);
	$arr = array_map("single_quote", $arr);
	return implode(", ", $arr);
}



function single_quote($str) {
	return "'{$str}'";
}


function ping_blogs($ping_title,$ping_url,$ping_rss ){
	
	include APP_ROOT . '/lib/jsonrpc/ClientXmlRpc.class.php';
	
	$__xmlrpc_server['Weblogs']=array('url'=>'http://rpc.weblogs.com/RPC2',
		'method'=>'weblogUpdates.extendedPing',
		'params'=>array($ping_title,$ping_url,$ping_url,$ping_rss ));
	
	$__xmlrpc_server['Google']=array('url'=>'http://blogsearch.google.com/ping/RPC2',
		'method'=>'weblogUpdates.extendedPing',
		'params'=>array($ping_title,$ping_url,$ping_url,$ping_rss ));
	
	$__xmlrpc_server['Pingomatic']=array('url'=>'http://rpc.pingomatic.com/',
		'method'=>'weblogUpdates.extendedPing',
		'params'=>array($ping_title,$ping_url,$ping_url,$ping_rss ));
	
	$__xmlrpc_server['blo.gs']=array('url'=>'http://ping.blo.gs/',
		'method'=>'weblogUpdates.extendedPing',
		'params'=>array($ping_title,$ping_url,$ping_url,$ping_rss ));
	
	$__xmlrpc_server['Technorati']=array('url'=>'http://rpc.technorati.com/rpc/ping',
		'method'=>'weblogUpdates.extendedPing',
		'params'=>array($ping_title,$ping_url,$ping_url,$ping_rss ));
	
	foreach ($__xmlrpc_server as $name=>$server)
	{
			$xmlrpc=new ClientXmlRpc($server['url']);
			$xmlrpc->call($server['method'],$server['params']);
			print_r($xmlrpc->get_method_response());
	
	}

}


function s_search($q, $limit= 20 )
{

	require_once ( "/var/www/sf-admin/lib/sphinxapi.php" );	
	$mode = SPH_MATCH_ALL;
	$limit = 20;
	$ranker = SPH_RANK_PROXIMITY_BM25;
	$index = "videos";
	
	$cl = new SphinxClient();
	$cl->SetServer( "localhost", 3312 );
	$cl->SetConnectTimeout ( 1 );
	$cl->SetWeights ( array ( 100, 1 ) );
	$cl->SetMatchMode ( $mode );
	if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
	if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
	if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
	if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
	if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
	$cl->SetLimits ( 0, $limit );
	$cl->SetRankingMode ( $ranker );
	$cl->SetArrayResult ( true );
	$res = $cl->Query ( $q, $index );
	
	
	//print "Query '$q' retrieved $res[total] of $res[total_found] matches in $res[time] sec.\n";
	

	
	$ids = "0"; 
	for ($i=0; $i < count($res['matches']); $i++) { 
		$ids .= "," .$res['matches'][$i]['id'];
	}

	
	
	$sql = "SELECT v.*, s.title as show_title
			FROM videos v INNER JOIN shows s on v.show_id = s.show_id
			WHERE video_iid IN ($ids);";
	
						
	return DB::query($sql);			
	
	
}





?>