<?php
namespace console\commands;

class widget
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\widget.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.'\\..\\\..\\widgets\\'.$params[0].'Widget.php', $code);
		return 'widget '.$params[0].'Widget created';
	}
}
?>