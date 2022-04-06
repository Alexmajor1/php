<?php
namespace console;

class console
{
	private $cmd;
	private $func;
	private $params;
	
	function __construct($args)
	{
		$this->cmd = $args[1];
		if($args[1] != 'help')
			$this->cmd = 'console\\commands\\'.$args[1];
		
		if(count($args) > 2)
			$this->func = $args[2];
		
		if($args[1] != 'help' && method_exists(new $this->cmd, $this->func))
			$this->params = array_slice($args, 3);
		elseif($args[1] != 'help')
			$this->params = array_slice($args, 2);
	}
	
	function execute()
	{
		if($this->cmd != 'help'){
			$cmd = new $this->cmd();
			$func = $this->func;
		}
		
		if($this->cmd == 'help')
			return $this->help();
		elseif(method_exists($cmd, $func))
			return $cmd->$func($this->params);
		else
			return $cmd->execute($this->params);
	}
	
	function help()
	{
		$return = 'Command: cli [command] [args...]'.PHP_EOL;
		$return = 'Commands:'.PHP_EOL;
		
		foreach(scandir(__DIR__.'\\commands\\') as $file) {
			if(!is_dir($file)){
				$return .= ' '.explode('.', $file)[0].PHP_EOL;
				foreach(get_class_methods('console\\commands\\'.explode('.', $file)[0]) as $method)
					$return .= "\t$method".PHP_EOL;
			}
		}
		
		return $return;
	}
}
?>