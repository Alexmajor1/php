<?php
namespace console\commands;

class migrate
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\migration.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.'\\..\\\..\\migrations\\'.$params[0].'.php', $code);
		return 'migration '.$params[0].' created';
	}
	
	function execute($params)
	{
		$name = 'migrations\\'.$params[0];
		include __DIR__.'\\..\\..\\config\\settings.php';
		$migration = new $name($database);
		
		if($migration->create('InnoDB', 'utf8'))
			return $params[0].' migration complete';
		else
			return $params[0].' migration failed';
	}
}
?>