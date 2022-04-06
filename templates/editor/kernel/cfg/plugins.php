<?php
$name = "editor\plugins";
$template = "plugins";
$target = "index.php?page=editor\plugins";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Plugins'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\plugins',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'PluginForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'PluginName',
				'style' => 'margin-bottom:5px',
				'id' => 'PluginLabel'
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