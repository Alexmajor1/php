<?php
$name = "admin\users";
$template = "edit.users";
$target = "index.php?page=admin\users";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit user'
	],
	'menu' => [
		'id' => 'mainmenu',
		'menuitems' => [
			'homePage' =>
			[
				'caption' => 'home page',
				'url' => 'index.php?page=admin\\\\main'
			],
			'users' => [
				'caption' => 'users',
				'url' => 'index.php?page=admin\\\\users'
			],
			'logout' => [
				'caption' => 'logout',
				'url' => 'index.php?page=logout'
			],
		]
	],
	'form' => [
		'target' => 'index.php?page=admin\users',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'UserEditor',
		'fields' => [
			'name' => [
				'field_type' => 'edit',
				'id' => 'user_name',
				'class' => 'user-name flex-row',
				'name' => 'name'
			],
			'role' => [
				'field_type' => 'edit',
				'id' => 'user_role',
				'class' => 'user-role flex-row',
				'name' => 'role'
			],
			'submit' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'Submit flex-col',
				'id' => 'SubmitBtn'
			]
		]
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