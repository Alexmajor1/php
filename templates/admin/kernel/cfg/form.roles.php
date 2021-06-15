<?php
$name = "admin\\roles";
$template = "form.roles";
$target = "index.php?page=admin\\roles";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit role'
	],
	'form' => [
		'target' => 'index.php?page=admin\\\\roles',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'RoleEditor',
		'fields' => [
			'Role_name' => [
				'field_type' => 'edit',
				'id' => 'role_name',
				'class' => 'role-name flex-row',
				'name' => 'name'
			],
			'submit' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'Submit flex-col',
				'id' => 'SubmitBtn'
			]
		]
	],
];
?>