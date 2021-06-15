<?php
$name = "admin\\themes";
$template = "form.themes";
$target = "index.php?page=admin\themes";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit theme'
	],
	'form' => [
		'target' => 'index.php?page=admin\\\\themes',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'ThemeEditor',
		'fields' => [
			'user_id' => [
				'field_type' => 'edit',
				'id' => 'user_id',
				'class' => 'user-id flex-row',
				'name' => 'UserId'
			],
			'forum_id' => [
				'field_type' => 'edit',
				'id' => 'forum_id',
				'class' => 'forum-id flex-row',
				'name' => 'ForumId'
			],
			'name' => [
				'field_type' => 'edit',
				'id' => 'theme_name',
				'class' => 'theme-name flex-row',
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