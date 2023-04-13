<?php
require_once 'console'.DIRECTORY_SEPARATOR.'console.php';
if($argv[1] != 'help')
	require_once 'console'.DIRECTORY_SEPARATOR.'commands'.DIRECTORY_SEPARATOR.$argv[1].'.php';
include_once "autoloader.php";

$cli = new console\console($argv);
echo $cli->execute();
?>