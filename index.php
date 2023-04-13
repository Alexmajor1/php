<?php
include_once "autoloader.php";

use framework\Application;

$app = new Application("config".DIRECTORY_SEPARATOR."settings.php");
$app->route();
$app->run();
?>