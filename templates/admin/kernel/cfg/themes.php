<?php
$name = "admin\\themes";
$template = "themes";
$target = "index.php?page=admin\themes";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Themes'
	],
	'table' => [
		'id' => 'themes',
		'class' => 'themesTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Themes',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => 'id, forum_id, user_id, name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'форум', 'автор', 'название'],
			'source' => 'themes',
			'types' => [
				['name' => 'text'],
				['name' => 'text'],
				['name' => 'text'],
				['name' => 'link', 'url' => '&mode=form&id='],
			],
		],
	],
	'link' => [
		'WebMaster' => [
			'target' => 'mailto: asvelat@gmail.com',
			'class' => 'WebMasterMail',
			'id' => 'MailAddress',
			'name' => 'webmaster',
		],
		'insert' => [
			'target' => 'index.php?page=admin\\\\themes',
			'params' => '&mode=form',
			'name' => 'add theme',
			'style' => 'margin-left:10%'
		]
	],
];
?>