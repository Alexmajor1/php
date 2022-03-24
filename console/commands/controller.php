<?php
namespace console\commands;

class controller
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\controller.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.'\\..\\\..\\controllers\\'.$params[0].'Controller.php', $code);
		return 'controller '.$params[0].'Controller created';
	}
}
?>