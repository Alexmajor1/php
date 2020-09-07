<?php
$name = "admin\users";
$template = "admin\users";
$target = "index.php?page=admin\users";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Users'
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
	'table' => [
		'id' => 'users',
		'class' => 'usersTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Users',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => 'id, User_name, User_role',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'имя', 'роль'],
			'source' => 'users',
			'types' => [
				['name' => 'text'],
				['name' => 'text'],
				['name' => 'text']
			],
		],
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