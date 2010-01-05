<?php

	/**
	 * flv
	 * 
	 * Created by  on 2008-03-03.
	 * Copyright (c) 2008 __MyCompanyName__. All rights reserved.
	 */

	class VideoTo
	{
		
		private static $_log_files 			= array();
		private static $_ffmpeg 			= array();
		private static $_error_messages 	= array();
		private static $_commands 			= array();
		private static $_outputs 			= array();
		
		public static function FLV($file, $options=array(), $target_extension='flv')
		{
// 			merge the options with the defaults
			$options = array_merge(array(
				'temp_dir'					=> '/tmp', 
				'width'						=> 320, 
				'height'					=> 240,
				'frequency'					=> 44100, 
				'audio_bitrate'				=> 64, 
				'video_bitrate'				=> 1200, 
				'ratio'						=> ffmpeg::RATIO_STANDARD, 
				'frame_rate'				=> 29.7, 
				'output_dir'				=> null,	// this doesn't have to be set it can be automatically retreived from 'output_file'
				'output_file'				=> '#filename.#ext', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'use_multipass'				=> false, 
				'generate_log'				=> true,
				'log_directory'				=> null,
				'die_on_error'				=> false,
				'overwrite_mode'			=> ffmpeg::OVERWRITE_FAIL
			), $options);
			
// 			start ffmpeg class
			$ffmpeg = new ffmpeg($options['temp_dir']);
			$ffmpeg->on_error_die = $options['die_on_error'];
// 			get the output directory
			if($options['output_dir'])
			{
				$output_dir 	= $options['output_dir'];
			}
			else
			{
				$output_dir		= dirname($options['output_file']);
				$output_dir		= $output_dir == '.' ? dirname($file) : $output_dir;
			}
// 			get the filename parts
			$filename 			= basename($file);
			$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
// 			get the output filename
			$output_filename	= str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_file']));
		
// 			set the input file
			$ok = $ffmpeg->setInputFile($file);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
		
// 			set the output dimensions
			$ffmpeg->setVideoAspectRatio($options['ratio']);
			$ffmpeg->setVideoOutputDimensions($options['width'], $options['height']);
			$ffmpeg->setVideoBitRate($options['video_bitrate']);
			$ffmpeg->setVideoFrameRate($options['frame_rate']);
		
// 			set the video to be converted to flv
			$ffmpeg->setFormatToFLV($options['frequency'], $options['audio_bitrate']);
		
// 			set the output details and overwrite if nessecary
			$ok = $ffmpeg->setOutput($output_dir, $output_filename, $options['overwrite_mode']);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
		
// 			execute the ffmpeg command using multiple passes and log the calls and ffmpeg results
			$result = $ffmpeg->execute($options['use_multipass'], $options['generate_log']);
			array_push(self::$_commands, $ffmpeg->getLastCommand());
		
// 			check the return value in-case of error
			if($result !== ffmpeg::RESULT_OK)
			{
// 				move the log file to the log directory as something has gone wrong
				if($options['generate_log'])
				{
					$log_dir = $options['log_directory'] ? $options['log_directory'] : $output_dir;
					$ffmpeg->moveLog($log_dir.$filename_minus_ext.'.log');
					array_push(self::$_log_files, $log_dir.$filename_minus_ext.'.log');
				}
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return $result;
			}
			
			array_push(self::$_outputs, $ffmpeg->getLastOutput());
			
// 			reset 
			$ffmpeg->reset();
			
			return $result;
		}
		
		public static function PSP($file, $options=array(), $target_extension='mp4')
		{
// 			merge the options with the defaults
			$options = array_merge(array(
				'temp_dir'					=> '/tmp', 
				'width'						=> 368, 
				'height'					=> 192,
				'frequency'					=> 44100, 
				'audio_bitrate'				=> 128, 
				'video_bitrate'				=> 1200, 
				'ratio'						=> ffmpeg::RATIO_STANDARD, 
				'frame_rate'				=> 29.7, 
				'output_dir'				=> null,	// this doesn't have to be set it can be automatically retreived from 'output_file'
				'output_file'				=> '#filename.#ext', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'output_title'				=> '#filename', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'use_multipass'				=> false, 
				'generate_log'				=> true,
				'log_directory'				=> null,
				'die_on_error'				=> false,
				'overwrite_mode'			=> ffmpeg::OVERWRITE_FAIL
			), $options);
			
// 			start ffmpeg class
			$ffmpeg = new ffmpeg($options['temp_dir']);
			$ffmpeg->on_error_die = $options['die_on_error'];
// 			get the output directory
			if($options['output_dir'])
			{
				$output_dir 	= $options['output_dir'];
			}
			else
			{
				$output_dir		= dirname($options['output_file']);
				$output_dir		= $output_dir == '.' ? dirname($file) : $output_dir;
			}
// 			get the filename parts
			$filename 			= basename($file);
			$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
// 			get the output filename
			$output_filename	= str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_file']));
		
// 			set the input file
			$ok = $ffmpeg->setInputFile($file);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			$ffmpeg->setFormat(ffmpeg::FORMAT_PSP);
			
			$ffmpeg->setAudioSampleFrequency($options['frequency']);
			$ffmpeg->setAudioBitRate($options['audio_bitrate']);
// 			$ffmpeg->addCommand('-acodec', 'libfaac');
// 			$ffmpeg->addCommand('-acodec', 'mp3');
			
			$ffmpeg->setVideoFormat(ffmpeg::FORMAT_MPEG4);
			$ffmpeg->setVideoAspectRatio($options['ratio']);
			$ffmpeg->setVideoOutputDimensions($options['width'], $options['height']);
			$ffmpeg->setVideoBitRate($options['video_bitrate']);
			$ffmpeg->setVideoFrameRate($options['frame_rate']);
			$ffmpeg->addCommand('-flags', 'loop');
			$ffmpeg->addCommand('-trellis', '2');
			$ffmpeg->addCommand('-partitions', 'parti4x4+parti8x8+partp4x4+partp8x8+partb8x8');
			$ffmpeg->addCommand('-coder', '1');
			$ffmpeg->addCommand('-mbd', '2');
			$ffmpeg->addCommand('-cmp', '2');
			$ffmpeg->addCommand('-subcmp', '2');
			$ffmpeg->addCommand('-title', str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_title'])));
		
// 			set the output details and overwrite if nessecary
			$ok = $ffmpeg->setOutput($output_dir, $output_filename, $options['overwrite_mode']);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			
// 			execute the ffmpeg command using multiple passes and log the calls and ffmpeg results
			$result = $ffmpeg->execute($options['use_multipass'], $options['generate_log']);
			array_push(self::$_commands, $ffmpeg->getLastCommand());
		
// 			check the return value in-case of error
			if($result !== ffmpeg::RESULT_OK)
			{
// 				move the log file to the log directory as something has gone wrong
				if($options['generate_log'])
				{
					$log_dir = $options['log_directory'] ? $options['log_directory'] : $output_dir;
					$ffmpeg->moveLog($log_dir.$filename_minus_ext.'.log');
					array_push(self::$_log_files, $log_dir.$filename_minus_ext.'.log');
				}
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return $result;
			}
			
			array_push(self::$_outputs, $ffmpeg->getLastOutput());
			
// 			reset 
			$ffmpeg->reset();
			
			return $result;
		}
		
		public static function iPod($file, $options=array(), $target_extension='mp4')
		{
// 			merge the options with the defaults
			$options = array_merge(array(
				'temp_dir'					=> '/tmp', 
				'width'						=> 320, 
				'height'					=> 240,
				'frequency'					=> 44100, 
				'audio_bitrate'				=> 128, 
				'video_bitrate'				=> 1200, 
				'ratio'						=> ffmpeg::RATIO_STANDARD, 
				'frame_rate'				=> 29.7, 
				'output_dir'				=> null,	// this doesn't have to be set it can be automatically retreived from 'output_file'
				'output_file'				=> '#filename.#ext', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'output_title'				=> '#filename', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'use_multipass'				=> false, 
				'generate_log'				=> true,
				'log_directory'				=> null,
				'die_on_error'				=> false,
				'overwrite_mode'			=> ffmpeg::OVERWRITE_FAIL
			), $options);
			
// 			start ffmpeg class
			$ffmpeg = new ffmpeg($options['temp_dir']);
			$ffmpeg->on_error_die = $options['die_on_error'];
// 			get the output directory
			if($options['output_dir'])
			{
				$output_dir 	= $options['output_dir'];
			}
			else
			{
				$output_dir		= dirname($options['output_file']);
				$output_dir		= $output_dir == '.' ? dirname($file) : $output_dir;
			}
// 			get the filename parts
			$filename 			= basename($file);
			$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
// 			get the output filename
			$output_filename	= str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_file']));
		
// 			set the input file
			$ok = $ffmpeg->setInputFile($file);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			$ffmpeg->setFormat(ffmpeg::FORMAT_MP4);
			
			$ffmpeg->setAudioSampleFrequency($options['frequency']);
			$ffmpeg->setAudioBitRate($options['audio_bitrate']);
// 			$ffmpeg->addCommand('-acodec', 'libfaac');
// 			$ffmpeg->addCommand('-acodec', 'mp3');
			
			$ffmpeg->setVideoFormat(ffmpeg::FORMAT_MPEG4);
			$ffmpeg->setVideoAspectRatio($options['ratio']);
			$ffmpeg->setVideoOutputDimensions($options['width'], $options['height']);
			$ffmpeg->setVideoFrameRate($options['frame_rate']);
			$ffmpeg->addCommand('-mbd', '2');
			$ffmpeg->addCommand('-flags', '+4mv+trell');
			$ffmpeg->addCommand('-aic', '2');
			$ffmpeg->addCommand('-cmp', '2');
			$ffmpeg->addCommand('-subcmp', '2');
			
			$ffmpeg->addCommand('-title', str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_title'])));
		
// 			set the output details and overwrite if nessecary
			$ok = $ffmpeg->setOutput($output_dir, $output_filename, $options['overwrite_mode']);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			
// 			execute the ffmpeg command using multiple passes and log the calls and ffmpeg results
			$result = $ffmpeg->execute($options['use_multipass'], $options['generate_log']);
			array_push(self::$_commands, $ffmpeg->getLastCommand());
		
// 			check the return value in-case of error
			if($result !== ffmpeg::RESULT_OK)
			{
// 				move the log file to the log directory as something has gone wrong
				if($options['generate_log'])
				{
					$log_dir = $options['log_directory'] ? $options['log_directory'] : $output_dir;
					$ffmpeg->moveLog($log_dir.$filename_minus_ext.'.log');
					array_push(self::$_log_files, $log_dir.$filename_minus_ext.'.log');
				}
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return $result;
			}
			
			array_push(self::$_outputs, $ffmpeg->getLastOutput());
			
// 			reset 
			$ffmpeg->reset();
			
			return $result;
		}
		
		public static function gif($file, $options=array(), $target_extension='gif')
		{
// 			merge the options with the defaults
			$options = array_merge(array(
				'temp_dir'					=> '/tmp', 
				'width'						=> 320, 
				'height'					=> 240,
				'ratio'						=> ffmpeg::RATIO_STANDARD, 
				'frame_rate'				=> 1, 
				'loop_output'				=> 0,	// 0 will loop endlessly
				'output_dir'				=> null,	// this doesn't have to be set it can be automatically retreived from 'output_file'
				'output_file'				=> '#filename.#ext', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'output_title'				=> '#filename', 	// you can use #filename to automagically hold the filename and #ext to automagically hold the target format extension
				'use_multipass'				=> false, 
				'generate_log'				=> true,
				'log_directory'				=> null,
				'die_on_error'				=> false,
				'overwrite_mode'			=> ffmpeg::OVERWRITE_FAIL
			), $options);
			
// 			start ffmpeg class
			$ffmpeg = new ffmpeg($options['temp_dir']);
			$ffmpeg->on_error_die = $options['die_on_error'];
// 			get the output directory
			if($options['output_dir'])
			{
				$output_dir 	= $options['output_dir'];
			}
			else
			{
				$output_dir		= dirname($options['output_file']);
				$output_dir		= $output_dir == '.' ? dirname($file) : $output_dir;
			}
// 			get the filename parts
			$filename 			= basename($file);
			$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
// 			get the output filename
			$output_filename	= str_replace(array('#filename', '#ext'), array($filename_minus_ext, $target_extension), basename($options['output_file']));
		
// 			set the input file
			$ok = $ffmpeg->setInputFile($file);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			$ffmpeg->setFormat(ffmpeg::FORMAT_GIF);
			
			$ffmpeg->disableAudio();
			
			$ffmpeg->setVideoAspectRatio($options['ratio']);
			$ffmpeg->setVideoOutputDimensions($options['width'], $options['height']);
			$ffmpeg->setVideoFrameRate($options['frame_rate']);
			$ffmpeg->addCommand('-loop_output', $options['loop_output']);
			
// 			set the output details and overwrite if nessecary
			$ok = $ffmpeg->setOutput($output_dir, $output_filename, $options['overwrite_mode']);
// 			check the return value in-case of error
			if(!$ok)
			{
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return false;
			}
			
// 			execute the ffmpeg command using multiple passes and log the calls and ffmpeg results
			$result = $ffmpeg->execute($options['use_multipass'], $options['generate_log']);
			array_push(self::$_commands, $ffmpeg->getLastCommand());
		
// 			check the return value in-case of error
			if($result !== ffmpeg::RESULT_OK)
			{
// 				move the log file to the log directory as something has gone wrong
				if($options['generate_log'])
				{
					$log_dir = $options['log_directory'] ? $options['log_directory'] : $output_dir;
					$ffmpeg->moveLog($log_dir.$filename_minus_ext.'.log');
					array_push(self::$_log_files, $log_dir.$filename_minus_ext.'.log');
				}
				$ffmpeg->reset();
				array_push(self::$_error_messages, $ffmpeg->getLastError());
				return $result;
			}
			
			array_push(self::$_outputs, $ffmpeg->getLastOutput());
			
// 			reset 
			$ffmpeg->reset();
			
			return $result;
		}
		
		public static function getOutput($all=false)
		{
			return $all ? self::$_outputs : self::$_outputs[count(self::$_outputs)-1];
		}
		
		public static function getCommand($all=false)
		{
			return $all ? self::$_commands : self::$_commands[count(self::$_commands)-1];
		}
		
		public static function getError($all=false)
		{
			return $all ? self::$_error_messages : self::$_error_messages[count(self::$_error_messages)-1];
		}
		
		public static function getLogFile($all=false)
		{
			return $all ? self::$_log_files : self::$_log_files[count(self::$_log_files)-1];
		}
		
	}