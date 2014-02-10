<?php

class ModelFasade{
	public static function __callstatic($method, $args){
		//@TODO: small feature :) to make super small fasade of models like: class Mails extends ModelFasades{}
		//$table =  Config::get('prefix').strtolower( get_called_class() );
		$model = static::$model;
		$model::$_table = Config::get('prefix').$model::$_table ;
		return Model::factory($model)->$method( empty($args)?'':$args[0] );
	}
}