<?php

	/**
	 * @author Oliver Lillie (aka buggedcom) <publicmail@buggedcom.co.uk>
	 *
	 * @license BSD
	 * @copyright Copyright (c) 2007 Oliver Lillie <http://www.buggedcom.co.uk>
	 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
	 * files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
	 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
	 * is furnished to do so, subject to the following conditions:  The above copyright notice and this permission notice shall be
	 * included in all copies or substantial portions of the Software.
	 *
	 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
	 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
	 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
	 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	 *
	 * @name ffmpeg
	 * @version 0.1.0
	 * @changelog SEE CHANGELOG
	 * @abstract This class can be used in conjunction with several server binary libraries to manipulate video and audio
	 * through PHP. It is not intended to solve any particular problems, however you may find it useful. This php class
	 * is in no way associated with the actual FFmpeg releases. Any mistakes contained in this php class are mine and mine
	 * alone.
	 *
	 * Please Note: There are several prerequisites that are required before this class can be used as an aid to manipulate
	 * video and audio. You must at the very least have FFMPEG compiled on your server. If you wish to use this class for FLV
	 * manipulation you must compile FFMPEG with LAME and Ruby's FLVTOOL2. I cannot answer questions regarding the install of
	 * the server binaries needed by this class. I had too learn the hard way and it isn't easy, however it is a good learning
	 * experience. For those of you who do need help read the install.txt file supplied along side this class. It wasn't written
	 * by me however I found it useful when installing ffmpeg for the first time. The original source for the install.txt file
	 * is located http://www.luar.com.hk/blog/?p=669 and the author is Lunar.
	 *
	 * @see install.txt
	 *
	 * @uses ffmpeg http://ffmpeg.sourceforge.net/
	 * @uses lame http://lame.sourceforge.net/
	 * @uses flvtool2 http://www.inlet-media.de/flvtool2 (and ruby http://www.ruby-lang.org/en/)
	 *
	 * @config ffmpeg.example-config.php Please edit this files in order for the examples to work.
	 * @example ffmpeg.example1.php Converts video to Flash Video (ie FLV).
	 * @example ffmpeg.example2.php Screen grabs video frames.
	 * @example ffmpeg.example3.php Compile a movie from multiple jpegs
	 * @example ffmpeg.example4.php Watermark a video.
	 * @example ffmpeg.example5.php Access media metadata without using the ffmpeg-php library.
	 * @example ffmpeg.example6.php Extract audio from video.
	 * @example ffmpeg.example7.php Join multiple videos together.
	 * @example ffmpeg.example8.php Easy video conversion to common formats using the adapters.
	 *
	 * @todo Functions to add
	 * 			- exportSpecificFrames
	 * 				Will add functionality to export specific frames from one execute call.
	 * 			- exportFrameWithWatermark
	 * 			- exportFramesWithWatermark
	 * 			- exportSepcificFramesWithWatermark
	 * 				Will add funcitonality to export frames with a watermark.
	 * Also I have many more plans so there is much more to come. If anybody has any suggestions please feel free to email me.
	 */

	/**
	 * Set the ffmpeg binary path
	 */
	if(!defined('FFMPEG_BINARY'))
	{
		define('FFMPEG_BINARY', '/usr/local/bin/ffmpeg');
	}
	/**
	 * Set the flvtool2 binary path
	 */
	if(!defined('FFMPEG_FLVTOOLS_BINARY'))
	{
		define('FFMPEG_FLVTOOLS_BINARY', '/usr/bin/flvtool2');
	}
	/**
	 * Set the watermark vhook path
	 */
	if(!defined('FFMPEG_WATERMARK_VHOOK'))
	{
		define('FFMPEG_WATERMARK_VHOOK', '/usr/local/lib/vhook/watermark.so');
	}
	/**
	 * Set the watermark vhook path
	 */
	if(!defined('FFMPEG_MENCODER_BINARY'))
	{
		define('FFMPEG_MENCODER_BINARY', '/usr/local/bin/mencoder');
	}

	class ffmpeg
	{
		/**
		 * Error strings
		 */
		private $_messages = array(
			
			'generic_temp_404' 								=> 'The temporary directory does not exist.',
			'generic_temp_writable' 						=> 'The temporary directory is not write-able by the web server.',
			
			'getFileInfo_no_input' 							=> 'Input file does not exist so no information can be retrieved.',
			'setInputFile_file_existence' 					=> 'Input file "#file" does not exist',
			'extractAudio_valid_format' 					=> 'Value "#format" set from $ffmpeg->extractAudio, is not a valid audio format. Valid values ffmpeg self::FORMAT_AAC, ffmpeg::FORMAT_AIFF, ffmpeg::FORMAT_MP2, ffmpeg::FORMAT_MP3, ffmpeg::FORMAT_MP4, ffmpeg::FORMAT_MPEG4, ffmpeg::FORMAT_M4A or ffmpeg::FORMAT_WAV. If you wish to specifically try to set another format you should use the advanced function $ffmpeg->addCommand. Set $command to "-f" and $argument to your required value.',
			'setFormat_valid_format' 						=> 'Value "#format" set from $ffmpeg->setFormat, is not a valid format. Valid values are ffmpeg::FORMAT_3GP2, ffmpeg::FORMAT_3GP, ffmpeg::FORMAT_AAC, ffmpeg::FORMAT_AIFF, ffmpeg::FORMAT_AMR, ffmpeg::FORMAT_ASF, ffmpeg::FORMAT_AVI, ffmpeg::FORMAT_FLV, ffmpeg::FORMAT_GIF, ffmpeg::FORMAT_MJ2, ffmpeg::FORMAT_MP2, ffmpeg::FORMAT_MP3, ffmpeg::FORMAT_MP4, ffmpeg::FORMAT_MPEG4, ffmpeg::FORMAT_M4A, ffmpeg::FORMAT_MPEG, ffmpeg::FORMAT_MPEG1, ffmpeg::FORMAT_MPEG2, ffmpeg::FORMAT_MPEGVIDEO, ffmpeg::FORMAT_PSP, ffmpeg::FORMAT_RM, ffmpeg::FORMAT_SWF, ffmpeg::FORMAT_VOB, ffmpeg::FORMAT_WAV, ffmpeg::FORMAT_JPG. If you wish to specifically try to set another format you should use the advanced function $ffmpeg->addCommand. Set $command to "-f" and $argument to your required value.',
			'setAudioSampleFrequency_valid_frequency' 		=> 'Value "#frequency" set from $ffmpeg->setAudioSampleFrequency, is not a valid integer. Valid values are 11025, 22050, 44100. If you wish to specifically try to set another frequency you should use the advanced function $ffmpeg->addCommand. Set $command to "-ar" and $argument to your required value.',
			'setAudioFormat_valid_format' 					=> 'Value "#format" set from $ffmpeg->setAudioFormat, is not a valid format. Valid values are ffmpeg::FORMAT_AAC, ffmpeg::FORMAT_AIFF, ffmpeg::FORMAT_AMR, ffmpeg::FORMAT_ASF, ffmpeg::FORMAT_MP2, ffmpeg::FORMAT_MP3, ffmpeg::FORMAT_MP4, ffmpeg::FORMAT_MPEG2, ffmpeg::FORMAT_RM, ffmpeg::FORMAT_WAV. If you wish to specifically try to set another format you should use the advanced function $ffmpeg->addCommand. Set $command to "-acodec" and $argument to your required value.',
			'setVideoFormat_valid_format' 					=> 'Value "#format" set from $ffmpeg->setAudioFormat, is not a valid format. Valid values are ffmpeg::FORMAT_3GP2, ffmpeg::FORMAT_3GP, ffmpeg::FORMAT_AVI, ffmpeg::FORMAT_FLV, ffmpeg::FORMAT_GIF, ffmpeg::FORMAT_MJ2, ffmpeg::FORMAT_MP4, ffmpeg::FORMAT_MPEG4, ffmpeg::FORMAT_M4A, ffmpeg::FORMAT_MPEG, ffmpeg::FORMAT_MPEG1, ffmpeg::FORMAT_MPEG2, ffmpeg::FORMAT_MPEGVIDEO. If you wish to specifically try to set another format you should use the advanced function $ffmpeg->addCommand. Set $command to "-vcodec" and $argument to your required value.',
			'setAudioBitRate_valid_bitrate' 				=> 'Value "#bitrate" set from $ffmpeg->setAudioBitRate, is not a valid integer. Valid values are 16, 32, 64, 128. If you wish to specifically try to set another bitrate you should use the advanced function $ffmpeg->addCommand. Set $command to "-ab" and $argument to your required value.',
			'prepareImagesForConversionToVideo_one_img' 	=> 'When compiling a movie from a series of images, you must include at least one image.',
			'prepareImagesForConversionToVideo_img_404' 	=> '"#img" does not exist.',
			'prepareImagesForConversionToVideo_img_copy' 	=> '"#img" can not be copied to "#tmpfile"',
			'setVideoOutputDimensions_valid_format' 		=> 'Value "#format" set from $ffmpeg->setVideoOutputDimensions, is not a valid preset dimension. Valid values are ffmpeg::SIZE_SQCIF, ffmpeg::SIZE_SAS, ffmpeg::SIZE_QCIF, ffmpeg::SIZE_CIF, ffmpeg::SIZE_4CIF, ffmpeg::SIZE_QQVGA, ffmpeg::SIZE_QVGA, ffmpeg::SIZE_VGA, ffmpeg::SIZE_SVGA, ffmpeg::SIZE_XGA, ffmpeg::SIZE_UXGA, ffmpeg::SIZE_QXGA, ffmpeg::SIZE_SXGA, ffmpeg::SIZE_QSXGA, ffmpeg::SIZE_HSXGA, ffmpeg::SIZE_WVGA, ffmpeg::SIZE_WXGA, ffmpeg::SIZE_WSXGA, ffmpeg::SIZE_WUXGA, ffmpeg::SIZE_WOXGA, ffmpeg::SIZE_WQSXGA, ffmpeg::SIZE_WQUXGA, ffmpeg::SIZE_WHSXGA, ffmpeg::SIZE_WHUXGA, ffmpeg::SIZE_CGA, ffmpeg::SIZE_EGA, ffmpeg::SIZE_HD480, ffmpeg::SIZE_HD720, ffmpeg::SIZE_HD1080. You can also manually set the width and height.',
			'setVideoOutputDimensions_sas_dim' 				=> 'It was not possible to determine the input video dimensions so it was not possible to continue. If you wish to override this error please change the call to setVideoOutputDimensions and add a true argument to the arguments list... setVideoOutputDimensions(ffmpeg::SIZE_SAS, true);',
			'setVideoAspectRatio_valid_ratio' 				=> 'Value "#ratio" set from $ffmpeg->setVideoOutputDimensions, is not a valid preset dimension. Valid values are ffmpeg::RATIO_STANDARD, ffmpeg::RATIO_WIDE, ffmpeg::RATIO_CINEMATIC. If you wish to specifically try to set another video aspect ratio you should use the advanced function $ffmpeg->addCommand. Set $command to "-aspect" and $argument to your required value.',
			'addWatermark_img_404' 							=> 'Watermark file "#watermark" does not exist.',
			'addVideo_file_404' 							=> 'File "#file" does not exist.',
			'setOutput_output_dir_404' 						=> 'Output directory "#dir" does not exist!',
			'setOutput_output_dir_writable' 				=> 'Output directory "#dir" is not writable!',
			'setOutput_%d' 									=> 'The output of this command will be images yet you have not included the "%d" in the $output_name.',
			'execute_input_404' 							=> 'Execute error. Input file missing.',
			'execute_output_not_set' 						=> 'Execute error. Output not set.',
			'execute_overwrite_process' 					=> 'Execute error. A file exists in the temp directory and is of the same name as this process file. It will conflict with this conversion. Conversion stopped.',
			'execute_overwrite_fail' 						=> 'Execute error. Output file exists. Process halted. If you wish to automatically overwrite files set the third argument in "ffmpeg::setOutput();" to "ffmpeg::OVERWRITE_EXISTING".',
			'execute_partial_error' 						=> 'Execute error. Output for file "#input" encountered a partial error. Files were generated, however one or more of them were empty.',
			'execute_image_error' 							=> 'Execute error. Output for file "#input" was not found. No images were generated.',
			'execute_output_404' 							=> 'Execute error. Output for file "#input" was not found. Please check server write permissions and/or available codecs compiled with FFmpeg. You can check the encode decode availability by inspecting the output array from ffmpeg::getFFmpegInfo().',
			'execute_output_empty' 							=> 'Execute error. Output for file "#input" was found, but the file contained no data. Please check the available codecs compiled with FFmpeg can support this type of conversion. You can check the encode decode availability by inspecting the output array from ffmpeg::getFFmpegInfo().',
			'execute_image_file_exists'						=> 'Execute error. There is a file name conflict. The file "#file" already exists in the filesystem. If you wish to automatically overwrite files set the third argument in "ffmpeg::setOutput();" to "ffmpeg::OVERWRITE_EXISTING".',
			'execute_result_ok_but_unwritable'				=> 'Process Partially Completed. The process successfully completed however it was not possible to output to "#output". The output was left in the temp directory "#process" for a manual file movement.',
			'execute_result_ok'								=> 'Process Completed. The process successfully completed. Output was generated to "#output".',
			
			'ffmpeg_log_ffmpeg_result'						=> 'RESULT',
			'ffmpeg_log_ffmpeg_command'						=> 'COMMAND',
			'ffmpeg_log_ffmpeg_gunk'						=> 'FFMPEG OUTPUT',
			'ffmpeg_log_separator'							=> '-------------------------------'
			
		);
		
		/**
		 * Process Results from ffmpeg::execute
		 */
// 		any return value with this means everything is ok
		const RESULT_OK 				= true;
// 		any return value with this means the file has been processed/converted ok however it was 
// 		not able to be written to the output address. If this occurs you will need to move the
// 		processed file manually from the temp location
		const RESULT_OK_BUT_UNWRITABLE 	= -1;
		
		/**
		 * Overwrite constants used in setOutput
		 */
		const OVERWRITE_FAIL			= 'fail';
		const OVERWRITE_PRESERVE		= 'preserve';
		const OVERWRITE_EXISTING		= 'existing';
		const OVERWRITE_UNIQUE			= 'unique';
		
		/**
		 * Formats supported
		 * 3g2             3gp2 format
		 * 3gp             3gp format
		 * aac             ADTS AAC
		 * aiff            Audio IFF
		 * amr             3gpp amr file format
		 * asf             asf format
		 * avi             avi format
		 * flv             flv format
		 * gif             GIF Animation
		 * mov             mov format
		 * mov,mp4,m4a,3gp,3g2,mj2 QuickTime/MPEG4/Motion JPEG 2000 format
		 * mp2             MPEG audio layer 2
		 * mp3             MPEG audio layer 3
		 * mp4             mp4 format
		 * mpeg            MPEG1 System format
		 * mpeg1video      MPEG video
		 * mpeg2video      MPEG2 video
		 * mpegvideo       MPEG video
		 * psp             psp mp4 format
		 * rm              rm format
		 * swf             Flash format
		 * vob             MPEG2 PS format (VOB)
		 * wav             wav format
		 * jpeg            mjpeg format
		 * yuv4mpegpipe    yuv4mpegpipe format
		 */
		const FORMAT_3GP2 			= '3g2';
		const FORMAT_3GP 			= '3gp';
		const FORMAT_AAC			= 'aac';
		const FORMAT_AIFF 			= 'aiff';
		const FORMAT_AMR 			= 'amr';
		const FORMAT_ASF 			= 'asf';
		const FORMAT_AVI			= 'avi';
		const FORMAT_FLV 			= 'flv';
		const FORMAT_GIF 			= 'gif';
		const FORMAT_MJ2 			= 'mj2';
		const FORMAT_MP2 			= 'mp2';
		const FORMAT_MP3 			= 'mp3';
		const FORMAT_MP4 			= 'mp4';
		const FORMAT_MPEG4 			= 'mpeg4';
		const FORMAT_M4A 			= 'm4a';
		const FORMAT_MPEG 			= 'mpeg';
		const FORMAT_MPEG1 			= 'mpeg1video';
		const FORMAT_MPEG2 			= 'mpeg2video';
		const FORMAT_MPEGVIDEO 		= 'mpegvideo';
		const FORMAT_PSP 			= 'psp';
		const FORMAT_RM 			= 'rm';
		const FORMAT_SWF 			= 'swf';
		const FORMAT_VOB 			= 'vob';
		const FORMAT_WAV 			= 'wav';
		const FORMAT_JPG 			= 'mjpeg';
		const FORMAT_Y4MP 			= 'yuv4mpegpipe';
		
		/**
		 * Size Presets
		 */
		const SIZE_SAS	 			= 'SameAsSource';
		const SIZE_SQCIF 			= '128x96';
		const SIZE_QCIF 			= '176x144';
		const SIZE_CIF 				= '352x288';
		const SIZE_4CIF 			= '704x576';
		const SIZE_QQVGA 			= '160x120';
		const SIZE_QVGA 			= '320x240';
		const SIZE_VGA 				= '640x480';
		const SIZE_SVGA 			= '800x600';
		const SIZE_XGA 				= '1024x768';
		const SIZE_UXGA 			= '1600x1200';
		const SIZE_QXGA 			= '2048x1536';
		const SIZE_SXGA 			= '1280x1024';
		const SIZE_QSXGA 			= '2560x2048';
		const SIZE_HSXGA 			= '5120x4096';
		const SIZE_WVGA 			= '852x480';
		const SIZE_WXGA 			= '1366x768';
		const SIZE_WSXGA 			= '1600x1024';
		const SIZE_WUXGA 			= '1920x1200';
		const SIZE_WOXGA 			= '2560x1600';
		const SIZE_WQSXGA 			= '3200x2048';
		const SIZE_WQUXGA 			= '3840x2400';
		const SIZE_WHSXGA 			= '6400x4096';
		const SIZE_WHUXGA 			= '7680x4800';
		const SIZE_CGA 				= '320x200';
		const SIZE_EGA				= '640x350';
		const SIZE_HD480 			= '852x480';
		const SIZE_HD720 			= '1280x720';
		const SIZE_HD1080			= '1920x1080';
		
		/**
		 * Ratio Presets
		 */
		const RATIO_STANDARD		= '4:3';
		const RATIO_WIDE			= '16:9';
		const RATIO_CINEMATIC		= '1.85';
		
		private $version			= '0.1.0';

		/**
		 * A public var that is to the information available about
		 * the current ffmpeg compiled binary.
		 * @var mixed
		 * @access public
		 */
		public static $ffmpeg_info		= false;

		/**
		 * Private var that detects if the $ffmpeg->setFormatToFLV function has been used as an additional exec call to flvtool2 is needed
		 * @var boolean
		 * @access private
		 */
		private $_flv_conversion		= false;

		/**
		 * Determines what happens when an error occurs
		 * @var boolean If true then the script will die, if not false is return by the error
		 * @access public
		 */
		public $on_error_die			= false;

		/**
		 * Holds the log file name
		 * @var string
		 * @access private
		 */
		private $_log_file				= null;

		/**
		 * Determines if when outputting image frames if the outputted files should have the %d number
		 * replaced with the frames timecode.
		 * @var boolean If true then the files will be renamed.
		 * @access public
		 */
		public $image_output_timecode 	= false;

		/**
		 * Holds the timecode separator for when using $image_output_timecode = true
		 * Not all systems allow ':' in filenames.
		 * @var string
		 * @access public
		 */
		public $timecode_seperator_output = '-';

		/**
		 * Holds the starting time code when outputting image frames.
		 * @var string The timecode hh(n):mm:ss:ff
		 * @access private
		 */
		private $_image_output_timecode_start = '00:00:00:00';

		/**
		 * Holds the fps of image extracts
		 * @var integer
		 * @access private
		 */
		private $_image_output_timecode_fps = 1;

		/**
		 * Holds the current execute commands that will need to be combined
		 * @var array
		 * @access private
		 */
		private $_commands 			= array();

		/**
		 * Holds the commands executed
		 * @var array
		 * @access private
		 */
		private $_processed 		= array();

		/**
		 * Holds the file references to those that have been processed
		 * @var array
		 * @access private
		 */
		private $_files	 			= array();

		/**
		 * Holds the errors encountered
		 * @access private
		 * @var array
		 */
		private $_errors 			= array();

		/**
		 * Holds the input file / input file sequence
		 * @access private
		 * @var string
		 */
		private $_input_file 		= null;

		/**
		 * Holds the output file / output file sequence
		 * @access private
		 * @var string
		 */
		private $_output_address 	= null;

		/**
		 * Holds the process file / process file sequence
		 * @access private
		 * @var string
		 */
		private $_process_address 	= null;

		/**
		 * Temporary filename prefix
		 * @access private
		 * @var string
		 */
		private $_tmp_file_prefix	= 'tmp_';

		/**
		 * Holds the temporary directory name
		 * @access private
		 * @var string
		 */
		private $_tmp_directory 	= null;

		/**
		 * Holds the directory paths that need to be removed by the ___destruct function
		 * @access private
		 * @var array
		 */
		private $_unlink_dirs		= array();

		/**
		 * Holds the file paths that need to be deleted by the ___destruct function
		 * @access private
		 * @var array
		 */
		private $_unlink_files		= array();

		/**
		 * Holds the timer start micro-float.
		 * @access private
		 * @var integer
		 */
		private $_timer_start		= 0;
		
		/**
		 * Holds the times taken to process each file.
		 * @access private
		 * @var array
		 */
		private $_timers			= array();

		/**
		 * Holds the times taken to process each file.
		 * @access private
		 * @var constant
		 */
		private $_overwrite_mode	= null;

		/**
		 * Constructs the class and sets the temporary directory.
		 *
		 * @access private
		 * @param string $tmp_directory A full absolute path to you temporary directory
		 */
		function __construct($tmp_directory='/tmp/')
		{
			$this->_tmp_directory = $tmp_directory;
		}
		
		public static function microtimeFloat()
		{
		    list($usec, $sec) = explode(" ", microtime());
		    return ((float) $usec + (float) $sec);
		}
		

		/**
		 * Resets the class
		 *
		 * @access public
		 * @param boolean $keep_input_file Determines whether or not to reset the input file currently set.
		 */
		public function reset($keep_input_file=false)
		{
			if($keep_input_file === false)
			{
				$this->_input_file = null;
			}
			$this->_flv_conversion = false;
			$this->_output_address = null;
			$this->_process_address = null;
			$this->_log_file = null;
			$this->_commands = array();
			$this->_timer_start = 0;
			$this->__destruct();
		}

		/**
		 * Returns information about the specified file without having to use ffmpeg-php
		 * as it consults the ffmpeg binary directly. This idea for this function has been borrowed from
		 * a French ffmpeg class located: http://www.phpcs.com/codesource.aspx?ID=45279
		 * 
		 * @access public
		 * @todo Change the search from string explode to a regex based search
		 * @author Yaug - Manuel Esteban yaug@caramail.com
		 * @param string $file The absolute path of the file that is required to be manipulated.
		 * @return mixed false on error encountered, true otherwise
		 **/
		public function getFFmpegInfo()
		{
			if(ffmpeg::$ffmpeg_info !== false)
			{
				return ffmpeg::$ffmpeg_info;
			}
			$format = '';
			$info_file = $this->_tmp_directory.$this->unique('ffinfo').'.info';
// 			execute the ffmpeg lookup
			exec(FFMPEG_BINARY.' -formats &> '.$info_file);
			
			$data = false;
// 			try to open the file
			$handle = fopen($info_file, 'r');
			if($handle)
			{
				$data = array();
				$buffer = '';
// 				loop through the lines of data and collect the buffer
			    while (!feof($handle))
				{
			        $buffer .= fgets($handle, 4096);
				}
// 				die($buffer);
				$data['compiler'] = array();
				$look_ups = array('configuration'=>'configuration: ', 'formats'=>'File formats:', 'codecs'=>'Codecs:', 'filters'=>'Bitstream filters:', 'protocols'=>'Supported file protocols:', 'abbreviations'=>'Frame size, frame rate abbreviations:', 'Note:');
				$total_lookups = count($look_ups);
				$pregs = array();
				$indexs = array();
				foreach($look_ups as $key=>$reg)
				{
					if(strpos($buffer, $reg) !== false)
					{
						$index = array_push($pregs, $reg);
						$indexs[$key] = $index;
					}
				}
				preg_match('/'.implode('(.*)', $pregs).'/s', $buffer, $matches);
				$configuration = trim($matches[$indexs['configuration']]);
// 				grab the ffmpeg configuration flags
				preg_match_all('/--[a-zA-Z0-9\-]+/', $configuration, $config_flags);
				$data['compiler']['configuration'] = $config_flags[0];
// 				grab the versions
				$data['compiler']['versions'] = array();
				preg_match_all('/([a-zA-Z0-9\-]+) version: ([0-9\.]+)/', $configuration, $versions);
				for($i=0, $a=count($versions[0]); $i<$a; $i++)
				{
					$data['compiler']['versions'][strtolower(trim($versions[1][$i]))] = $versions[2][$i];
				}
// 				grab the ffmpeg compile info
				preg_match('/built on (.*), gcc: (.*)/', $configuration, $conf);
				if(count($conf) > 0)
				{
					$data['compiler']['gcc'] = $conf[2];
					$data['compiler']['build_date'] = $conf[1];
					$data['compiler']['build_date_timestamp'] = strtotime($conf[1]);
				}
// 				grab the file formats available to ffmpeg
				preg_match_all('/ (DE|D|E) (.*) {1,} (.*)/', trim($matches[$indexs['formats']]), $formats);
				$data['formats'] = array();
// 				loop and clean
				for($i=0, $a=count($formats[0]); $i<$a; $i++)
				{
					$data['formats'][strtolower(trim($formats[2][$i]))] = array(
						'encode' 	=> $formats[1][$i] == 'DE' || $formats[1][$i] == 'E',
						'decode' 	=> $formats[1][$i] == 'DE' || $formats[1][$i] == 'D',
						'fullname'	=> $formats[3][$i]
					);
				}
// 				grab the bitstream filters available to ffmpeg
				$filters = trim($matches[$indexs['filters']]);
				$data['filters'] = empty($filters) ? array() : explode(' ', $filters);
// 				grab the file prototcols available to ffmpeg
				$protocols = trim($matches[$indexs['protocols']]);
				$data['protocols'] = empty($protocols) ? array() : explode(' ', str_replace(':', '', $protocols));
// 				grab the abbreviations available to ffmpeg
				$abbreviations = trim($matches[$indexs['abbreviations']]);
				$data['abbreviations'] = empty($abbreviations) ? array() : explode(' ', $abbreviations);
				ffmpeg::$ffmpeg_info = $data;
			}
			fclose($handle);
			if(is_file($info_file))
			{
//	 			if the info file exists remove it
				unlink($info_file);
			}
			return $data;
			
		}
		
		/**
		 * Returns information about the specified file without having to use ffmpeg-php
		 * as it consults the ffmpeg binary directly. This idea for this function has been borrowed from
		 * a French ffmpeg class located: http://www.phpcs.com/codesource.aspx?ID=45279
		 * 
		 * @access public
		 * @todo Change the search from string explode to a regex based search
		 * @author Yaug - Manuel Esteban yaug@caramail.com
		 * @param string $file The absolute path of the file that is required to be manipulated.
		 * @return mixed false on error encountered, true otherwise
		 **/
		public function getFileInfo($file=false)
		{
// 			if the file has not been specified check to see if an input file has been specified
			if($file === false)
			{
				if(!$this->_input_file)
				{
//					input file not valid
					return $this->_raiseError('getFileInfo_no_input');
//<-				exits
				}
				$file = $this->_input_file;
			}
			
// 			create a hash of the filename
			$hash = md5($file);
			$info_file = $this->_tmp_directory.$this->unique($hash).'.info';
			
// 			execute the ffmpeg lookup
			exec(FFMPEG_BINARY.' -i '.$file.' &> '.$info_file);
			
			$data = false;
// 			try to open the file
			$handle = fopen($info_file, 'r');
			if($handle)
			{
				$data = array();
				$buffer = '';
// 				loop through the lines of data and collect the buffer
			    while (!feof($handle))
				{
			        $buffer .= fgets($handle, 4096);
				}
// 				grab the duration and bitrate data
				preg_match_all('/Duration: (.*)/', $buffer, $matches);
				if(count($matches) > 0)
				{
					$parts 						= explode(', ', trim($matches[1][0]));
					$data['duration_timecode'] 	= $parts[0];
					$data['duration_seconds'] 	= $this->timecodeToSeconds($data['duration_timecode']);
					$data['start']  			= ltrim($parts[1], 'start: ');
					$data['bitrate']  			= ltrim($parts[2], 'bitrate: ');
				}
// 				match the video stream info
				preg_match_all('/Stream(.*): Video: (.*)/', $buffer, $matches);
				if(count($matches) > 0)
				{
					$parts 							= explode(', ', trim($matches[2][0]));
					$data['video'] 					= array();
					$data['video']['frame_rate'] 	= floatval(array_pop($parts));
					$dimension_parts				= array_pop($parts);
					$data['video']['format'] 		= $parts;
// 					get the dimension parts
					preg_match('/([0-9]{0,9})x([0-9]{0,9}) \[(.*)\]/', $dimension_parts, $dimension_matches);
					$data['video']['dimensions'] 	= array(
						'width' 					=> floatval($dimension_matches[1]),
						'height' 					=> floatval($dimension_matches[2])
					);
// 					get the ratios
					$ratios 						= explode(' ', $dimension_matches[3]);
					for($i=0, $a=count($ratios); $i<$a; $i+=2)
					{
						switch(strtolower($ratios[$i]))
						{
							case 'dar' :
								$data['video']['display_aspect_ratio'] = $ratios[$i+1];
								break;
							case 'par' :
								$data['video']['pixel_aspect_ratio'] = $ratios[$i+1];
								break;
						}
					}
// 					work out the number of frames
					if(isset($data['duration_seconds']))
					{
						$data['video']['frame_count'] = ceil($data['duration_seconds'] * $data['video']['frame_rate']);
					}
				}
				
// 				match the audio stream info
				preg_match_all('/Stream(.*): Audio: (.*)/', $buffer, $matches);
				if(count($matches) > 0)
				{
					$parts 							= explode(', ', trim($matches[2][0]));
					$data['audio'] 					= array();
					$data['audio']['stereo'] 		= array_pop($parts) != 'mono';
					$data['audio']['frequency'] 	= floatval(array_pop($parts));
					$data['audio']['format'] 		= $parts;
				}

//	 			check that some data has been obtained
				if(!count($data))
				{
					$data = false;
				}
			    fclose($handle);
			}
			if(is_file($info_file))
			{
//	 			if the info file exists remove it
				unlink($info_file);
			}
			return $data;
		}		

		/**
		 * Sets the input file that is going to be manipulated.
		 *
		 * @access public
		 * @param string $file The absolute path of the file that is required to be manipulated.
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setInputFile()
		{
// 			get the input files
			$files = func_get_args();
			$files_length = count($files);
// 			if the total number of files entered is 1 then only one file is being processed
			if($files_length == 1)
			{
//				check the input file, if there is a %d in there or a similar %03d then the file inputted is a sequence, if neither of those is found
//				then qheck to see if the file exists
				if(!preg_match('/\%([0-9]+)\d/', $files[0]) && strpos($files[0], '%d') === false && !is_file($files[0]))
				{
//					input file not valid
					return $this->_raiseError('setInputFile_file_existence', array('file'=>$files[0]));
//<-				exits
				}
				$this->_input_file = $files[0];
				$this->_input_file_id = md5($files[0]);
			}
			else
			{
// 				more than one video is being added as input so we must join them all
				call_user_func_array(array(&$this, 'addVideo'), $files);
			}
			return true;
		}
		
		/**
		 * A shortcut for converting video to FLV.
		 *
		 * @access public
		 * @param integer $audio_sample_frequency
		 * @param integer $audio_bitrate
		 */
		public function setFormatToFLV($audio_sample_frequency=44100, $audio_bitrate=64)
		{
			$this->addCommand('-sameq');
			$this->addCommand('-acodec', 'mp3');
//			adjust the audio rates
			$this->setAudioBitRate($audio_bitrate);
			$this->setAudioSampleFrequency($audio_sample_frequency);
//			set the video format
			$this->setFormat(self::FORMAT_FLV);
//			flag that the flv has to have meta data added after the excecution of this command
			$this->_flv_conversion = true;
		}
		
		/**
		 * This is an alias for setFormat, but restricts it to audio only formats.
		 * 
		 * @access public
		 * @param integer $format A supported audio format.
		 * @param integer $audio_sample_frequency
		 * @param integer $audio_bitrate
		 **/
		public function extractAudio($format=ffmpeg::FORMAT_MP3, $audio_sample_frequency=44100, $audio_bitrate=64)
		{
// 			check the format is one of the audio formats
			if(!in_array($format, array(self::FORMAT_AAC, self::FORMAT_AIFF, self::FORMAT_MP2, self::FORMAT_MP3, self::FORMAT_MP4, self::FORMAT_MPEG4, self::FORMAT_M4A, self::FORMAT_WAV)))
			{
				return $this->_raiseError('extractAudio_valid_format', array('format'=>$format));
//<-			exits
			}
			$this->setFormat($format);
//			adjust the audio rates
			$this->setAudioBitRate($audio_bitrate);
			$this->setAudioSampleFrequency($audio_sample_frequency);
		}

		/**
		 * When converting video to FLV the meta data has to be added by a ruby program called FLVTools2.
		 * This is a second exec call only after the video has been converted to FLV
		 * http://inlet-media.de/flvtool2
		 *
		 * @access private
		 * @param $log boolean determines if a log file of the results should be generated.
		 * @param $parent_logfile string If logging is enabled the previous exec log filename will be passed so this log can be added.
		 */
		private function _addMetaToFLV($log=false, $parent_logfile=null)
		{
//			prepare the command suitable for exec
			$exec_string = $this->_prepareCommand(FFMPEG_FLVTOOLS_BINARY, '-U '.$this->_process_address);
//			execute the command
			exec($exec_string);
			if(is_array($this->_processed[0]))
			{
				array_push($this->_processed[0], $exec_string);
			}
			else
			{
				$this->_processed[0] = array($this->_processed[0], $exec_string);
			}
		}

		/**
		 * Sets the new video format.
		 *
		 * @access public
		 * @param defined $format The format should use one of the defined variables stated below.
		 * 		ffmpeg::FORMAT_3GP2 - 3g2
		 * 		ffmpeg::FORMAT_3GP - 3gp
		 * 		ffmpeg::FORMAT_AAC - aac
		 * 		ffmpeg::FORMAT_AIFF - aiff
		 * 		ffmpeg::FORMAT_AMR - amr
		 * 		ffmpeg::FORMAT_ASF - asf
		 * 		ffmpeg::FORMAT_AVI - avi
		 * 		ffmpeg::FORMAT_FLV - flv
		 * 		ffmpeg::FORMAT_GIF - gif
		 * 		ffmpeg::FORMAT_MJ2 - mj2
		 * 		ffmpeg::FORMAT_MP2 - mp2
		 * 		ffmpeg::FORMAT_MP3 - mp3
		 * 		ffmpeg::FORMAT_MP4 - mp4
		 * 		ffmpeg::FORMAT_MPEG4 - mpeg4
		 * 		ffmpeg::FORMAT_M4A - m4a
		 * 		ffmpeg::FORMAT_MPEG - mpeg
		 * 		ffmpeg::FORMAT_MPEG1 - mpeg1video
		 * 		ffmpeg::FORMAT_MPEG2 - mpeg2video
		 * 		ffmpeg::FORMAT_MPEGVIDEO - mpegvideo
		 * 		ffmpeg::FORMAT_PSP - psp
		 * 		ffmpeg::FORMAT_RM - rm
		 * 		ffmpeg::FORMAT_SWF - swf
		 * 		ffmpeg::FORMAT_VOB - vob
		 * 		ffmpeg::FORMAT_WAV - wav
    	 *    	ffmpeg::FORMAT_JPG - jpg
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setFormat($format)
		{
//			validate input
			if(!in_array($format, array(self::FORMAT_3GP2, self::FORMAT_3GP, self::FORMAT_AAC, self::FORMAT_AIFF, self::FORMAT_AMR, self::FORMAT_ASF, self::FORMAT_AVI, self::FORMAT_FLV, self::FORMAT_GIF, self::FORMAT_MJ2, self::FORMAT_MP2, self::FORMAT_MP3, self::FORMAT_MP4, self::FORMAT_MPEG4, self::FORMAT_M4A, self::FORMAT_MPEG, self::FORMAT_MPEG1, self::FORMAT_MPEG2, self::FORMAT_MPEGVIDEO, self::FORMAT_PSP, self::FORMAT_RM, self::FORMAT_SWF, self::FORMAT_VOB, self::FORMAT_WAV, self::FORMAT_JPG)))
			{
				return $this->_raiseError('setFormat_valid_format', array('format'=>$format));
//<-			exits
			}
			return $this->addCommand('-f', $format);
		}

		/**
		 * Sets the audio sample frequency for audio outputs
		 *
		 * @access public
		 * @param integer $audio_sample_frequency Valid values are 11025, 22050, 44100
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setAudioSampleFrequency($audio_sample_frequency)
		{
//			validate input
			if(!in_array(intval($audio_sample_frequency), array(11025, 22050, 44100)))
			{
				return $this->_raiseError('setAudioSampleFrequency_valid_frequency', array('frequency'=>$audio_sample_frequency));
//<-			exits
			}
			return $this->addCommand('-ar', $audio_sample_frequency);
		}

		/**
		 * Sets the audio format for audio outputs
		 *
		 * @access public
		 * @param integer $audio_format Valid values are ffmpeg::FORMAT_AAC, ffmpeg::FORMAT_AIFF, ffmpeg::FORMAT_AMR, ffmpeg::FORMAT_ASF, ffmpeg::FORMAT_MP2, ffmpeg::FORMAT_MP3, ffmpeg::FORMAT_MP4, ffmpeg::FORMAT_MPEG2, ffmpeg::FORMAT_RM, ffmpeg::FORMAT_WAV
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setAudioFormat($audio_format)
		{
//			validate input
			if(!in_array($audio_format, array(self::FORMAT_AAC, self::FORMAT_AIFF, self::FORMAT_AMR, self::FORMAT_ASF, self::FORMAT_MP2, self::FORMAT_MP3, self::FORMAT_MP4, self::FORMAT_MPEG2, self::FORMAT_RM, self::FORMAT_WAV)))
			{
				return $this->_raiseError('setAudioFormat_valid_format', array('format'=>$audio_format));
//<-			exits
			}
			return $this->addCommand('-acodec', $audio_format);
		}

		/**
		 * Sets the video format for video outputs. This should not be confused with setFormat. setVideoFormat does not generally need to
		 * be called unless setting a specific video format for a type of media format. It gets a little confusing...
		 *
		 * @access public
		 * @param integer $video_format Valid values are 11025, 22050, 44100
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setVideoFormat($video_format)
		{
//			validate input
			if(!in_array($video_format, array(self::FORMAT_3GP2, self::FORMAT_3GP, self::FORMAT_AVI, self::FORMAT_FLV, self::FORMAT_GIF, self::FORMAT_MJ2, self::FORMAT_MP4, self::FORMAT_MPEG4, self::FORMAT_M4A, self::FORMAT_MPEG, self::FORMAT_MPEG1, self::FORMAT_MPEG2, self::FORMAT_MPEGVIDEO)))
			{
				return $this->_raiseError('setVideoFormat_valid_format', array('format'=>$video_format));
//<-			exits
			}
			return $this->addCommand('-vcodec', $video_format);
		}

		/**
		 * Disables audio encoding
		 *
		 * @access public
		 * @return boolean false on error encountered, true otherwise
		 */
		public function disableAudio()
		{
			return $this->addCommand('-an');
		}

		/**
		 * Sets the audio bitrate
		 *
		 * @access public
		 * @param integer $audio_bitrate Valid values are 16, 32, 64
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setAudioBitRate($bitrate)
		{
//			validate input
			if(!in_array(intval($bitrate), array(16, 32, 64, 128)))
			{
				return $this->_raiseError('setAudioBitRate_valid_bitrate', array('bitrate'=>$bitrate));
//<-			exits
			}
			return $this->addCommand('-ab', $bitrate.'kb');
		}

		/**
		 * Compiles an array of images into a video. This sets the input file (setInputFile) so you do not need to set it.
		 * The images should be a full absolute path to the actual image file.
		 * (Note; This copies and renames all the supplied images into a temporary folder so the images don't have to be specifically named. However, when
		 * creating the ffmpeg instance you will need to set the absolute path to the temporary folder. The default path is '/tmp/'.
		 *
		 * @access public
		 * @param array $images An array of images that are to be joined and converted into a video
		 * @return boolean Returns false on encountering an error
		 */
		public function prepareImagesForConversionToVideo($images)
		{
//			http://ffmpeg.mplayerhq.hu/faq.html#TOC3
//			ffmpeg -f image2 -i img%d.jpg /tmp/a.mpg
			if(empty($images))
			{
				return $this->_raiseError('prepareImagesForConversionToVideo_one_img');
//<-			exits
			}
//			loop through and validate existence first before making a temporary copy
			foreach ($images as $key=>$img)
			{
				if(!is_file($img))
				{
					return $this->_raiseError('prepareImagesForConversionToVideo_img_404', array('img'=>$img));
//<-				exits
				}
			}
			if(!is_dir($this->_tmp_directory))
			{
				return $this->_raiseError('generic_temp_404');
//<-			exits
			}
			if(!is_writeable($this->_tmp_directory))
			{
				return $this->_raiseError('generic_temp_writable');
//<-			exits
			}
//			get the number of preceding places for the files based on how many files there are to copy
			$total = count($images);
			$pad_num = 0;
			while(($total = ($total/10)) > 1)
			{
				$pad_num += 1;
			}
//			create a temp dir in the temp dir
			$uniqid = $this->unique();
			mkdir($this->_tmp_directory.$uniqid, 0777);
//			loop through, copy and rename specified images to the temp dir
			foreach ($images as $key=>$img)
			{
				$ext = array_pop(explode('.', $img));
				$tmp_file = $this->_tmp_directory.$uniqid.DIRECTORY_SEPARATOR.$this->_tmp_file_prefix.$key.'.jpg';
				if(!@copy($img, $tmp_file))
				{
					return $this->_raiseError('prepareImagesForConversionToVideo_img_copy', array('img'=>$img, 'tmpfile'=>$tmp_file));
//<-				exits
				}
//				push the tmp file name into the unlinks so they can be deleted on class destruction
				array_push($this->_unlink_files, $tmp_file);
			}
//			add the directory to the unlinks
			array_push($this->_unlink_dirs, $this->_tmp_directory.$uniqid);
//			get the input file format
			$file_iteration = $this->_tmp_file_prefix.'%d.jpg';
//			set the input filename
			return $this->setInputFile($this->_tmp_directory.$uniqid.DIRECTORY_SEPARATOR.$file_iteration);
		}

		/**
		 * Sets the video bitrate
		 *
		 * @access public
		 * @param integer $bitrate 
		 * @return boolean
		 */
		public function setVideoBitRate($bitrate)
		{
			$bitrate = intval($bitrate);
			return $this->addCommand('-b', $bitrate.'kb');
		}

		/**
		 * Sets the video output dimensions (in pixels)
		 *
		 * @access public
		 * @param mixed $width If an integer height also has to be specified, otherwise you can use one of the class constants
		 * 		ffmpeg::SIZE_SAS		= Same as input source
		 * 		ffmpeg::SIZE_SQCIF 		= 128 x 96
		 * 		ffmpeg::SIZE_QCIF 		= 176 x 144
		 * 		ffmpeg::SIZE_CIF 		= 352 x 288
		 * 		ffmpeg::SIZE_4CIF 		= 704 x 576
		 * 		ffmpeg::SIZE_QQVGA 		= 160 x 120
		 * 		ffmpeg::SIZE_QVGA 		= 320 x 240
		 * 		ffmpeg::SIZE_VGA 		= 640 x 480
		 * 		ffmpeg::SIZE_SVGA 		= 800 x 600
		 * 		ffmpeg::SIZE_XGA 		= 1024 x 768
		 * 		ffmpeg::SIZE_UXGA 		= 1600 x 1200
		 * 		ffmpeg::SIZE_QXGA 		= 2048 x 1536
		 * 		ffmpeg::SIZE_SXGA 		= 1280 x 1024
		 * 		ffmpeg::SIZE_QSXGA 		= 2560 x 2048
		 * 		ffmpeg::SIZE_HSXGA 		= 5120 x 4096
		 * 		ffmpeg::SIZE_WVGA 		= 852 x 480
		 * 		ffmpeg::SIZE_WXGA 		= 1366 x 768
		 * 		ffmpeg::SIZE_WSXGA 		= 1600 x 1024
		 * 		ffmpeg::SIZE_WUXGA 		= 1920 x 1200
		 * 		ffmpeg::SIZE_WOXGA 		= 2560 x 1600
		 * 		ffmpeg::SIZE_WQSXGA		= 3200 x 2048
		 * 		ffmpeg::SIZE_WQUXGA 	= 3840 x 2400
		 * 		ffmpeg::SIZE_WHSXGA 	= 6400 x 4096
		 * 		ffmpeg::SIZE_WHUXGA 	= 7680 x 4800
		 * 		ffmpeg::SIZE_CGA 		= 320 x 200
		 * 		ffmpeg::SIZE_EGA		= 640 x 350
		 * 		ffmpeg::SIZE_HD480 		= 852 x 480
		 * 		ffmpeg::SIZE_HD720 		= 1280 x 720
		 * 		ffmpeg::SIZE_HD1080		= 1920 x 1080
		 * @param integer $height
		 * @return boolean
		 */
		public function setVideoOutputDimensions($width, $height=null)
		{
			if($height === null || $height === true)
			{
//				validate input
				if(!in_array($width, array(self::SIZE_SAS, self::SIZE_SQCIF, self::SIZE_QCIF, self::SIZE_CIF, self::SIZE_4CIF, self::SIZE_QQVGA, self::SIZE_QVGA, self::SIZE_VGA, self::SIZE_SVGA, self::SIZE_XGA, self::SIZE_UXGA, self::SIZE_QXGA, self::SIZE_SXGA, self::SIZE_QSXGA, self::SIZE_HSXGA, self::SIZE_WVGA, self::SIZE_WXGA, self::SIZE_WSXGA, self::SIZE_WUXGA, self::SIZE_WOXGA, self::SIZE_WQSXGA, self::SIZE_WQUXGA, self::SIZE_WHSXGA, self::SIZE_WHUXGA, self::SIZE_CGA, self::SIZE_EGA, self::SIZE_HD480, self::SIZE_HD720, self::SIZE_HD1080)))
				{
					return $this->_raiseError('setVideoOutputDimensions_valid_format', array('format'=>$format));
//<-				exits
				}
				if($width === self::SIZE_SAS)
				{
// 					and override is made so no command is added in the hope that ffmpeg will just output the source
					if($height === true)
					{
						return true;
					}
// 					get the file info
					$info = $this->getFileInfo();
					if(!isset($info['video']) || !isset($info['video']['dimensions']))
					{
						return $this->_raiseError('setVideoOutputDimensions_sas_dim');
					}
					else
					{
						$width = $info['video']['dimensions']['width'].'x'.$info['video']['dimensions']['height'];
					}
				}
			}
			else
			{
				$width = $width.'x'.$height;
			}
			$this->addCommand('-s', $width);
			return true;
		}

		/**
		 * Sets the video aspect ratio
		 *
		 * @access public
		 * @param string|integer $ratio Valid values are ffmpeg::RATIO_STANDARD, ffmpeg::RATIO_WIDE, ffmpeg::RATIO_CINEMATIC, or '4:3', '16:9', '1.85' 
		 * @return boolean
		 */
		public function setVideoAspectRatio($ratio)
		{
			if(!in_array($ratio, array(self::RATIO_STANDARD, self::RATIO_WIDE, self::RATIO_CINEMATIC)))
			{
				return $this->_raiseError('setVideoAspectRatio_valid_ratio', array('ratio'=>$ratio));
			}
			$this->addCommand('-aspect', $ratio);
			return true;
		}
		
		/**
		 * Sets the frame rate of the video
		 *
		 * @access public
		 * @param string|integer $fps 1 being 1 frame per second
		 * @return boolean
		 */
		public function setVideoFrameRate($fps)
		{
			return $this->addCommand('-r', floatval($fps));
		}
		
		/**
		 * Extracts frames from a video.
		 * (Note; If set to 1 and the duration set by $extract_begin_timecode and $extract_end_timecode is equal to 1 you get more than one frame.
		 * For example if you set $extract_begin_timecode='00:00:00' and $extract_end_timecode='00:00:01' you might expect because the time span is
		 * 1 second only to get one frame if you set $frames_per_second=1. However this is not correct. The timecode you set in $extract_begin_timecode
		 * acts as the beginning frame. Thus in this example the first frame exported will be from the very beginning of the video, the video will
		 * then move onto the next frame and export a frame there. Therefore if you wish to export just one frame from one position in the video,
		 * say 1 second in you should set $extract_begin_timecode='00:00:01' and set $extract_end_timecode='00:00:01'.)
		 * 		(Sub note; You can set ffmpeg::image_output_timecode = true if you wish the output to be automatically renamed to include the timecode. The
		 * 		outputted timecode would be in the following format: hhhh(...h):mm:ss:ff, where ff is the frame number for that second. The frame number starts at 01
		 * 		and ends in the $frames_per_second)
		 *
		 * @access public
		 * @param string|integer $extract_begin_timecode A timecode (hh:mm:ss) or integer (in seconds) for where the extraction process is to start
		 * @param string|integer|boolean $extract_end_timecode A timecode (hh:mm:ss) or integer (in seconds) for where the extraction process is to end, or false
		 * 			if all frames from the begin timecode are to be exported. (Boolean added by Matthias. Thanks. 12th March 2007)
		 * @param integer $frames_per_second The number of frames per second to extract.
		 * @param boolean|integer $frame_limit Frame limiter. If set to false then all the frames will be exported from the given time codes, however
		 * 			if you wish to set a export limit to the number of frames that are exported you can set an integer. For example; if you set
		 * 			$extract_begin_timecode='00:00:11', $extract_end_timecode='00:01:10', $frames_per_second=1, you will get one frame for every second
		 * 			in the video between 00:00:11 and 00:01:10 (ie 60 frames), however if you ant to artificially limit this to exporting only ten frames
		 * 			then you set $frame_limit=10. You could of course alter the timecode to reflect you desired frame number, however there are situations
		 * 			when a shortcut such as this is useful and necessary.
		 */
		public function extractFrames($extract_begin_timecode='00:00:01', $extract_end_timecode='00:00:01', $frames_per_second=1, $frame_limit=false)
		{
			$this->addCommand('-an');
			$this->addCommand('-ss', $extract_begin_timecode);
//			added by Matthias on 12th March 2007
//			allows for exporting the entire timeline
			if($extract_end_timecode !== false)
			{
        		$this->addCommand('-t', $extract_end_timecode);
			}
			$this->addCommand('-r', $frames_per_second);
			if($frame_limit !== false)
			{
				$this->addCommand('-vframes', $frame_limit);
			}
			if($this->image_output_timecode)
			{
				$this->_image_output_timecode_start = $extract_begin_timecode;
				$this->_image_output_timecode_fps = $frames_per_second;
			}
		}

		/**
		 * Extracts one frame
		 *
		 * @access public
		 * @uses $ffmpeg->extractFrames
		 */
		public function extractFrame($extract_begin_timecode='00:00:00')
		{
			$this->extractFrames($extract_begin_timecode, $extract_begin_timecode, 1, 1);
		}

		/**
		 * Adds a watermark to the outputted files. This effects both video and image output.
		 *
		 * @access public
		 * @param string $watermark_url The absolute path to the watermark image.
		 * @param string $vhook The absolute path to the ffmpeg vhook watermark library.
		 */
		public function addWatermark($watermark_url, $vhook=FFMPEG_WATERMARK_VHOOK)
		{
			if(!is_file($watermark_url))
			{
				return $this->_raiseError('addWatermark_img_404', array('watermark'=>$watermark_url));
			}
			$this->addCommand('-vhook', $vhook.' -f '.$watermark_url);
// 			an alternative via gd, for images only
//			$watermark = imagecreatefrompng($watermark_url);
//			imagealphablending($watermark, false);
//			imagesavealpha($watermark, true);
//			$watermark_width = imagesx($watermark);
//			$watermark_height = imagesy($watermark);
//			$image = imagecreatetruecolor($watermark_width, $watermark_height);
//			$image = imagecreatefromjpeg($file);
//			$size = getimagesize($file);
//			$dest_x = $size[0] - $watermark_width;
//			$dest_y = $size[1] - $watermark_height;
//			imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
//			imagejpeg($image, STORAGE_ABSOLUTE_BASE.$preview_filename, 100);
//			imagedestroy($image);
//			imagedestroy($watermark);
		}
		
// 		/**
// 		 * This will overlay an audio file over the top of a video file
// 		 **/
// 		public function overlayAudio($audio_file)
// 		{
// 			$this->addCommand('-newaudio', '');
// 		}

		/**
		 * This will adjust the audio volume.
		 * 
		 * @access public
		 * @param integer $vol 256 = normal
		 **/
		public function adjustVolume($vol=256)
		{
			$this->addCommand('-vol', '');
		}

		/**
		 * This process will combine the original input video with the video specified by this function.
		 * This function accepts more than one video as arguments. They will be added in order of the arguments.
		 * 	ie. input_video -> video1 -> video2 etc
		 * The process of doing this can take a long time as each incoming video has to be first converted
		 * into a format that accepts joining. The default joining codec is "mpg". However for almost lossless
		 * quality you can use the "yuv4mpegpipe" format. This is of course dependent upon your ffmpeg binary.
		 * You can check to see if you server supports yuv4mpegpipe by typing "ffmpeg -formats" into the
		 * command line. If you want to use the yuv4mpegpipe format you can add the flag, FFMPEG_USE_HQ_JOIN to the
		 * end of the video inputs. WARNING: High Quality joins will take longer to process. (well duh!)
		 *
		 * @access public
		 * @param $video1, $video2, $video3... $video(n) Paths of videos to attach to the input video.
		 * @param $flag integer FFMPEG_USE_HQ_JOIN If you wish to use the yuv4mpegpipe format for join add this to the end of the video list.
		 */
		public function addVideo()
		{
			$videos = func_get_args();
			$videos_length = count($videos);
// 			is last arg the hq join flag
// 			check to see if a starter file has been added, if not set the input as an array
			if($this->_input_file === null)
			{
				$this->_input_file = array();
			}
// 			if the input file is already set as a string that means as start file has been added so absorb into the input array
			else if(is_string($this->_input_file))
			{
				$this->_input_file = array($this->_input_file);
			}
			foreach($videos as $key=>$file)
			{
				if(!preg_match('/\%([0-9]+)\d/', $file) && strpos($file, '%d') === false && !is_file($file))
				{
// 					input file not valid
					return $this->_raiseError('addVideo_file_404', array('file'=>$file));
//<-				exits
				}
				array_push($this->_input_file, $file);
			}
		}

		/**
		 * @access public
		 * @uses addVideo()
		 */
		public function addVideos()
		{
			$videos = func_get_args();
			call_user_func_array(array(&$this, 'addVideo'), $videos);
		}

		/**
		 * Sets the output.
		 *
		 * @access public
		 * @param string $output_directory The directory to output the command output to
		 * @param string $output_name The filename to output to.
		 * 			(Note; if you are outputting frames from a video then you will need to add an extra item to the output_name. The output name you set is required
		 * 			to contain '%d'. '%d' is replaced by the image number. Thus entering setting output_name $output_name='img%d.jpg' will output
		 * 			'img1.jpg', 'img2.jpg', etc... However 'img%03d.jpg' generates `img001.jpg', `img002.jpg', etc...)
		 * @param boolean $overwrite_mode Accepts one of the following class constants
		 * 	- ffmpeg::OVERWRITE_FAIL		- This produces an error if there is a file conflict and the processing is halted.
		 * 	- ffmpeg::OVERWRITE_PRESERVE	- This continues with the processing but no file overwrite takes place. The processed file is left in the temp directory
		 * 									  for you to manually move.
		 * 	- ffmpeg::OVERWRITE_EXISTING	- This will replace any existing files with the freshly processed ones.
		 * 	- ffmpeg::OVERWRITE_UNIQUE		- This will appended every output with a unique hash so that the filesystem is preserved.
		 * @return boolean false on error encountered, true otherwise
		 */
		public function setOutput($output_directory, $output_name, $overwrite_mode=ffmpeg::OVERWRITE_FAIL)
		{
//			check if directoy exists
			if(!is_dir($output_directory))
			{
				return $this->_raiseError('setOutput_output_dir_404', array('dir'=>$output_directory));
//<-			exits
			}
//			check if directory is writeable
			if(!is_writable($output_directory))
			{
				return $this->_raiseError('setOutput_output_dir_writable', array('dir'=>$output_directory));
//<-			exits
			}
//			check to see if a output delimiter is set
			$has_d = preg_match('/\%([0-9]+)\d/', $output_name) || strpos($output_name, '%d') !== false;
			if(!$has_d)
			{
//				determine if the extension is an image. If it is then we will be extracting frames so check for %d
				$output_name_info = pathinfo($output_name);
//				NOTE: for now we'll just stick to the common image formats, SUBNOTE: gif is ignore because ffmpeg can create animated gifs
				if(in_array(strtolower($output_name_info['extension']), array('jpg', 'jpeg', 'png')))
				{
					return $this->_raiseError('setOutput_%d');
//<-				exits
				}
			}
//			set the output address
			$this->_output_address = $output_directory.$output_name;
// 			set the processing address in the temp folder so it does not conflict with any other conversions
			
			//$this->_process_address = $this->_tmp_directory.$this->unique().'-!!@@!!-'.$output_name;
			$this->_process_address = $this->_tmp_directory.$output_name;
			
			$this->_overwrite_mode = $overwrite_mode;
			return true;
		}
		
		/**
		 * Sets a constant quality value to the encoding. (but a variable bitrate)
		 * 
		 * @param integer $quality The quality to adhere to. 100 is highest quality, 1 is the lowest quality
		 */
		public function setConstantQuality($quality)
		{
// 			interpret quality into ffmpeg value
			$quality = 31 - round(($quality/100) * 31);
			if($quality > 31)
			{
				$quality = 31;
			}
			else if($quality < 1)
			{
				$quality = 1;
			}
			$this->addCommand('-qscale', $quality);
		}

		/**
		 * Translates a number of seconds to a timecode.
		 *
		 * @access public
		 * @param integer $input_seconds The number of seconds you want to calculate the timecode for.
		 */
		public function secondsToTimecode($input_seconds=0)
		{
			$timestamp = mktime(0, 0, $input_seconds, 0, 0);
			return date('H:i:s', $timestamp);
		}

		/**
		 * Translates a timecode to the number of seconds
		 *
		 * @access public
		 * @param integer $input_seconds The number of seconds you want to calculate the timecode for.
		 */
		public function timecodeToSeconds($input_timecode='00:00:00')
		{
			$hours_end = strpos($input_timecode, ':', 0);
			$hours = substr($input_timecode, 0, $hours_end);
			$mins = substr($input_timecode, $hours_end+1, 2);
			$secs = substr($input_timecode, $hours_end+4);
			return ($hours*3600) + ($mins*60) + $secs;
		}

		/**
		 * This is a private function that joins multiple input sources into one source before
		 * the final processing.
		 *
		 * @access private
		 * @param boolean $log
		 */
		private function _joinInput($log)
		{
//			create a temp dir in the temp dir
			$temp_file = $this->_tmp_directory.$this->unique().'.'.array_pop(explode('.', $this->_process_address));
// 			do the memcoder join
// 			mencoder -oac copy -ovc copy -idx -o output.avi video1.avi video2.avi video3.avi
			$exec_string = FFMPEG_MENCODER_BINARY.' -oac copy -ovc copy -idx -o '.$temp_file.' '.implode(' ', $this->_input_file);
			if($log)
			{
				$this->_log_file = $this->_tmp_directory.$this->unique().'.info';
// 				array_push($this->_unlink_files, $this->_log_file);
				$exec_string = $exec_string.' &> '.$this->_log_file;
			}
			exec($exec_string);
			echo $exec_string;
			exit;
		}

		/**
		 * Commits all the commands and executes the ffmpeg procedure. This will also attempt to validate any outputted files in order to provide
		 * some level of stop and check system.
		 *
		 * @access public
		 * @param $multi_pass_encode boolean Determines if multi (2) pass encoding should be used.
		 * @param $log boolean Determines if a log file of the results should be generated.
		 * @return mixed 
		 * 		- false 										On error encountered.
		 * 		- ffmpeg::RESULT_OK (bool true)					If the file has successfully been processed and moved ok to the output address
		 * 		- ffmpeg::RESULT_OK_BUT_UNWRITABLE (int -1)		If the file has successfully been processed but was not able to be moved correctly to the output address
		 * 														If this is the case you will manually need to move the processed file from the temp directory. You can
		 * 														get around this by settings the third argument from ffmpeg::setOutput(), $overwrite to true.
		 * 		- n (int)										A positive integer is only returned when outputting a series of frame grabs from a movie. It dictates
		 * 														the total number of frames grabbed from the input video. You should also not however, that if a conflict exists
		 * 														with one of the filenames then this return value will not be returned, but ffmpeg::RESULT_OK_BUT_UNWRITABLE
		 * 														will be returned instead.
		 * 	Because of the mixed return value you should always go a strict evaluation of the returned value. ie
		 * 
		 * 	$result = $ffmpeg->excecute();
		 *  if($result === false)
		 *  {
		 * 		// error
		 *  }
		 *  else if($result === ffmpeg::RESULT_OK_BUT_UNWRITABLE)
		 *  {
		 * 		// ok but a manual move is required. The file to move can be it can be retrieved by $ffmpeg->getLastOutput();
		 *  }
		 *  else if($result === ffmpeg::RESULT_OK)
		 *  {
		 * 		// everything is ok.
		 *  }
		 */
		public function execute($multi_pass_encode=false, $log=false)
		{
// 			check for inut and output params
			$has_placeholder = preg_match('/\%([0-9]+)\d/', $this->_process_address) || strpos($this->_process_address, '%d') !== false;
			if($this->_input_file === null && !$has_placeholder)
			{
				return $this->_raiseError('execute_input_404');
//<-			exits
			}
//			check to see if the output address has been set
			if($this->_process_address === null)
			{
				return $this->_raiseError('execute_output_not_set');
//<-			exits
			}
			
			if(($this->_overwrite_mode == self::OVERWRITE_PRESERVE || $this->_overwrite_mode == self::OVERWRITE_FAIL) && is_file($this->_process_address))
			{
				return $this->_raiseError('execute_overwrite_process');
//<-			exits
			}
			
// 			carry out some overwrite checks if required
			$overwrite = '';
			switch($this->_overwrite_mode)
			{
				case self::OVERWRITE_UNIQUE :
// 					insert a unique id into the output address (the process address already has one)
					$unique = '';//$this->unique();
					$last_index = strrpos($this->_output_address, DIRECTORY_SEPARATOR);
					$this->_output_address = substr($this->_output_address, 0, $last_index+1).$unique.'-'.substr($this->_output_address, $last_index+1);
					break;
					
				case self::OVERWRITE_EXISTING :
// 					add an overwrite command to ffmpeg execution call
					$overwrite = '-y ';
					break;
					
				case self::OVERWRITE_PRESERVE :
// 					do nothing as the preservation comes later
					break;
					
				case self::OVERWRITE_FAIL :
				default :
// 					if the file should fail
					if(!$has_placeholder && is_file($this->_output_address))
					{
						return $this->_raiseError('execute_overwrite_fail');
//<-					exits
					}
					break;
			}
			
// 			we have multiple inputs that require joining so convert them to a joinable format and join
			if(is_array($this->_input_file))
			{
				$this->_joinInput($log);
			}
			
//			add the input file command to the mix
			$this->addCommand('-i', $this->_input_file);
			
// 			if multi pass encoding is enabled add the commands and logfile
			if($multi_pass_encode)
			{
				$multi_pass_file = $this->_tmp_directory.$this->unique().'-multipass';
				$this->addCommand('-pass', 1);
				$this->addCommand('-passlogfile', $multi_pass_file);
			}

//			combine all the output commands
			$command_string = $this->_combineCommands();

//			prepare the command suitable for exec
//			the input and overwrite commands have specific places to be set so they have to be added outside of the combineCommands function
			$exec_string = $this->_prepareCommand(FFMPEG_BINARY, '-i '.$this->_commands['-i'].' '.$command_string, $overwrite.$this->_process_address);
			if($log)
			{
				$this->_log_file = $this->_tmp_directory.$this->unique().'.info';
				array_push($this->_unlink_files, $this->_log_file);
				$exec_string = $exec_string.' &> '.$this->_log_file;
			}
			
			$this->_timer_start = self::microtimeFloat();
			
//			execute the command
			exec($exec_string);
			
//			track the processed command by adding it to the class
			array_unshift($this->_processed, $exec_string);
			
// 			create the multiple pass encode
			if($multi_pass_encode)
			{
				$pass2_exc_string = str_replace('-pass '.escapeshellarg(1), '-pass '.escapeshellarg(2), $exec_string);
				exec($pass2_exc_string);
				$this->_processed[0] = array($this->_processed[0], $pass2_exc_string);
// 				remove the multipass log file
				unlink($multi_pass_file.'-0.log');
			}
			
//			special exception for adding the meta data to the flv via flvtools after the flv has been created by ffmpeg
			if($this->_flv_conversion)
			{
				$this->_flv_conversion = false;
				$this->_addMetaToFLV($log);
			}
			
// 			keep track of the time taken
			$execution_time = self::microtimeFloat() - $this->_timer_start;
			array_unshift($this->_timers, $execution_time);
			
// 			add the exec string to the log file
			if($log)
			{
				$lines = $this->_processed[0];
				if(!is_array($lines))
				{
					$lines = array($lines);
				}
				array_unshift($lines, $this->_getMessage('ffmpeg_log_separator'), $this->_getMessage('ffmpeg_log_ffmpeg_command'), $this->_getMessage('ffmpeg_log_separator'));
				array_push($lines, $this->_getMessage('ffmpeg_log_separator'), $this->_getMessage('ffmpeg_log_ffmpeg_gunk'), $this->_getMessage('ffmpeg_log_separator'));
				$this->_addToLog($lines, 'r+');
			}

//			must validate a series of outputed items
//			detect if the output address is a sequence output
			if(preg_match('/\%([0-9]+)\d/', $this->_output_address) || strpos($this->_output_address, '%d') !== false)
			{
//				get the path details
				$process_file 	= basename($this->_process_address);
				$process_dir 	= dirname($this->_process_address);
				$output_file 	= basename($this->_output_address);
				$output_dir 	= dirname($this->_output_address);

//				seperate out the filename and padding parts of the sequence
				$process_prefix	= array_shift(explode('-!!@@!!-', $process_file));
				$parts 			= explode('%', $output_file);
				$prefix			= $parts[0];
				$endparts		= explode('d', $parts[1]);
				$padding		= substr($endparts[0], 0, 1);
				$length			= substr($endparts[0], 1);
				$ending 		= $endparts[1];

//				init the iteration values
				$num 			= 1;
				$files 			= array();
				$produced	 	= array();
				$error			= false;
				$file_exists	= false;
				$filename 		= $process_dir.DIRECTORY_SEPARATOR.$prefix.str_pad($num, $length, $padding, STR_PAD_LEFT).$ending;

//				loop and iterate checking for files
				if($this->image_output_timecode)
				{
					$secs_start = $this->timecodeToSeconds($this->_image_output_timecode_start);
					$fps_inc = 1/$this->_image_output_timecode_fps;
					$fps_current_sec = 0;
					$fps_current_frame = 0;
				}
				
//				loop checking for file existence
				while(@file_exists($filename))
				{
//					check for empty file
					$size = filesize($filename);
					if($size == 0)
					{
						$error = true;
					}
					if(@file_exists($filename))
					{
						array_push($produced, $filename);
//						if the filename is to be changed to include timecode
						if($this->image_output_timecode)
						{
							$fps_current_sec += $fps_inc;
							$fps_current_frame += 1;
							if($fps_current_sec >= 1)
							{
								$fps_current_sec = $fps_inc;
								$secs_start += 1;
								$fps_current_frame = 1;
							}
//							make the timecode
							$timecode = $this->secondsToTimecode($secs_start).':'.str_pad($fps_current_frame, 2, '0', STR_PAD_LEFT);
//							make it safe
							$timecode = str_replace(':', $this->timecode_seperator_output, $timecode);
// 							check if the file exists already and if it does check that it can be overriden
							$new_filename = $output_dir.DIRECTORY_SEPARATOR.$prefix.$timecode.$ending;
							if(!is_file($new_filename) || $this->_overwrite_mode == self::OVERWRITE_EXISTING)
							{
								rename($filename, $new_filename);
								$filename = $new_filename;
							}
// 							the file exists and is not allowed to be overriden so just rename in the temp directory using the timecode
							else if($this->_overwrite_mode == self::OVERWRITE_PRESERVE)
							{
								$new_filename = $process_dir.DIRECTORY_SEPARATOR.$process_prefix.'-!!@@!!-'.$prefix.$timecode.$ending;
								rename($filename, $new_filename);
								$filename = $new_filename;
// 								add the error to the log file
								if($log)
								{
									$this->_logResult('execute_image_file_exists', array('file'=>$new_filename));
								}
// 								flag the conflict
								$file_exists = true;
							}
// 							the file exists so the process must fail
							else
							{
// 								add the error to the log file
								if($log)
								{
									$this->_logResult('execute_overwrite_fail');
								}
// 								tidy up the produced files
								array_merge($this->_unlink_files, $produced);
								return $this->_raiseError('execute_overwrite_fail');
							}
						}
						else
						{
// 							check if the file exists already and if it does check that it can be overriden
							$new_filename = $output_dir.DIRECTORY_SEPARATOR.$prefix.str_pad($num, $length, $padding, STR_PAD_LEFT).$ending;
							if(!is_file($new_filename) || $this->_overwrite_mode == self::OVERWRITE_EXISTING)
							{
								rename($filename, $new_filename);
								$filename = $new_filename;
							}
// 							the file exists and is not allowed to be overriden so just flag a conflict
							else if($this->_overwrite_mode == self::OVERWRITE_PRESERVE)
							{
								$file_exists = true;
// 								add the error to the log file
								if($log)
								{
									$this->_logResult('execute_image_file_exists', array('file'=>$new_filename));
								}
							}
// 							the file exists so the process must fail
							else
							{
// 								add the error to the log file
								if($log)
								{
									$this->_logResult('execute_overwrite_fail');
								}
// 								tidy up the produced files
								array_merge($this->_unlink_files, $produced);
								return $this->_raiseError('execute_overwrite_fail');
							}
						}
//						process the name change if the %d is to be replaced with the timecode
						$num += 1;
					}
					$files[$filename] = $size > 0 ? basename($filename) : false;
// 					get the next incremented filename to check for existance
					$filename = $process_dir.DIRECTORY_SEPARATOR.$process_prefix.'-!!@@!!-'.$prefix.str_pad($num, $length, $padding, STR_PAD_LEFT).$ending;
				}
//				de-increment the last num as it wasn't found
				$num -= 1;

//				if the file was detected but were empty then display a different error
				if($error === true)
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_partial_error', array('input'=>$this->_input_file));
					}
					return $this->_raiseError('execute_partial_error', array('input'=>$this->_input_file));
//<-				exits
				}

//				no files were generated in this sequence
				if($num == 0)
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_image_error', array('input'=>$this->_input_file));
					}
					return $this->_raiseError('execute_image_error', array('input'=>$this->_input_file));
