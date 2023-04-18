<?php
function autoload($class)
{
	$class = str_replace('\\', '/', $class);
	if(strstr($class, 'framework'))
		require_once str_replace('framework', 'framework'.DIRECTORY_SEPARATOR.'SDK', $class).'.php';
	else if(strstr($class, 'Controller'))
		require_once (__DIR__).DIRECTORY_SEPARATOR.$class.'.php';
	else
		require_once $class.'.php';
}
spl_autoload_register('autoload', true, true);
?>
