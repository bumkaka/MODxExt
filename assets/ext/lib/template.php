<?php

/*
*
*   
Config::set('path', array( dirname(__FILE__).'/views/'));
Config::set('Template_prefix_before','{');
Config::set('Template_prefix_after','}');


We have: file "news.php"
<div>
	<div class="widget_head"><h2>{TILTE}</h2></div>
	
	<div class="widget_body">
		<ul>
			{BLOCK list}
				<li>
					<h3>{TITLE}</h3>
					<p>{INTROTEXT}</p>
				</li>
			{/BLOCK}
		<ul>
	</div>

</div>


USE:
1)  echo Template::Load('news')->parse( array('title'=>'This is a cool title') )->get();

2)  $news = Template::Load('news');
	$block_news = $news->getBlock('list');

	

   Template::getTpl('add-popup')->parse($config)->get()
*
*/
if(!class_exists('Base')){
	class Base{
		static $instance;
		static function this() {
			if (static::$instance === null) static::$instance = new static();
			return static::$instance;
		}
	}
}




class Template extends Base{
	public $template;
	public $blocks = array();
	public  $orig_template;
	function __construct( $tpl ){
		preg_match_all('~\{\s*block\s*([^\}]*)\}(.*)\{\/\s*block\s*\}~isU', $tpl, $matches );

		if ($matches[0]){
			foreach($matches[0] as $key=>$value){
				$block[ trim($matches[1][$key]) ] = $matches[2][$key];
			}
			$this->blocks = $block;
		}
	
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


	public function getBlock( $name ){
		return new self( $this->blocks[$name] );
	}
	
	
	public function parseTpl( $tpl, $field, $lt , $gt){
		return Inj::modx()->parseText($tpl, $field, $lt , $gt);
	}




	public function reset(){
		$this->template = $this->orig_template;
		return $this;
	}

	public function parse( $field, $prefix ='', $suffix =''){
		$_b = Config::get('Template_prefix_before');
		$_a = Config::get('Template_prefix_after');
		$_b = empty($_b)? '[+' : $_b;
		$_a = empty($_a)? '+]' : $_a;
		if (!is_array($field)) return $this;
		foreach ($field as $key => $value){
			if (is_array($value)) {
				$this->parse($value, $prefix==''?$key.'.':$prefix.'.'.$key.'.' );
			} else {
				if( array_key_exists($key, $this->blocks) ){
					preg_match_all('~\{\s*block\s*'.preg_quote($key).'\s*\}(.*)\{\/\s*block\s*\}~isU', $this->template, $matches );
					foreach($matches[0] as $k=>$v){
						$this->template = str_replace($v, $value, $this->template );
					}
				}
				$this->template = str_replace( $_b.$prefix.$key.$suffix.$_a, $value, $this->template);
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

	static function clear( $tpl){
		/* clear all {BLOCK}*/
		preg_match_all('~\{\s*block\s*([^\}]*)\}(.*)\{\/\s*block\s*\}~isU', $tpl, $matches );
		if ($matches[0]){
			foreach($matches[0] as $key=>$value){
				$tpl = str_replace($value, '', $tpl );
			}
		}
		
		$matches =array();
		$pr_b[0]= preg_quote( Config::get('Template_prefix_before') ); 
		$pr_b[1]= preg_quote( Config::get('Template_prefix_after') ); 
		
		preg_match_all('~'.$pr_b[0].'(.*?)'.$pr_b[1].'~s', $tpl, $matches );
		if ($matches[0]) {
			$tpl = str_replace($matches[0], '', $tpl );
		}
		return $tpl;
	}
}

