<?php

require_once('xkcdcomic.php');

class xkcd {
    private $cache = [];
	private $cacheIndex = [];
	private $latestId = 0;
	public $cacheLimit = 50;
	const URL = 'http://xkcd.com';
	
	function __construct() {
		$this->refresh();
	}
	
	public function refresh() {
		$raw = json_decode(file_get_contents(self::URL.'/info.0.json'), true);
		$comic = new xkcdcomic($raw, $this);
		$this->addcache($comic);
		$this->latestId = $comic->num;
	}
	
	public function get(int $num) {
		if($num > $this->latestId || $num < 1) {
            throw new Exception('Invalid comic ID.');
		} else {
			if(array_key_exists($num, $this->cache)) {
			
				return $this->cache[$num];
			} else {
				$raw = json_decode(file_get_contents(self::URL.'/'.$num.'/info.0.json'), true);
				$comic = new xkcdcomic($raw, $this);
				$this->addcache($comic);
			
				return $comic;
			}
		}
	}
	
	public function random() {
		$rand = rand(1, $this->latestId);
		
		return $this->get($rand);
	}
    
    public function latest() {
		
		return $this->get($this->latestId);
    }
	
	private function addcache(xkcdcomic $comic) {
		if(array_key_exists($comic->num, $this->cache)){
			$this->cache[$comic->num] = $comic;
		} else {
			while(count($this->cache) >= $this->cacheLimit) {
				// foreach($this->cacheIndex as $key => $num) break;
				unset($this->cache[$num]);
				unset($this->cacheIndex[$key]);
			}
			$this->cache[$comic->num] = $comic;
			$this->cacheIndex[] = $comic->num;
		}
	}
	
	public function clearcache() {
		$this->cache = [];
		$this->cacheIndex = [];
	}
}