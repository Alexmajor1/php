<?php
$name = "editor\migrations";
$template = "migrations";
$target = "index.php?page=editor\migrations";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Migrations'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\migrations',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'MigrationForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'MigrationName',
				'style' => 'margin-bottom:5px',
				'id' => 'MigrationLabel'
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