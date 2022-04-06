<?php
$name = "editor\controllers";
$template = "controllers";
$target = "index.php?page=editor\controllers";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Controllers'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\controllers',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'ControllerForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'ControllerName',
				'style' => 'margin-bottom:5px',
				'id' => 'ControllerLabel'
			],
			'Pages' => [
				'field_type' => 'edit',
				'class' => 'ControllerPages',
				'style' => 'margin-bottom:5px',
				'id' => 'PagesLabel'
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