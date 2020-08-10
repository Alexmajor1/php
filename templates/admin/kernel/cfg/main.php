<?php
$name = "admin\main";
$template = "admin\main";
$modules = [
	'header' => [
		'size' => '1',
		'class' => 'margin',
		'id' => 'CaptionText',
		'align' => 'center',
		'text' => 'Admin panel'
	],
	'menu' => [
		'id' => 'mainmenu',
		'menuitems' => [
			'homePage' =>
			[
				'caption' => 'home page',
				'url' => 'index.php?page=admin\main'
			],
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