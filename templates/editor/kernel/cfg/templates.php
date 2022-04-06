<?php
$name = "editor\templates";
$template = "templates";
$target = "index.php?page=editor\templates";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Templates'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\templates',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'TemplateForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'TemplateName',
				'style' => 'margin-bottom:5px',
				'id' => 'TemplateLabel'
			],
			'Pages' => [
				'field_type' => 'edit',
				'class' => 'TemplatePages',
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