<?php
/*
 *  Config Class Modx Ext
 *  v.0.1
 *  Author: Bumkaka
 */
class Config{
	static $setting = array();

	public static function get( $name ){
		return static::$setting[$name];
	}

    /*
     *  Config::set( 'SettingName' , SettingValue  - string, array() );
     *  Config::set( array() );
     */
	public static function set( $name, $value = ''){
        if ( is_array( $name )){
            static::$setting = array_merge( static::$setting , $name );
        } elseif( is_array( $value )){
            static::$setting[$name] = $value;
        } else {
		    static::$setting[ $name ] = $value;
        }
	}

    /*
     *  @TODO: Remove this stupid method 8)
     */
	public static function load( $name, $file){
		$array =  require $file;
		static::set( $name , $array);
	}

    public static function __callstatic( $method, $args){
         if (empty($args[0])){
            return static::$setting[ $method ];
        }
        static::$setting[ $method ][$args[0]] = $args[1];
    }
}