//<-				exits
				}
				
//				add the files the the class a record of what has been generated
				array_unshift($this->_files, $files);

				return $file_exists ? self::RESULT_OK_BUT_UNWRITABLE : $num;
			}
//			must validate one file
			else
			{
//				check that it is a file
				if(!is_file($this->_process_address))
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_output_404', array('input'=>$this->_input_file));
					}
					return $this->_raiseError('execute_output_404', array('input'=>$this->_input_file));
//<-				exits
				}
//				the file does exist but is it empty?
				if(filesize($this->_process_address) == 0)
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_output_empty', array('input'=>$this->_input_file));
					}
					return $this->_raiseError('execute_output_empty', array('input'=>$this->_input_file));
//<-				exits
				}
// 				print_r(array($this->_output_address, $this->_process_address));
// 				the file is ok so move to output address
				if(!is_file($this->_output_address) || $this->_overwrite_mode == self::OVERWRITE_EXISTING)
				{
// 					rename and check it went ok
					if(rename($this->_process_address, $this->_output_address))
					{
// 						the file has been renamed ok
// 						add the error to the log file
						if($log)
						{
							$this->_logResult('execute_result_ok', array('output'=>$this->_output_address));
						}
//						add the file the the class a record of what has been generated
						array_unshift($this->_files, array($this->_output_address));
						return self::RESULT_OK;
					}
// 					renaming failed so return ok but erro
					else
					{
// 						add the error to the log file
						if($log)
						{
							$this->_logResult('execute_result_ok_but_unwritable', array('process'=>$this->_process_address, 'output'=>$this->_output_address));
						}
//						add the file the the class a record of what has been generated
						array_unshift($this->_files, array($this->_process_address));
						return self::RESULT_OK_BUT_UNWRITABLE;
					}
				}
