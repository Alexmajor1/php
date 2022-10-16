<?php
namespace console\commands;

class model
{
	function create($params)
	{
		if($params[0] == 'editor'){
			$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'model_editor.php');
			$code = str_ireplace('{name}', $params[1], $code);
			if(count($params) > 2) {
				$fileds = '';
				foreach(array_slice($params, 2) as $field) {
					$tmpl = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'field.php');
					$fields .= str_ireplace('{name}', $field, $tmpl).PHP_EOL;
				}
				$code = str_ireplace('{fields}', $fields, $code);
			} else {
				$code = str_ireplace('\n\n{pages}', '', $code);
			}
			file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.'editors'.DIRECTORY_SEPARATOR.$params[1].'Editor.php', $code);
			return 'model editor '.$params[1].'Editor created';
		} else {
			$code = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'model.php');
			$code = str_ireplace('{name}', $params[0], $code);
			file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.$params[0].'.php', $code);
			return 'model '.$params[0].' created';
		}
	}
}
?>