<?php

   // echo 'This example shows you how to extract frames from a movie.<br />';
    
//     load the examples configuration
    require_once 'config.php';
    
//     require the library
    require_once 'ffmpeg.php';

///require_once 'adapters/adapters-videoto.php';

include "GIFEncoder.class.php";
    

//     please replace xxxxx with the full absolute path to the files and folders
//     also please make the $thumbnail_output_dir read and writeable by the webserver
    
//     temp directory
    $tmp_dir = FFMPEG_EXAMPLE_ABSOLUTE_BATH.'tmp/';
    
//    input movie files
    $files_to_process = array(
        FFMPEG_EXAMPLE_ABSOLUTE_BATH.'hel4.flv'
    );

//    output files dirname has to exist
    $thumbnail_output_dir = FFMPEG_EXAMPLE_ABSOLUTE_BATH.'thumbnails/';
    
//    log dir
    $log_dir = FFMPEG_EXAMPLE_ABSOLUTE_BATH.'logs/';
    
//     start ffmpeg class
    $ffmpeg = new ffmpeg( $tmp_dir );
    
//     set ffmpeg class to run silently
    $ffmpeg->on_error_die = FALSE;
    
//     loop through the files to process
//         get the filename parts


/*
$id="http://www.bigtimegals.com/mf/kr/01/01.mpg";
$sz=$size;
$savefile="tmp/test".time().".mpg";

$ch = curl_init ($id);
$fp = fopen ($savefile, "w");
curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_exec ($ch);
curl_close ($ch);
fclose ($fp);
*/





$file = "test1.mpg";//$savefile;

$filename = basename($file);
$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));

//set the input file
$ok = $ffmpeg->setInputFile($file);

$movie = new ffmpeg_movie($file, false);
$duration =  $movie->getDuration();
$num_frames = 170;

//$interval = floor( $duration / $num_frames );
$interval =  $duration / $num_frames;

echo "Duration: ".$duration." Interval: ".$interval;

for( $i=0; $i<$num_frames; $i++ ) {
	
		//$ffmpeg->extractFrame('00:00:0'.$i );
		$ffmpeg->extractFrame( $i*$interval );
		$ok = $ffmpeg->setOutput( $tmp_dir  , "_%d_frame".$i.".jpg", TRUE );
		//echo $ok;
		$result = $ffmpeg->execute( false , true );
		//echo $result;
}

$ffmpeg->reset();

$xx = 0;

if ( $dh = opendir ( "tmp/" ) ) {
    while ( false !== ( $dat = readdir ( $dh ) ) ) {
				if ( $dat != "." && $dat != ".." && ( strrpos($dat, '.jpg') > 0 )  ) {
					 //echo strrpos($dat, '.jpg')." - ";
						copy("tmp/".$dat , "frames/frame".$xx.".jpg" );
						$xx++;
					}
				}
    closedir ( $dh );
}

		echo "cool, done";
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> JSMP PROJECT </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
 </HEAD>

 <BODY>
	
	<style>
		body { padding:50px; }
		img { background-repeat: none;}
		#jsmp_player { width:400px; height:400px; border:#aaa 10px solid; background-position:center; background-color:#ddd }
		#jsmp_player .curtain { position:absolute; width:400px; height:400px; background:#000; opacity:0.7; color:#fff; font:14px 'Trebuchet MS',Arial;  text-align:center }
		#jsmp_player .curtain div { margin:180px 0 0 0; }
		#jsmp_player .console { position:absolute; z-index:11; margin:300px 0 0 50px; border:5px solid #bbb; width:300px; height:50px; background:#fff; opacity:0.9; filter:Alpha(Opacity=90); visibility:hidden }
		#jsmp_player .buttonset { float:left; width:78px; height:50px; background:url(buttonset.gif); }
		#jsmp_player .buttonset .start { float:left; margin-left:10px; width:30px; height:50px; cursor:pointer }
		#jsmp_player .buttonset .pause { float:left; margin-left:8px; width:20px; height:50px; cursor:pointer;  }
		#jsmp_player .stream { float:left; margin:20px 0 0 0; width:200px; height:10px; border:1px solid #ccc;  }
		#jsmp_player .stream div { width:0px; height:10px; background:#e5e5e5; font-size:1px; }
		#jsmp_player .stream div div { width:0px; height:10px; background:#ccc; font-size:1px; }
		#jsmp_player a { color:#ffff00; }
		#jsmp_player a:hover { text-decoration:none; }
	</style>

	<h1>JSMP / JS MEDIA PLAYER</h1>
	<div id='jsmp_player'>
		<div id='jsmp_curtainc' class='curtain'><div id='jsmp_curtain'></div></div><div id='jsmp_console' class='console'><div class='buttonset'><div id='jsmp_start' class='start'></div><div id='jsmp_pause' class='pause'></div></div><div class='stream'><div id='jsmp_stream'><div id='jsmp_cursor'></div></div></div></div>
	</div>

 <script type='text/javascript' src='streamer/jsmp.js'></script>

 </BODY>
</HTML>






