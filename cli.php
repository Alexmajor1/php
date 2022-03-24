<?php
require_once 'console\\console.php';
require_once 'console\\commands\\'.$argv[1].'.php';

$cli = new console\console($argv);
echo $cli->execute();
?>