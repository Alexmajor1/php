<?php
namespace console\commands;

class rule
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\rule.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.'\\..\\\..\\rules\\'.$params[0].'Rule.php', $code);
		return 'rule '.$params[0].'Rule created';
	}
}
?>