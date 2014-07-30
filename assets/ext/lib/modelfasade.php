<?php
/*
 *  Fasade to call paris Models like^
 *  UserPosts::find_many();
 *  and set correct table name with MODx EVO Prefix
 */
class ModelFasade{
	public static function __callstatic($method, $args){
		//@TODO: small feature :) to make super small fasade of models like: class Mails extends ModelFasades{}
		//$table =  Config::get('prefix').strtolower( get_called_class() );

        # Set correc child Model $_table with prefix
		$model = static::$model;
		//$model::$_table = Config::get('prefix').$model::$_table ;
		$model::$_table = inj('modx')->db->config['table_prefix'].$model::$_table ;

		return Model::factory($model)->$method( empty($args[0])?'':$args[0] );
	}
}