<?php
namespace console\commands;

class migrate
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'migration.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$params[0].'.php', $code);
		return 'migration '.$params[0].' created';
	}
	
	function execute($params)
	{
		$name = 'migrations'.DIRECTORY_SEPARATOR.$params[0];
		include __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'settings.php';
		$migration = new $name($database);
		
		if($migration->create('InnoDB', 'utf8'))
			return $params[0].' migration complete';
		else
			return $params[0].' migration failed';
	}
}
?>