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
	'text' => [
		'users' => [
			'class' => 'margin',
			'id' => 'UsersText',
			'align' => 'center'
		],
		'roles' => [
			'class' => 'margin',
			'id' => 'RolesText',
			'align' => 'center'
		],
		'forums' => [
			'class' => 'margin',
			'id' => 'ForumsText',
			'align' => 'center'
		],
		'themes' => [
			'class' => 'margin',
			'id' => 'ThemesText',
			'align' => 'center'
		],
		'topics' => [
			'class' => 'margin',
			'id' => 'TopicsText',
			'align' => 'center'
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