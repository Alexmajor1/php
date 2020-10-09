<?php
$name = "admin\\rules";
$template = "form.rules";
$target = "index.php?page=admin\\rules";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit rule'
	],
	'form' => [
		'target' => 'index.php?page=admin\\\\rules',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'RuleEditor',
		'fields' => [
			'Rule_name' => [
				'field_type' => 'edit',
				'id' => 'rule_name',
				'class' => 'rule-name flex-row',
				'name' => 'name'
			],
			'Rule_role' => [
				'field_type' => 'edit',
				'id' => 'rule_role',
				'class' => 'rule-role flex-row',
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