<?php
namespace console\commands;

class controller
{
	function create($params)
	{
		$code = file_get_contents(__DIR__.'\\templates\\controller.php');
		$code = str_ireplace('{name}', $params[0], $code);
		if(count($params) > 1) {
			$pages = '';
			foreach(array_slice($params, 1) as $page) {
				$tmpl = file_get_contents(__DIR__.'\\templates\\page.php');
				$pages .= str_ireplace('{name}', $page, $tmpl).PHP_EOL;
			}
			$code = str_ireplace('{pages}', $pages, $code);
		} else {
			$code = str_ireplace('\n\n{pages}', '', $code);
		}
		file_put_contents(__DIR__.'\\..\\\..\\controllers\\'.$params[0].'Controller.php', $code);
		return 'controller '.$params[0].'Controller created';
	}
}
?>