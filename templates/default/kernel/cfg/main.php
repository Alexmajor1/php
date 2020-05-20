<?php
$name = "main";
$template = "main";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Hello world!'
	],
	'text' => [
		'class' => 'margin',
		'id' => 'InviteText',
		'align' => 'center',
		'text' => "This is my 'Hello world!' project"
	],
	'listbox' => [
		'class' => 'languages',
		'id' => 'lng',
		'size' => '1',
		'listitems' => [
			[
				'value' => '1',
				'name' => 'ru'
			],
			[
				'value' => '2',
				'name' => 'kz'
			],
		]
	],
	'form' => [
		'target' => 'index.php?page=authorization',
		'class' => 'margin flex-row',
		'method' => 'POST',
		'id' => 'EntryPanel',
		'fields' => [
			'User' => [
				'field_type' => 'edit',
				'class' => 'UserName flex-col',
				'id' => 'UserLabel'
			],
			'Password' => [
				'field_type' => 'password',
				'class' => 'Password flex-col',
				'id' => 'PasswordLabel'
			],
			'Remember' => [
				'field_type' => 'checkbox',
				'class' => 'Remember flex-col',
				'id' => 'RemeberLabel',
				'text_class' => 'Label flex-col margin',
				'text_id' => 'LabelText',
				'text' => 'remember me'
			],
			'submit' => [
				'field_type' => 'send',
				'text' => 'send',
				'class' => 'Submit flex-col',
				'id' => 'SubmitBtn'
			],
			'stat' => [
				'field_type' => 'text',
				'class' => 'Status flex-col',
				'id' => 'StatusLabel',
				'text' => ''
			]
		]
	],
	'menu' => [
		'id' => 'mainmenu',
		'menuitems' => [
			'homePage' =>
			[
				'caption' => 'home page',
				'url' => 'index.php'
			],
			'registration' =>
			[
				'caption' => 'registration',
				'url' => 'index.php?page=registration'
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
	'table' => [
		'id' => 'testTable',
		'border' => '1',
		'caption' => 'Test table',
		'pager' => [
			'pageSize' => 3
		],
		'headers' =>[
			'col1',
			'col2',
			'col3'
		],
		'rows' =>
		[
			['1','1','1'],
			['1','2','2'],
			['1','1','3'],
			['2','2','1'],
			['2','1','2'],
			['2','2','3']
		]
	],
	'image' => [
		'id' => 'testImage',
		'link' => 'images\Chrysanthemum.jpg',
		
	]
];
?>