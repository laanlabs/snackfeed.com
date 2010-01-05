<?php


/*
$be_var = $_REQUEST;
foreach ( $be_var as $key => $value ) {
	$be_var = $be_var."&".$key."=".$value;
}

$file_contents = "FILE CONTENTS\r\n";
$file_contents .= str_replace( "Array&", "", $be_var ); // fruit=banana&color=yellow

$vXML = "post_data.txt";
$vXML = fopen($vXML, 'w') or die("can't open file");
fwrite($vXML, $file_contents);
fclose($vXML);
echo "file created". "<br>";
*/

/*
if ( $_POST['gif'] ) {
	
	$rndname = "thumbnails/".rand().'.gif';
	
	$fp = fopen( $rndname , 'wb' );
	fwrite( $fp, base64_decode($_POST['gif']) );
	fclose( $fp );
	
	$_fullpath = "http://v1.smoothtube.com" . "/ffmpeg/" . $rndname;
	
	echo $_fullpath;
	
	
} else {
	
	echo "NO GIF DATA";
}

*/


if ($_FILES["file"]["error"] > 0)
  {
  
		
		echo "Error";



  }
else
  {
  	$uploaddir = 'thumbnails/';
		//$uploadfile = $uploaddir . basename( $_FILES['_file']['name'] );
		$token = md5(uniqid());
		$uploadfile = $uploaddir .  $token.'.png'; ;
		
		
		if ( move_uploaded_file( $_FILES['_file']['tmp_name'] , $uploadfile )) {
			
		    echo "http://www.snackfeed.com/plugin/".$uploadfile;
		
		} else {
			
		    echo "Possible file upload attack!\n";
		
		}
		
		
		//echo 'Here is some more debugging info:';
		//print_r($_FILES);
		//print "</pre>";
		
  }





?>




