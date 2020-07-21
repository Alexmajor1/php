<?php
namespace framework;

class Config
{
	private $src;
	private $buf;
	
	function __construct($src)
	{
		$this->src = $src;
	}
	
	function setSetting($key, $value)
	{
		$this->buf[$key] = $value;
	}
	
	function getSetting($key)
	{
		include ((__DIR__).'\\..\\..\\'.$this->src);
		
		if(!empty($this->buf) && key_exists($key, $this->buf))
		{
			return $this->buf[$key];
		} else if(isset($$key))
			return $$key;
		else
			return false;
	}
}
?>