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
		'fields' => 'id, theme_id, user_id, name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'тема', 'автор', 'название'],
			'source' => 'topics',
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
			'name' => 'webmaster'
		],
		'insert' => [
			'target' => 'index.php?page=admin\\\\topics',
			'params' => '&mode=form',
			'name' => 'add topic',
			'style' => 'margin-left:10%'
		],
	],
];
?>