<?php
namespace Resourse;

use Resourse\db as db;
use \ArrayAccess as ArrayAccess;

class Table  implements ArrayAccess {
	protected $_fields = array();
	private $_where = array();
	//private $_SELECT = '';
	private $_operand = 'SELECT';
	private $_col  = '*';
	static $modx;

	public static function table( $table ){
		return new self( $table );
	}

	public function __construct( $table ){
		$this->table = $table;
		return $this;
	}

	public function get($sql){
		$sql = is_numeric($sql)?' id = '.$sql:$sql;
		$this->_where = array();
		$this->_fields = array();
		$this->_where[] = $sql;
		return $this;
	}

	public function _and($sql){
		if ( empty($sql) ){
			$this->_where[] = 'AND';
		} else {
			$this->and()->where($sql);
		}
		return $this;
	}

	public function _or($sql){
		if ( empty($sql) ){
			$this->_where[] = 'OR';
		} else {
			$this->or()->where($sql);
		}
		return $this;
	}

	public function berween( $field, $range){
		$this->_where[] = $field.' BETWEEN '.$range[0].' AND '.$range[1];
	}


	public function where( $SQL ){
		$this->_where[] = $SQL;
	}


	public static function __callStatic( $method,   $params ){
		return new self::$metgod($params);
	}


	public function __call($method,   $params){
		$_call = '_'.$method;
		if (in_array( $method, array('or','and') ) ) 
			$this->$_call($params);

	}

	/*
	*  Return build SQL Query
	*/
	public function SQLQuery(){
		return $this->_buildQuery();

	}
	private function _where(){
		return 'WHERE '.implode(' ',$this->_where);
	}

	private function _table(){
		return 'FROM '.DB::tableName($this->table);
	}

	private function _buildQuery(){
		$this->_query = implode(' ',
				array(
					$this->_operand,
					$this->_col,
					$this->_table(),
					$this->_where()
					)
			);
		return $this->_query;
	}

	/*
	*
	*/

	private function _send(){
		$this->_buildQuery();
		$result = DB::query($this->_query);
		$row = DB::GetRow($result);
		foreach( $row as $key=>$value  ) {
			$this->_fields[$key] = $value;
		}
	}



	/* ArrayAssets */
	public function offsetExists($offset){
        return isset($this->_fields[$offset]);
    }

    public function offsetGet($offset){
    	if ($this->offsetExists($offset)){
    		return  $this->_fields[$offset];
    	} else {
    		$this->_send();
    		return $this->_fields[$offset];
    	}
    }

    public function offsetSet($offset, $value){
        if (is_null($offset)) {
            $this->_fields[] = $value;
        } else {
            $this->_fields[$offset] = $value;
        }
    }

    public function offsetUnset($offset){
        unset($this->_fields[$offset]);
    }

}

/*
	public function __tostring(){
		return $this->tpl;	
	}*/
