<?php

class xkcdcomic {
    private $raw = array();
	private $api = null;
    public $url = '';
    
	function __construct($raw, &$api){
		$this->raw = $raw;
		$this->api = &$api;
        $this->url = 'http://xkcd.com/'.$this->num;
	}
	
	function __get($var){
		if (array_key_exists($var, $this->raw)) {
		    return $this->raw[$var];
		}
		$trace = debug_backtrace();
		trigger_error(
			'Undefined property via __get(): ' . $name .
			' in ' . $trace[0]['file'] .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
		//End fork
	}
	
	function next(){
		return $this->api->get($this->num + 1);
	}
	
	function prev(){
		return $this->api->get($this->num - 1);
	}
}