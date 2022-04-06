<?php
namespace console\commands;

class template
{
	function create($params)
	{
		$root_path = __DIR__.'\\..\\..\\templates\\'.$params[0];
		mkdir($root_path);
		file_put_contents($root_path.'\\main.html', '');
		mkdir($root_path.'\\kernel');
		file_put_contents($root_path.'\\kernel\\main.html', '');
		mkdir($root_path.'\\kernel\\cfg');
		file_put_contents($root_path.'\\kernel\\cfg\\main.php', '');
		mkdir($root_path.'\\layouts');
		file_put_contents($root_path.'\\layouts\\layout.html', '');
		mkdir($root_path.'\\Scripts');
		file_put_contents($root_path.'\\Scripts\\script.js', '');
		mkdir($root_path.'\\styles');
		file_put_contents($root_path.'\\styles\\style.css', '');
		mkdir($root_path.'\\styles\\modules');
		mkdir($root_path.'\\styles\\pages');
		file_put_contents($root_path.'\\styles\\pages\\main.css', '');
		
		mkdir($root_path.'\\modules');
		$dir = scandir(__DIR__.'\\..\\..\\framework\\modules');
		foreach($dir as $file) {
			if(!is_dir(__DIR__.'\\..\\..\\framework\\modules\\'.$file))
			copy(__DIR__.'\\..\\..\\framework\\modules\\'.$file, 
				$root_path.'\\modules\\'.$file);
		}
		
		foreach(array_slice($params, 1) as $page) {
			file_put_contents($root_path."\\$page.html", '');
			file_put_contents($root_path."\\kernel\\$page.html", '');
			file_put_contents($root_path."\\kernel\\cfg\\$page.php", '');
			file_put_contents($root_path."\\styles\\pages\\$page.css", '');
		}
		return 'template '.$params[0].' created';
	}
}
?>