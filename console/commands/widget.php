<?php
namespace console\commands;

class widget
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'widget.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'\..'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.$params[0].'Widget.php', $code);
		return 'widget '.$params[0].'Widget created';
	}
}
?>