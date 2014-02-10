<?php

class Config{
	static $setting = array();

	public static function get( $name ){
		return static::$setting[$name];
	}
	
	public static function set( $name, $value ){
		static::$setting[ $name ] = $value;
	}

	public static function load( $name, $file){
		$array =  require $file;
		static::set( $name , $array);
	}
}



?>