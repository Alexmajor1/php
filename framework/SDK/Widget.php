<?php
namespace framework;

class Widget
{
	private $cfg;
	
	function __construct($cfg)
	{
		$this->cfg = $cfg;
	}
	
	function execute($mods)
	{
		$name = strtolower(str_ireplace('Widget', '',explode('\\', get_called_class())[1]));
		$mods[$name] = $this->cfg;
		return $mods;
	}
}
?>