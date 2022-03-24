<?php
namespace console;

class console
{
	private $cmd;
	private $func;
	private $params;
	
	function __construct($args)
	{
		$this->cmd = 'console\\commands\\'.$args[1];
		$this->func = $args[2];
		$this->params = array_slice($args, 3);
	}
	
	function execute()
	{
		$cmd = new $this->cmd();
		$func = $this->func;
		return $cmd->$func($this->params);
	}
}
?>