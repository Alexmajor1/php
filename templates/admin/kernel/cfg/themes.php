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
		'fields' => ['themes.id', 'forums.name as forum', 'users.User_name', 'themes.name as theme'],
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'форум', 'автор', 'название'],
			'source' => 'themes, forums, users',
			'relation' => ['themes.user_id', 'themes.forum_id'],
			'value' => ['users.id', 'forums.id'],
			'types' => [
				'id' => ['name' => 'text'],
				'forum' => ['name' => 'text'],
				'User_name' => ['name' => 'text'],
				'theme' => ['name' => 'link', 'url' => '&mode=form&id='],
			],
		],
	],
	'link' => [
		'insert' => [
			'target' => 'index.php?page=admin\\\\themes',
			'params' => '&mode=form',
			'name' => 'add theme',
			'style' => 'margin-left:10%'
		]
	],
];
?>