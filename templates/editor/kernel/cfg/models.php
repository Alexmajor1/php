<?php
$name = "editor\models";
$template = "models";
$target = "index.php?page=editor\models";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Models'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\models',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'ModelForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'ModelName',
				'style' => 'margin-bottom:5px',
				'id' => 'ModelLabel'
			],
			'Pages' => [
				'field_type' => 'edit',
				'class' => 'ModelFields',
				'style' => 'margin-bottom:5px',
				'id' => 'FiledsLabel'
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