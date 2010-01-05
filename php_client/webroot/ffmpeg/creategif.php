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
    $ffmpeg = new ffmpeg($tmp_dir);
    
//     set ffmpeg class to run silently
    $ffmpeg->on_error_die = FALSE;
    
//     loop through the files to process
//         get the filename parts



$id="http://www..mpg";
$sz=$size;
$savefile="tmp/test".time().".mpg";

$ch = curl_init ($id);
$fp = fopen ($savefile, "w");
curl_setopt ($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_HEADER, 0);
curl_exec ($ch);
curl_close ($ch);
fclose ($fp);







$file = $savefile;

$filename = basename($file);
$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));

//set the input file
$ok = $ffmpeg->setInputFile($file);

$movie = new ffmpeg_movie($file, false);
$duration =  $movie->getDuration();

$interval = floor( $duration / 8 );
echo "Duration: ".$duration." Interval: ".$interval;

for( $i=0; $i<8; $i++ ) {
	
		//$ffmpeg->extractFrame('00:00:0'.$i );
		$ffmpeg->extractFrame( $i*$interval );
		$ok = $ffmpeg->setOutput($thumbnail_output_dir, 'frame-%d.jpg', TRUE);
		$result = $ffmpeg->execute(false, true);
}

$ffmpeg->reset();


		$z = 0;
		$sz = 150;
		
		if ( $dh = opendir ( "tmp/" ) ) {
		    while ( false !== ( $dat = readdir ( $dh ) ) ) {
		        
					if ( $dat != "." && $dat != ".." ) {
							echo $z;
							$z++;
							
							$im = @imagecreatefromjpeg ("tmp/".$dat);
							
							if ($im) {
								$im_width=imageSX($im);
								$im_height=imageSY($im);
							
								// work out new sizes
								if($im_width >= $im_height)
								{
								  $factor = $sz/$im_width;
								  $new_width = $sz;
								  $new_height = $im_height * $factor;
								}
								else
								{
								  $factor = $sz/$im_height;
								  $new_height = $sz;
								  $new_width = $im_width * $factor;
								}
							
							
								// resize
								$new_im=ImageCreate($new_width,$new_height);
								ImageCopyResized($new_im,$im,0,0,0,0,
								                 $new_width,$new_height,$im_width,$im_height);
							
							
								imagegif($new_im,"frames/frame".$z.".gif");
							}
		            //$frames [ ] = "tmp/$dat";
		            //$framed [ ] = 5;
		        }
		    }
		    closedir ( $dh );
		}
		

		
		if ( $dh = opendir ( "frames/" ) ) {
		    while ( false !== ( $dat = readdir ( $dh ) ) ) {
		        if ( $dat != "." && $dat != ".." ) {
		            $frames [ ] = "frames/$dat";
		            $framed [ ] = 50;
		        }
		    }
		    closedir ( $dh );
		}

		
		//$im = @imagecreatefrompng ($savefile);
		//imagegif($im,"poop.gif");
		
		$gif = new GIFEncoder    (
		                            $frames,
		                            $framed,
		                            0,
		                            2,
		                            0, 0, 0,
		                            "url"
		        );
	
		//$gif->GetAnimation ( );
		FWrite ( FOpen ( "myanimation.gif", "wb" ), $gif->GetAnimation ( ) );
		
		
		if ( $dh = opendir ( "frames/" ) ) {
		    while ( false !== ( $dat = readdir ( $dh ) ) ) {
		        if ( $dat != "." && $dat != ".." ) {
		            unlink("frames/".$dat);
		        }
		    }
		    closedir ( $dh );
		}
		
		if ( $dh = opendir ( "tmp/" ) ) {
		    while ( false !== ( $dat = readdir ( $dh ) ) ) {
		        if ( $dat != "." && $dat != ".." ) {
		            unlink("tmp/".$dat);
		        }
		    }
		    closedir ( $dh );
		}
		
		
		echo "cool"
?>





