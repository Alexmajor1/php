<?php
$name = "admin\main";
$template = "main";
$target = "index.php?page=admin\main";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Admin panel'
	],
	'menu' => [
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
			'logout' => [
				'caption' => 'logout',
				'url' => 'index.php?page=logout'
			],
		]
	],
	'link' => [
		'WebMaster' => [
			'target' => 'mailto: asvelat@gmail.com',
			'class' => 'WebMasterMail',
			'id' => 'MailAddress',
			'name' => 'webmaster'
		]
	],
];
?>