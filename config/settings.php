<?php
$base = '';

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

$assets = [
	"path" => "assets",
	"scripts" => [
		"dir" => "js",
		"name" => "script"
	],
	"styles" => [
		"dir" => "css",
		"name" => "style"
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

$cache = [
	'dir' => 'cache',
	'expired' => 3600
];

$mail = [
	'sender' => 'admin@site.net',
	'templates_path' => 'mail'
];

$plugins = [
	'table',
	'menu',
	'listbox',
	'form'
];

$widgets =[
	'pagefooter' => [
		'content' => [
			'link' => [
				'id' => 'footer',
				'target' => 'mailto: asvelat@gmail.com',
				'class' => 'WebMasterMail',
				'id' => 'MailAddress',
				'name' => 'webmaster'
			]
		],
		'id' => 'footer'
	],
	'menu' => [
		'admin' => [
			'id' => 'mainmenu',
			'menuitems' => [
				'homePage' =>
				[
					'caption' => 'home page',
					'url' => 'index.php?page=admin\\\\main'
				],
				'users' => [
					'caption' => 'users',
					'url' => 'index.php?page=admin\\\\users'
				],
				'roles' => [
					'caption' => 'roles',
					'url' => 'index.php?page=admin\\\\roles'
				],
				'rules' => [
					'caption' => 'rules',
					'url' => 'index.php?page=admin\\\\rules'
				],
				'forums' => [
					'caption' => 'forums',
					'url' => 'index.php?page=admin\\\\forums'
				],
				'themes' => [
					'caption' => 'themes',
					'url' => 'index.php?page=admin\\\\themes'
				],
				'topics' => [
					'caption' => 'topics',
					'url' => 'index.php?page=admin\\\\topics'
				],
				'logout' => [
					'caption' => 'logout',
					'url' => 'index.php?page=logout'
				],
			]
		],
		'editor' => [
			'id' => 'editormenu',
			'menuitems' => [
				'migrations' =>
				[
					'caption' => 'migrations',
					'url' => 'index.php?page=editor\\\\migrations'
				],
				'controllers' => [
					'caption' => 'controllers',
					'url' => 'index.php?page=editor\\\\controllers'
				],
				'rules' => [
					'caption' => 'rules',
					'url' => 'index.php?page=editor\\\\rules'
				],
				'models' => [
					'caption' => 'models',
					'url' => 'index.php?page=editor\\\\models'
				],
				'templates' => [
					'caption' => 'templates',
					'url' => 'index.php?page=editor\\\\templates'
				],
				'plugins' => [
					'caption' => 'plugins',
					'url' => 'index.php?page=editor\\\\plugins'
				],
				'widgets' => [
					'caption' => 'widgets',
					'url' => 'index.php?page=editor\\\\widgets'
				],
				'logout' => [
					'caption' => 'logout',
					'url' => 'index.php?page=logout'
				],
			]
		]
	]
];
?>