<?php
$name = "admin\\topics";
$template = "form.topics";
$target = "index.php?page=admin\\topics";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit topic'
	],
	'form' => [
		'target' => 'index.php?page=admin\\\\topics',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'TopicEditor',
		'fields' => [
			'theme_id' => [
				'field_type' => 'listbox',
				'id' => 'theme_id',
				'class' => 'theme-id flex-row',
				'name' => 'theme',
				'source' => 'theme',
				'field' => 'name'
			],
			'user_id' => [
				'field_type' => 'listbox',
				'id' => 'user_id',
				'class' => 'user-id flex-row',
				'name' => 'user',
				'source' => 'user',
				'field' => 'User_name'
			],
			'name' => [
				'field_type' => 'edit',
				'id' => 'topic_name',
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