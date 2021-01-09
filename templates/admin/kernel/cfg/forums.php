<?php
$name = "admin\\forums";
$template = "forums";
$target = "index.php?page=admin\forums";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Forums'
	],
	'table' => [
		'id' => 'forums',
		'class' => 'forumsTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Forums',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => 'forums.id, users.User_name, forums.name',
		'mode' => 'main',
		'main' => [
			'headers' => ['ИД', 'автор', 'название'],
			'source' => 'forums, users',
			'relation' => 'forums.user_id',
			'value' => 'users.id',
			'types' => [
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
			'target' => 'index.php?page=admin\\\\forums',
			'params' => '&mode=form',
			'name' => 'add forum',
			'style' => 'margin-left:10%'
		],
	],
];
?>