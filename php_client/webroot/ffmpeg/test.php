<?


$filename = "hel4.flv";


$movie = new ffmpeg_movie($filename, false);
$_duration =  $movie->getDuration();
$_framerate = $movie->getFrameRate();
$_height = $movie->getFrameHeight();
$_width = $movie->getFrameWidth();
$_bitrate = $movie->getBitRate();
$_filesize = filesize($filename);


$_frame1 = $movie->getFrame(20);
$_frame2 = $movie->getFrame(50);
$_frame3 = $movie->getFrame(70);
$_frame4 = $movie->getFrame(90);


echo "DURATION: " . $_duration;
echo "<br/>";
echo "height: " . $_height;
echo "<br/>";
echo "FR: " . $_framerate;
echo "size: " . $_filesize;





$gif = new ffmpeg_animated_gif("test.gif", $_width/4, $_height/4, 1, 0 );

$gif->addFrame( $_frame1 );
$gif->addFrame( $_frame2 );
$gif->addFrame( $_frame3 );
$gif->addFrame( $_frame4 );

echo "<img src='test.gif'/>";

/*
$output = shell_exec('ffmpeg -i Bio.flv -ss 13 -t 1.0 /tmp/test%d.jpg && convert -delay 20 -loop 0 /tmp/test*.gif /tmp/animated.gif
');
echo "<pre>$output</pre>";
*/

die();

?>
