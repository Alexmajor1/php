<?php
function autoload($class)
{
	if(strstr($class, 'framework'))
		require_once str_replace('framework', 'framework\\SDK', $class).'.php';
	else if(strstr($class, 'Controller'))
		require_once (__DIR__).'\\'.$class.'.php';
	else
		require_once $class.'.php';
}
spl_autoload_register('autoload', true, true);
?>