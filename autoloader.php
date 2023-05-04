<?php
function autoload($class)
{
	$class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	if(!class_exists($class))
		if(strstr($class, 'framework')){
			require_once str_replace('framework', 'framework'.DIRECTORY_SEPARATOR.'SDK', $class).'.php';
		}elseif(file_exists($class.'.php'))
			require_once $class.'.php';
}
spl_autoload_register('autoload', true, true);
?>
