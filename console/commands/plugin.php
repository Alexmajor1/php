<?php
namespace console\commands;

class plugin
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\plugin.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.'\\..\\\..\\plugins\\'.$params[0].'.php', $code);
		return 'plugin '.$params[0].' created';
	}
}
?>