<?php
require_once 'console\\console.php';
if($argv[1] != 'help')
	require_once 'console\\commands\\'.$argv[1].'.php';
include_once "autoloader.php";

$cli = new console\console($argv);
echo $cli->execute();
?>