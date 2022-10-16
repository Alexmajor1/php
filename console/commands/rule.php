<?php
namespace console\commands;

class rule
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'rule.php');
		$code = str_ireplace('{name}', $params[0], $code);
		file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rules'.DIRECTORY_SEPARATOR.''.$params[0].'Rule.php', $code);
		return 'rule '.$params[0].'Rule created';
	}
}
?>