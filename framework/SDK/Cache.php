<?php
namespace framework;

class Cache
{
	private static $instances;
	private $cache_dir;
	private $expired;
	
	private function __construct($cfg)
	{
		$this->cache_dir = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').DIRECTORY_SEPARATOR.$cfg->GetSetting('cache')['dir'];
		$this->expired = $cfg->GetSetting('cache')['expired'];
	}
	
	protected function __clone(){}
	
	public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
	
	public static function getInstance($ConData = [])
	{
		$subclass = static::class;
		
        if (!isset(self::$instances[$subclass]))
			self::$instances[$subclass] = new static($ConData);
		
		return self::$instances[$subclass];
	}
	
	function append($key, $value)
	{
		$path = $this->cache_dir.DIRECTORY_SEPARATOR.$key.'.json';
		return file_put_contents($path, json_encode($value), LOCK_EX);
	}
	
	function read($key)
	{
		$path = $this->cache_dir.DIRECTORY_SEPARATOR.$key.'.json';
		
		if(file_exists($path)){
			return json_decode(file_get_contents($path), true);
		} else {
			return false;
		}
	}
	
	function erase($key)
	{
		return unlink($this->cache_dir.DIRECTORY_SEPARATOR.$key.'.json');
	}
	
	function clear($validate=false)
	{
		$path = $this->cache_dir.DIRECTORY_SEPARATOR.'*';
		foreach (glob($path) as $file) {
			if($validate){
				$lifetimeCreate = time()-filectime($file);
				$lifetimeModify = time()-filemtime($file);
				if(($lifetimeCreate > $this->expired) || ($lifetimeModify > $this->expired))
					unlink($file);
			}else
				unlink($file);
		}
	}
}
?>