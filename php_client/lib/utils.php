<?php

function image_upload_jpg($server_root, $path, $name, $field_name = 'file' )
{
	
	$target_path = $server_root . $path;
	$target_file = $target_path . $name . ".jpg";
	$target_thumb = $path . $name . ".jpg";



	  if ($_FILES[$field_name]["error"] > 0)
	    {
	   // echo "Return Code: " . $_FILES[$field_name]["error"] . "<br />";
	    }
	  else
	    {
	    // echo "Upload: " . $_FILES[$field_name]["name"] . "<br />";
	    // echo "Type: " . $_FILES[$field_name]["type"] . "<br />";
	    // echo "Size: " . ($_FILES[$field_name]["size"] / 1024) . " Kb<br />";
	    // echo "Temp file: " . $_FILES[$field_name]["tmp_name"] . "<br />";

	    if (file_exists($target_file))
	      {

		  //delete file if exists
	      // echo $target_file . " already exists. ";
		  unlink($target_file);
	      }

	      move_uploaded_file($_FILES[$field_name]["tmp_name"], $target_file);
	       // echo "Stored in: " . $target_file;
		 
		  return $target_thumb;

	    }
	
}



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


function quote_csv($string) {
	$arr = explode(",", $string);
	$arr = array_map("single_quote", $arr);
	return implode(", ", $arr);
}

function single_quote($str) {
	return "'{$str}'";
}

function delete_keys($arr, $keys_to_delete)
{
	foreach ($keys_to_delete as $key) {
		unset($arr[$key]);
	}
	return $arr;
}

function array_to_xml($data) {
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0', 'UTF-8');
	$xml->startElement('root');

	function write(XMLWriter $xml, $data){
	    foreach($data as $key => $value){
	        if(is_array($value)){
							if (is_numeric($key)) {
								$key = "array_item";
							}
	            $xml->startElement($key);
	            write($xml, $value);
	            $xml->endElement();
	            continue;
	        }
									if (is_numeric($key)) {
										$key = "array_item";
									}
	        $xml->writeElement( $key, stripslashes($value) );
	    }
	}
	write($xml, $data);

	$xml->endElement();
	return $xml->outputMemory(true);
	
}

function render_data_as_xml($data, $exit = true) {
	render_xml(array_to_xml($data), $exit);
}

function render_xml($xml, $exit = true) {
	header("Content-type: text/xml");
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo $xml;
	if ($exit) {
		DB::close_and_exit();
	}
}





define("TIME_PERIODS_PLURAL_SINGULAR", "weeks:week,years:year,days:day,hours:hour, : ,minutes:minute,seconds:second");
DEFINE("TIME_LEFT_STRING_TPL", " #num# #period#");

/**
 * @param $time  time stamp
**/
function time_left($time)
{
    if (($now = time()) <= $time) return false;

    $timeRanges = array('years' => 365*60*60*24,/* 'weeks' => 60*60*24*7, */ 'days' => 60*60*24, 'hours' => 60*60, 'minutes' => 60, 'seconds' => 1);

    $secondsLeft = $now-$time;

    // prepare ranges
    $outRanges = array();
    foreach ($timeRanges as $period => $sec)
      if ($secondsLeft/$sec >= 1)
      {
        $outRanges[$period] =  floor($secondsLeft/$sec);
        $secondsLeft -= ($outRanges[$period] * $sec);
      }

    // playing with TIME_PERIODS_PLURAL_SINGULAR
    $periodsEx = explode(",", TIME_PERIODS_PLURAL_SINGULAR);
    $periodsAr = array();
    foreach ($periodsEx as $periods)
    {
      $ex  = explode(":", $periods);
      $periodsAr[$ex[0]] = array('plural' => $ex[0], 'singular' => $ex[1]);
    }

    // string out
    $outString = "";
    $outStringAr = array();
    foreach ($outRanges as $period => $num)
    {
      $per = $periodsAr[$period]['plural'];
      if ($num == 1)  $per = $periodsAr[$period]['singular'];

      $outString .= $outStringAr[$period] = str_replace(array("#num#", "#period#"), array($num, $per), TIME_LEFT_STRING_TPL);
    }

    return array('timeRanges' => $outRanges, 'leftStringAr' => $outStringAr, 'leftString' => $outString);
}


