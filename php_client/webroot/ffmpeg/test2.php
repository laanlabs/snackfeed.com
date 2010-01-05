<?php

    echo 'This example shows you how to extract frames from a movie.<br />';
    
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
    foreach($files_to_process as $file)
    {
//         get the filename parts
        $filename = basename($file);
        $filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
        
//         set the input file
        $ok = $ffmpeg->setInputFile($file);
//         check the return value in-case of error
        if(!$ok)
        {
//             if there was an error then get it
            echo '<b>'.$ffmpeg->getLastError()."</b><br />\r\n";
            $ffmpeg->reset();
            continue;
        }
        
				//echo $ffmpeg->getFileInfo($file).duration_seconds;
				$movie = new ffmpeg_movie($file, false);
				$duration =  $movie->getDuration();
				
				
//         set the output dimensions
//         $ffmpeg->setVideoOutputDimensions(320, 240);
        
//         extract a thumbnail from two seconds into the videohttp://www.twiddla.com/images/symbols/symbol-star1.png
        $ffmpeg->extractFrame('00:00:02');
        /**
         * NOTE; you could also do it like so...
         * $ffmpeg->extractFrames('00:00:02', '00:00:02', 1);
         */
        
//         set the output details
        $ok = $ffmpeg->setOutput($thumbnail_output_dir, $filename_minus_ext.'-%d.jpg', TRUE);
//         check the return value in-case of error
        if(!$ok)
        {
//             if there was an error then get it
            echo '<b>eee'.$ffmpeg->getLastError()."</b><br />\r\n";
            $ffmpeg->reset();
            continue;
        }
/*
				$data = $ffmpeg->getFileInfo();
				
	echo '<pre>';
	print_r($data);
	echo '</pre>';
  */
      
//         execute the ffmpeg command
				
        $result = $ffmpeg->execute(false, true);
        
//         get the last command given
//         $command = $ffmpeg->getLastCommand();
//         echo $command."<br />\r\n";
        
//         check the return value in-case of error
        if(!$result)
        {
//             move the log file to the log directory as something has gone wrong
            $ffmpeg->moveLog($log_dir.$filename_minus_ext.'.log');
//             if there was an error then get it
            echo '<b>err'.$ffmpeg->getLastError()."</b><br />\r\n";
            $ffmpeg->reset();
            continue;
        }
        

        echo 'Frame grabbed... <b>'.$thumbnail_output_dir.array_shift($ffmpeg->getLastOutput()).'</b><br />'."\r\n";
    
//         reset
        $ffmpeg->reset();
        
    }