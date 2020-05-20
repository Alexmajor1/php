<?php
$name = "registration";
$template = "registration";
$target = "index.php?page=registration";
$modules = [
	'form' => [
		'target' => 'index.php?page=registration',
		'id' => 'RegForm',
		'class' => 'flex-col',
		'method' => 'POST',
		'fields' => [
			'login' => [
				'field_type' => 'edit',
				'name' => 'user',
				'class' => 'UserName',
				'id' => 'UserLabel',
				'style' => 'font-size: 16px;'
			],
			'password' => [
				'field_type' => 'password',
				'name' => 'password',
				'class' => 'Password',
				'id' => 'PasswordLabel',
				'style' => 'font-size: 16px;'
			],
			'roles_group' => [
				'field_type' => 'group',
				'id' => 'roles',
				'type' => 'radio',
				'groupitems' => 'role'
			],
			'button' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'SendButton',
				'id' => 'SendBtn'
			],
			'status' => [
				'field_type' => 'text',
				'class' => 'Status',
				'id' => 'StatusText',
				'style' => 'font-size: 16px;',
				'align' => 'left',
				'text' => ''
			]
		]
	]
];
?>