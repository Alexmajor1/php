<?php
$base = 'php';

$controller = "MainController";

$site_template = "default";

$layout = [
	"name" => "layout",
	"title" => "my 'Hello world!' project",
	"style" => "style",
	"scripts" => [
		"script"
	]
];

$alias = [
	"mode" => "alias",
	"storage" => "table",
	"source" => "aliases"
];

$session = [
	"key" => "m82an14f89",
	"storage" => "table",
	"source" => "sessions"
];

$database = [
	'host' => 'localhost',
	'user' => 'root',
	'password' => '',
	'db' => 'mydatabase'
];

$plugins = [
	'table',
	'menu',
	'listbox',
	'form'
]
?>