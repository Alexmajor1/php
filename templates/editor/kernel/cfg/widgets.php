<?php
$name = "editor\widgets";
$template = "widgets";
$target = "index.php?page=editor\widgets";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Widgets'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\widgets',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'WidgetForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'WidgetName',
				'style' => 'margin-bottom:5px',
				'id' => 'WidgetLabel'
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