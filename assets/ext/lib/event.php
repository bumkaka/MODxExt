<?php

/*
 *  Event Class Modx Ext
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
class Event{
	static $events = array();

    
    /*
     *  Event::set( 'SettingName' , SettingValue  - string/array );
     *  Event::set( array() );
     */
	public static function set( $name, $value = ''){
        if ( is_array( $name )){
            static::$events = array_merge( static::$events , $name );
            return true;
        } elseif( is_array( static::$events[$name] ) ){
            static::$events[$name] = array_merge( static::$events[$name] , (array)$value );
             return true;
        } else {
            static::$events[ $name ] = $value;
        }
    }

  
    public static function __callstatic( $method, $args){
    	try {
    		if (is_callable( static::$events[ $method ] )){
    			call_user_func(static::$events[ $method ], $args);
    		} else {
    			throw new Exception('Event "<strong>'.$method .'</strong>" does not exist<br/>', 1);	
    		}
    	} 
    	catch(Exception $e){

    		echo $e->getMessage();
    	}
    }
}