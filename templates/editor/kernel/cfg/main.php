<?php
$name = "editor\main";
$template = "main";
$target = "index.php?page=editor\main";
$modules = [
	'form' => [
		'target' => 'index.php?page=editor\\\\main',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'AuthForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'User' => [
				'field_type' => 'edit',
				'class' => 'UserName',
				'id' => 'UserLabel'
			],
			'Password' => [
				'field_type' => 'password',
				'class' => 'Password',
				'id' => 'PasswordLabel'
			],
			'Remember' => [
				'field_type' => 'checkbox',
				'wrapper' => 'flex-row',
				'class' => 'Remember',
				'id' => 'RemeberLabel',
				'text_class' => 'Label margin',
				'text_id' => 'LabelText',
				'text' => 'remember me'
			],
			'submit' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'Submit',
				'id' => 'SubmitBtn'
			],
			'status' => [
				'field_type' => 'text',
				'class' => 'Status margin',
				'id' => 'StatusText',
				'text' => ''
			]
		]
	]
];
?>