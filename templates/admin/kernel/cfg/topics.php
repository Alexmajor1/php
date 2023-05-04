<?php
$name = "admin\\topics";
$template = "topics";
$target = "index.php?page=admin\topics";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Topics'
	],
	'table' => [
		'id' => 'topics',
		'class' => 'themesTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Topics',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => ['topics.id', 'themes.name as theme', 'users.User_name', 'topics.name as topic'],
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'тема', 'автор', 'название'],
			'source' => 'topics, themes, users',
			'relation' => ['topics.user_id'],
			'value' => ['users.id'],
			'types' => [
				'id' => ['name' => 'text'],
				'theme' => ['name' => 'text'],
				'User_name' => ['name' => 'text'],
				'topic' => ['name' => 'link', 'url' => '&mode=form&id='],
			],
		],
	],
	'link' => [
		'insert' => [
			'target' => 'index.php?page=admin\\\\topics',
			'params' => '&mode=form',
			'name' => 'add topic',
			'style' => 'margin-left:10%'
		],
	],
];
?>