function get_pretty_date( $dater ) {
	
	$int_time = strtotime( $dater );
	return time_ago( $int_time , 1 );
	
}


//date_format(DateTime object, string format);

function time_ago ( $epoch, $max_phrases=null ) {
  $duration  = time() - $epoch;

  return seconds2human( $duration > 0 ? $duration : 0,
                        $max_phrases) . " ago";
}

function time_ago_verbose( $str_time ) {
	
	$epoch = strtotime( $str_time );
	
	
	$duration  = time() - $epoch;
	
	//--------------------------------------------------
  // Maths
  $sec = $epoch % 60;
  $epoch -= $sec;

  $minSeconds = $epoch % 3600;
  $epoch -= $minSeconds;
  $min = ($minSeconds / 60);

  $hourSeconds = $epoch % 86400;
  $epoch -= $hourSeconds;
  $hour = ($hourSeconds / 3600);

  $daySeconds = $epoch % 604800;
  $epoch -= $daySeconds;
  $day = ($daySeconds / 86400);

  $week = ($epoch / 604800);

  //--------------------------------------------------
  // Text

  $output = array();

	$output['weeks'] = $week;
	$output['days'] = $day;
	$output['seconds'] = $sec;
	$output['minutes'] = $min;
	$output['hours'] = $hour;
	
	return $output;
	
	
	
}

function seconds2human($epoch, $max_phrases=null ){
  // kindly adapted from Craig Francis at http://www.php.net/manual/en/function.time.php#74652

  //--------------------------------------------------
  // Maths
  $sec = $epoch % 60;
  $epoch -= $sec;

  $minSeconds = $epoch % 3600;
  $epoch -= $minSeconds;
  $min = ($minSeconds / 60);

  $hourSeconds = $epoch % 86400;
  $epoch -= $hourSeconds;
  $hour = ($hourSeconds / 3600);

  $daySeconds = $epoch % 604800;
  $epoch -= $daySeconds;
  $day = ($daySeconds / 86400);

  $week = ($epoch / 604800);

  //--------------------------------------------------
  // Text

  $output = array();
  if ($week > 0) {
    $output[] = $week . ' week' . ($week != 1 ? 's' : '');
  }
  if ($day > 0) {
    $output[] = $day . ' day' . ($day != 1 ? 's' : '');
  }
  if ($hour > 0) {
    $output[] = $hour . ' hour' . ($hour != 1 ? 's' : '');
  }
  if ($min > 0) {
    $output[] = $min . ' minute' . ($min != 1 ? 's' : '');
  }
  if ($sec > 0 || $output == '') {
    $output[] = $sec . ' second' . ($sec != 1 ? 's' : '');
  }

  //--------------------------------------------------
  // Grammar
  if( isset($max_phrases) )
    $output = array_slice($output, 0, $max_phrases);

  $return = join( ', ', $output);

  $return = preg_replace('/, ([^,]+)$/', ' and $1', $return);

  //--------------------------------------------------
  // Return the output

  return $return;

}


function doMail($to, $from, $subject, $message, $to_name = null, $from_name = null)
{
	
	$to_name = (!empty($to_name))? $to_name: $to;
	$from_name = (!empty($from_name))? $from_name: $from;


$message = preg_replace('/\s(\w+:\/\/)(\S+)/', ' <a href="\\1\\2" target="_blank">\\1\\2</a>', $message);

	$headers = "From: " . $from_name . "<" . $from . ">\n";
	$headers .= "Reply-To: " . $from_name ." <" . $from . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/html\n"; 
	//echo $to.$subject.$message.$headers;
	mail($to,$subject,$message,$headers);	
	

}


?>