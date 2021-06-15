<?php
$name = "admin\\roles";
$template = "roles";
$target = "index.php?page=admin\roles";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Roles'
	],
	'table' => [
		'id' => 'roles',
		'class' => 'rolesTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Roles',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => 'id, Role_name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'название'],
			'source' => 'roles',
			'types' => [
				['name' => 'text'],
				['name' => 'link', 'url' => '&mode=form&id='],
			],
		],
	],
	'link' => [
		'insert' => [
			'target' => 'index.php?page=admin\\\\roles',
			'params' => '&mode=form',
			'name' => 'add role',
			'style' => 'margin-left:10%'
		],
	],
];
?>