// 				if it is not we signal that it has been created but has not been moved.
				else if($this->_overwrite_mode == self::OVERWRITE_PRESERVE)
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_result_ok_but_unwritable', array('process'=>$this->_process_address, 'output'=>$this->_output_address));
					}
//					add the file the the class a record of what has been generated
					array_unshift($this->_files, array($this->_process_address));
					return self::RESULT_OK_BUT_UNWRITABLE;
				}
// 				the file exists so the process must fail
				else
				{
// 					add the error to the log file
					if($log)
					{
						$this->_logResult('execute_overwrite_fail');
					}
// 					tidy up the produced files
					array_push($this->_unlink_files, $this->_process_address);
					return $this->_raiseError('execute_overwrite_fail');
				}
			}

			return null;

		}
		
		/**
		 * Adds lines to the current log file.
		 * 
		 * @access private
		 * @param $message
		 * @param $replacements
		 */
		private function _logResult($message, $replacements=false)
		{
			$this->_addToLog(array($this->_getMessage('ffmpeg_log_separator'), $this->_getMessage('ffmpeg_log_ffmpeg_result'), $this->_getMessage('ffmpeg_log_separator'), $this->_getMessage($message, $replacements)));
		}
		
		/**
		 * Adds lines to the current log file.
		 * 
		 * @access private
		 * @param $lines array An array of lines to add to the log file.
		 */
		private function _addToLog($lines, $where='a')
		{
			$handle = fopen($this->_log_file, $where);
			if(is_array($lines))
			{
				$data = implode("\n", $lines)."\n";
			}
			else
			{
				$data = $lines."\n";
			}
			fwrite($handle, $data);
			fclose($handle);
		}
		
		/**
		 * Moves the current log file to another file.
		 * 
		 * @access public
		 * @param $destination string The absolute path of the new filename for the log.
		 * @return boolean Returns the result of the log file rename.
		 */
		public function moveLog($destination)
		{
			$result = false;
			if($this->_log_file !== null && is_file($this->_log_file))
			{
				$result = rename($this->_log_file, $destination);
				$this->_log_file = $destination;
			}
			return $result;
		}

		/**
		 * Reads the current log file
		 * 
		 * @access public
		 * @return string|boolean Returns the current log file content. Returns false on failure.
		 */
		public function readLog()
		{
			if($this->_log_file !== null && is_file($this->_log_file))
			{
				$handle = fopen($this->_log_file, 'r');
				$contents = fread($handle, filesize($this->_log_file));
				fclose($handle);
				return $contents;
			}
			return false;
		}

		/**
		 * Returns the last outputted file that was processed by ffmpeg from this class.
		 *
		 * @access public
		 * @return mixed array|string Will return an array if the output was a sequence, or string if it was a single file output
		 */
		public function getLastOutput()
		{
			return $this->_files[0];
		}

		/**
		 * Returns all the outputted files that were processed by ffmpeg from this class.
		 *
		 * @access public
		 * @return array
		 */
		public function getOutput()
		{
			return $this->_files;
		}

		/**
		 * Returns the amount of time taken of the last file to be processed by ffmpeg.
		 *
		 * @access public
		 * @return mixed integer Will return the time taken in seconds.
		 */
		public function getLastProcessTime()
		{
			return $this->_timers[0];
		}

		/**
		 * Returns the amount of time taken of all the files to be processed by ffmpeg.
		 *
		 * @access public
		 * @return array
		 */
		public function getProcessTime()
		{
			return $this->_timers;
		}

		/**
		 * Returns the last encountered error message.
		 *
		 * @access public
		 * @return string
		 */
		public function getLastError()
		{
			return $this->_errors[0];
		}

		/**
		 * Returns all the encountered errors as an array of strings
		 *
		 * @access public
		 * @return array
		 */
		public function getErrors()
		{
			return $this->_errors;
		}

		/**
		 * Returns the last command that ffmpeg was given.
		 * (Note; if setFormatToFLV was used in the last command then an array is returned as a command was also sent to FLVTool2)
		 *
		 * @access public
		 * @return mixed array|string
		 */
		public function getLastCommand()
		{
			return $this->_processed[0];
		}

		/**
		 * Returns all the commands sent to ffmpeg from this class
		 *
		 * @access public
		 * @return unknown
		 */
		public function getCommands()
		{
			return $this->_processed;
		}

		/**
		 * Raises an error
		 *
		 * @access private
		 * @param string $message
		 * @param array $replacements a list of replacements in search=>replacement format
		 * @return boolean Only returns false if $ffmpeg->on_error_die is set to false
		 */
		private function _raiseError($message, $replacements=false)
		{
			$msg = 'FFMPEG ERROR: '.$this->_getMessage($message, $replacements);
//			check what the error is supposed to do
			if($this->on_error_die === true)
			{
				die($msg);
//<-			exits
			}
//			add the error message to the collection
			array_unshift($this->_errors, $msg);
			return false;
		}

		/**
		 * Gets a message.
		 *
		 * @access private
		 * @param string $message
		 * @param array $replacements a list of replacements in search=>replacement format
		 * @return boolean Only returns false if $ffmpeg->on_error_die is set to false
		 */
		private function _getMessage($message, $replacements=false)
		{
			$message = isset($this->_messages[$message]) ? $this->_messages[$message] : 'Unknown!!!';
			if($replacements)
			{
				$searches = $replaces = array();
				foreach($replacements as $search=>$replace)
				{
					array_push($searches, '#'.$search);
					array_push($replaces, $replace);
				}
				$message = str_replace($searches, $replaces, $message);
			}
			return $message;
		}

		/**
		 * Adds a command to be bundled into the ffmpeg command call.
		 * (SPECIAL NOTE; None of the arguments are checked or sanitized by this function. BE CAREFUL if manually using this. The commands and arguments are escaped
		 * however it is still best to check and sanitize any params given to this function)
		 *
		 * @access public
		 * @param string $command
		 * @param mixed $argument
		 * @return boolean
		 */
		public function addCommand($command, $argument='')
		{
			$this->_commands[$command] = escapeshellarg($argument);
			return true;
		}

		/**
		 * Determines if the the command exits.
		 *
		 * @access public
		 * @param string $command
		 * @return boolean
		 */
		public function hasCommand($command)
		{
			return isset($this->_commands[$command]);
		}

		/**
		 * Combines the commands stored into a string
		 *
		 * @access private
		 * @return string
		 */
		private function _combineCommands()
		{
			$command_string = '';
			foreach ($this->_commands as $command=>$argument)
			{
//				check for specific none combinable commands as they have specific places they have to go in the string
				switch($command)
				{
					case '-i' :
					case '-y' :
						break;
					default :
						$command_string .= trim($command.' '.$argument).' ';
				}
			}
			return trim($command_string);
		}

		/**
		 * Prepares the command for execution
		 *
		 * @access private
		 * @param string $path Path to the binary
		 * @param string $command Command string to execute
		 * @param string $args Any additional arguments
		 * @return string
		 */
		private function _prepareCommand($path, $command, $args='')
		{
	        if (!OS_WINDOWS || !preg_match('/\s/', $path))
	        {
	            return $path.' '.$command.' ' .$args;
	        }
	        return 'start /D "'.$path.'" /B '.$command.' '.$args;
		}

		/**
		 * Generates a unique id. Primarily used in jpeg to movie production
		 *
		 * @access public
		 * @param string $prefix
		 * @return string
		 */
		public function unique($prefix='')
		{
			return uniqid($prefix.time().'-');
		}

		/**
		 * Destructs ffmpeg and removes any temp files/dirs
		 * @access private
		 */
		function __destruct()
		{
//			loop through the temp files to remove first as they have to be removed before the dir can be removed
			if(!empty($this->_unlink_files))
			{
				foreach ($this->_unlink_files as $key=>$file)
				{
					@unlink($file);
				}
				$this->_unlink_files = array();
			}
//			loop through the dirs to remove
			if(!empty($this->_unlink_dirs))
			{
				foreach ($this->_unlink_dirs as $key=>$dir)
				{
					@rmdir($dir);
				}
				$this->_unlink_dirs = array();
			}
		}
	}

?>