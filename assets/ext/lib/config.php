<?php
/*
 *  Config Class Modx Ext
 *  v.0.1
 *  Author: Bumkaka
 *
 *
 *
 *
 *
 *
 *
 *
 */
class Config{
	static $setting = array();

    /*
    *  Coinfig::get() - return all settings as array
    *  Config::get('name')
    *  Config::name   - super get settings.
    */
	public static function get( $name = '' ){
        if (empty($name)) return static::$setting;
		return static::$setting[$name];
	}

    /*
     *  Config::set( 'SettingName' , SettingValue  - string/array );
     *  Config::set( array() );
     */
	public static function set( $name, $value = ''){
        if ( is_array( $name )){
            static::$setting = array_merge( static::$setting , $name );
            return true;
        } elseif( is_array( static::$setting[$name] ) ){
            static::$setting[$name] = array_merge( static::$setting[$name] , (array)$value );
             return true;
        } else {
            static::$setting[ $name ] = $value;
        }
    }

    
    public static function __callstatic( $method, $args){
         if (empty($args[0])){
            return static::$setting[ $method ];
        } elseif( !empty($args[1]) ){
            static::$setting[ $method ][$args[0]] = $args[1];
        } else {
            static::set($method, $args[0]);
        }
    }
}
