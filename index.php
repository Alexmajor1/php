<?php
include_once "autoloader.php";

use framework\Application;

$app = new Application("config\\settings.php");
$app->route();
$app->run();
?>