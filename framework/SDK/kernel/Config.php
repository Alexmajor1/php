<?php
namespace framework\kernel;

class Config
{
	private static $instances;
	private $src;
	private $buf;
	
	protected function __construct($src)
	{
		$this->src = [$src];
	}
	
	protected function __clone(){}
	
	public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
	
	public static function getInstance($src = '')
	{
		$subclass = static::class;
        if (!isset(self::$instances[$subclass]))
			self::$instances[$subclass] = new static($src);
		
		return self::$instances[$subclass];
	}
	
	function addSource($src)
	{
		$this->src[] = $src;
	}
	
	function changeSource($src)
	{
		$this->src[-1] = $src;
	}
	
	function setSetting($key, $value)
	{
		$this->buf[$key] = $value;
	}
	
	function getSetting($key)
	{
		if(!empty($this->buf) && key_exists($key, $this->buf))
			return $this->buf[$key];
		
		foreach($this->src as $file)
		{
			include $file;
			
			if(!isset($$key)) continue;
		}
		
		if(isset($$key)) return $$key;
		else return false;
	}
}
?>