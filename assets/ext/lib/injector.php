<?php

class injector implements ArrayAccess {{
	protected static $_provider = array();


	/* ArrayAssets */
	public function offsetExists($offset){
        return isset($this->_provider[$offset]);
    }

    public function offsetGet($offset){
        return $this->offsetExists($offset) ? $this->_provider[$offset] : null;
    }

    public function offsetSet($offset, $value){
        if (is_null($offset)) {
            $this->_provider[] = $value;
        } else {
            $this->_provider[$offset] = $value;
        }
    }

    public function offsetUnset($offset){
        unset($this->_provider[$offset]);
    }
}


?>