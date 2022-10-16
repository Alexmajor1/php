<?php
namespace console\commands;

class template
{
	function create($params)
	{
		$root_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.''.$params[0];
		mkdir($root_path);
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'main.html', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'kernel');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'main.html', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'cfg');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'cfg'.DIRECTORY_SEPARATOR.'main.php', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'layouts');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'layout.html', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'Scripts');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'Scripts'.DIRECTORY_SEPARATOR.'script.js', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'styles');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'styles'.DIRECTORY_SEPARATOR.'style.css', '');
		mkdir($root_path.DIRECTORY_SEPARATOR.'styles'.DIRECTORY_SEPARATOR.'modules');
		mkdir($root_path.DIRECTORY_SEPARATOR.'styles'.DIRECTORY_SEPARATOR.'pages');
		file_put_contents($root_path.DIRECTORY_SEPARATOR.'styles'.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.'main.css', '');
		
		mkdir($root_path.DIRECTORY_SEPARATOR.'modules');
		$dir = scandir(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'modules');
		foreach($dir as $file) {
			if(!is_dir(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$file))
			copy(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$file, 
				$root_path.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$file);
		}
		
		foreach(array_slice($params, 1) as $page) {
			file_put_contents($root_path.DIRECTORY_SEPARATOR.'$page.html', '');
			file_put_contents($root_path.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'$page.html', '');
			file_put_contents($root_path.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'cfg'.DIRECTORY_SEPARATOR.'$page.php', '');
			file_put_contents($root_path.DIRECTORY_SEPARATOR.'styles'.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR.'$page.css', '');
		}
		return 'template '.$params[0].' created';
	}
}
?>