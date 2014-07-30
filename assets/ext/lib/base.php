<?php 

class Base{
	static $instance;
	/*
	static function this() {
		if (static::$instance === null) static::$instance = new static();
		return static::$instance;
	}*/


	static function this() {
		if (static::$instance === null) static::$instance = new static();
		return static::$instance;
	}

	
}