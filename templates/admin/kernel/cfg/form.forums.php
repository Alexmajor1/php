<?php
$name = "admin\\forums";
$template = "form.forums";
$target = "index.php?page=admin\forums";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Edit forum'
	],
	'form' => [
		'target' => 'index.php?page=admin\\\\forums',
		'method' => 'POST',
		'id' => 'editor_form',
		'class' => 'ForumEditor',
		'fields' => [
			'user_id' => [
				'field_type' => 'edit',
				'id' => 'user_id',
				'class' => 'user-id flex-row',
				'name' => 'UserId'
			],
			'name' => [
				'field_type' => 'edit',
				'id' => 'forum_name',
				'class' => 'forum-name flex-row',
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
	'link' => [
		'WebMaster' => [
			'target' => 'mailto: asvelat@gmail.com',
			'class' => 'WebMasterMail',
			'id' => 'MailAddress',
			'name' => 'webmaster'
		]
	],
];
?>