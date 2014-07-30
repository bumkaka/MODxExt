<?php

/*
*
*   
*   Template::Load('add-popup')->parse($config)->get()
*   Template::getTpl('add-popup')->parse($config)->get()
*
*/

class Template extends Base{
	public  $template;
	public  $orig_template;
	function __construct( $tpl ){
		$this->orig_template = $this->template = $tpl;
		
		return $this;
	}


	static function Load( $options ){
		$name = is_array($options)? $options['name']:$options;

		if (class_exists(Config)){
			$PATH = Config::get('path'); 
			foreach($PATH as $value){
				$file = $value.$name.'.php'; 
				if (is_file( $file )){
					ob_start();
					require($file);
					$template = ob_get_contents();
					ob_end_clean();
					
					return new self($template);
				}
			}
		}
	}


	static function getTpl($tpl){
		global $modx;
		$template = $tpl;
		if (preg_match("~^@([^:\s]+)[:\s]+(.+)$~", $tpl, $match)) {
			$command = strtoupper($match[1]);
			$template = $match[2];
		}
		
		switch ($command) {
			case 'CODE': break;
			case 'FILE': $template=file_get_contents(MODX_BASE_PATH . $template); break;
			case 'CHUNK': $template = $modx->getChunk($template); break;
			case 'DOCUMENT': $template = $modx->getDocument($template, 'content', 'all'); break;
			case 'SELECT': $modx->db->getValue($modx->db->query("SELECT {$template}")); break;
			default:
			if (!($template = $modx->getChunk($tpl))) {
				$template = $tpl;
			}
		}

		return new self($template);
	}



	public function parseTpl( $tpl, $field, $lt , $gt){
		return Inj::modx()->parseText($tpl, $field, $lt , $gt);
	}




	public function reset(){
		$this->template = $this->orig_template;
		return $this;
	}

	public function parse( $field, $prefix ='', $suffix =''){
		if (!is_array($field)) return $this;
		
		
		foreach ($field as $key => $value){
			
			if (is_array($value)) {
				$this->parse($value, $prefix==''?$key.'.':$prefix.'.'.$key.'.' );
			} else {
				$this->template = str_replace('[+'.$prefix.$key.$suffix.'+]', $value, $this->template);
			}
			
		}
		
		return $this;
	}



	public function get( $clear = false ){
		if ($clear) {
			$this->template = static::clear( $this->template );
		} 
		
		return $this->template;
	}


	function __toString(){
		return $this->template;
	}

	/**
	*
	*/

	static function clear( $template){
		$matches =array();
		preg_match_all('~\[\+(.*?)\+\]~s', $template, $matches );
		if ($matches[0]) {
			$template = str_replace($matches[0], '', $template );
		}

		return $template;
	}
}

