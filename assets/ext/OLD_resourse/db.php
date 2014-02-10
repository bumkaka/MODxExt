<?php
namespace Resourse;

class db{
	static $modx;
	public function __construct( $modx){
		self::$modx = $modx;

		//var_dump($this->modx);
	}

	public static function tableName( $table ){
		return self::$modx->getFullTableName($table);
	}


	static function query( $sql ){
		return self::$modx->db->query($sql);
	}

	static function getRow( $result ){
		return self::$modx->db->getRow( $result );
	}


}