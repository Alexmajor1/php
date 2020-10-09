<?php
$name = "admin\\rules";
$template = "rules";
$target = "index.php?page=admin\\rules";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Rules'
	],
	'table' => [
		'id' => 'rules',
		'class' => 'rulesTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Rules',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => 'id, Rule_name, Rule_role',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'Название', 'роль'],
			'source' => 'rules',
			'types' => [
				['name' => 'text'],
				['name' => 'link', 'url' => '&mode=form&id='],
				['name' => 'text'],
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
			'target' => 'index.php?page=admin\\\\rules',
			'params' => '&mode=form',
			'name' => 'add rule',
			'style' => 'margin-left:10%'
		],
	],
];
?>