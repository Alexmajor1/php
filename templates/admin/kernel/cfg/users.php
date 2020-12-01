<?php
$name = "admin\users";
$template = "users";
$target = "index.php?page=admin\users";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Users'
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
		'fields' => 'users.id, users.User_name, roles.Role_name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'имя', 'роль'],
			'source' => 'users, roles',
			'relation' => 'User_role',
			'value' => 'roles.id',
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
			'target' => 'index.php?page=admin\\\\users',
			'params' => '&mode=form',
			'name' => 'add user',
			'style' => 'margin-left:10%'
		],
	],
];
?>