<?php
/*
 * Simplest Injector class
 * author Bumkaka
 * USE:
 *  Inj::some_name( &Instanse );   - Set
 *  Inj('some_name')->your_methods
 */
class Inj{
	protected static $_provider = array();

    public static function __callstatic( $method , $args){
        static::$_provider[ $method ] = $args[0];
    }

    public static function get( $name ){
        return static::$_provider[$name];
    }
}

function Inj( $name ){
    return Inj::get($name);
}

?>