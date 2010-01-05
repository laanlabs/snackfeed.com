<?php


// 	define the paths to the required binaries
	define('FFMPEG_BINARY', '/usr/local/bin/ffmpeg');
 	define('FFMPEG_FLVTOOLS_BINARY', '/usr/bin/flvtool2');
 	define('FFMPEG_MENCODER_BINARY', '/usr/local/bin/mencoder'); // only required for video joining
// 	define('FFMPEG_WATERMARK_VHOOK', '/usr/local/lib/vhook/watermark.dylib'); // only required for video wartermarking

//	define('FFMPEG_BINARY', 'xxxx');
	define('FFMPEG_FLVTOOLS_BINARY', 'xxxx');
	define('FFMPEG_MENCODER_BINARY', 'xxxx');
	define('FFMPEG_WATERMARK_VHOOK', 'xxxx');
	
// 	define the absolute path of the example folder so that the examples only have to be edited once
// 	REMEMBER the trailing slash
	define('FFMPEG_EXAMPLE_ABSOLUTE_BATH', '/var/www/smoothtube-public/v1/webroot/ffmpeg/');


	if(FFMPEG_BINARY == 'xxxx' || FFMPEG_FLVTOOLS_BINARY == 'xxxx' || FFMPEG_EXAMPLE_ABSOLUTE_BATH == 'xxxx' || FFMPEG_MENCODER_BINARY == 'xxxx')
	{
		die('Please open ffmpeg.example-config.php to set your servers values.');
//<-	exits 		
	}


?>