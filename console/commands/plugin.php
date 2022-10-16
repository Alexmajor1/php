<?php
namespace console\commands;

class plugin
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'plugin.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.''.$params[0].'.php', $code);
		return 'plugin '.$params[0].' created';
	}
}
?>