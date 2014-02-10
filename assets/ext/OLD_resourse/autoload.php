<?php

	class Autoloader
		{
			private static $file;
			public static $log;

			//@TODO:
			public function load( $name){
			
			}
			
			public static function loadcore($className)
			{
				$pathParts = explode('\\', strtolower($className));
				$file = dirname(__FILE__).'\\'.implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
				if (is_file( $file )){
					self::$file = $file;
					require self::$file;
				}
			}
			
			
			public static function _include($className)
			{
				
				$pathParts = explode('\\', strtolower($className));
				$className = end($pathParts);
				
				$PATH = Config::get('path'); 
				foreach($PATH as $value){
					$file = dirname(__FILE__).$value.$className.'.php';
					if (is_file( $file )){
						self::$file = $file;
						require_once(self::$file);
						return true;
					}
				}
				
				
				
				require_once(self::$file);
			}
		 
			public static function Log( $class ){
				self::_include( $class );
				static::$log = 'Class '.$className.' was loaded from '.self::$file;
			}
		}

	spl_autoload_register(array('Autoloader', 'loadcore'));
	spl_autoload_register(array('Autoloader', 'Log'));
?>