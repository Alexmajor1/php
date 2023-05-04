<?php
$name = "cabinet";
$template = "cabinet";
$modules = [
	'text:user' => [
		'id' => 'login',
		'class' => 'margin',
		'text' => ''
	],
	'text:role' => [
		'id' => 'role',
		'class' => 'margin',
		'text' => ''
	],
	'link' => [
		'id' => 'logout_link',
		'name' => 'logout',
		'target' => 'index.php?page=logout'
	],
	'table' => [
		'id' => 'forum',
		'class' => 'forumTable',
		'style' => 'font-size: 16px;',
		'border' => '1',
		'caption' => 'Test forum',
		'pager' => [
			'pageSize' => 10
		],
		'fields' => ['id', 'name'],
		'mode' => 'main',
		'main' => [
			'headers' => ['Форумы'],
			'source' => 'forums',
			'types' => [
				'id' => ['name' => 'hide'],
				'name' => ['name' => 'link', 'url' => '&forum=']
			],
		],
		'alt' => [
			'headers' => ['Темы'],
			'source' => 'themes',
			'relation' => 'forum_id',
			'types' => [
				'id' => ['name' => 'hide'],
				'name' => ['name' => 'link', 'url' => '&theme=']
			],
		],
		'data' => [
			'headers' => ['Сообщения'],
			'source' => 'topics',
			'relation' => 'theme_id',
			'types' => [
				'id' => ['name' => 'hide'],
				'name' => ['name' => 'text']
			],
		]
	],
	'form' => [
		'target' => 'index.php?page=cabinet',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'forumEditor',
		'fields' => [
			'message' => [
				'field_type' => 'memo',
				'id' => 'message_text',
				'class' => 'forumMessage flex-row',
				'name' => 'message'
			],
			'author' => [
				'field_type' => 'hidden',
				'name' => 'author'
			],
			'submit' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'Submit flex-col',
				'id' => 'SubmitBtn'
			]
		]
	]
];
?>