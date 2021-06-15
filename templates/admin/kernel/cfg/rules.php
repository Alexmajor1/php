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
		'fields' => 'rules.id, rules.Rule_name, roles.Role_name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'Название', 'роль'],
			'source' => 'rules, roles',
			'relation' => 'Rule_role',
			'value' => 'roles.id',
			'types' => [
				['name' => 'text'],
				['name' => 'link', 'url' => '&mode=form&id='],
				['name' => 'text'],
			],
		],
	],
	'link' => [
		'insert' => [
			'target' => 'index.php?page=admin\\\\rules',
			'params' => '&mode=form',
			'name' => 'add rule',
			'style' => 'margin-left:10%'
		],
	],
];
?>