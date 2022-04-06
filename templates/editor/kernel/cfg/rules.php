<?php
$name = "editor\rules";
$template = "rules";
$target = "index.php?page=editor\rules";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Rules'
	],
	'form' => [
		'target' => 'index.php?page=editor\\\\rules',
		'class' => 'margin flex-col',
		'method' => 'POST',
		'id' => 'RuleForm',
		'fields' => [
			'_csrf_token' => [
				'field_type' => 'hidden'
			],
			'Name' => [
				'field_type' => 'edit',
				'class' => 'RuleName',
				'style' => 'margin-bottom:5px',
				'id' => 'RuleLabel'
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