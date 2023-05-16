<?php
namespace framework;

class Mail
{
	private sender;
	private $templates_path;
	
	function __construct($cfg)
	{
		$this->sender = $cfg->GetSetting('mail')['sender'];
		
		$this->templates_path = __DIR__.DIRECTORY_SEPARATOR.'..'
			.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR
			.$cfg->GetSetting('base').DIRECTORY_SEPARATOR
			.$cfg->GetSetting('mail')['templates_path'];
	}
	
	function get_template($name)
	{
		return file_get_contents($this->templates_path.DIRECTORY_SEPARATOR
			.$name.'.html');
	}
	
	function send($receiver, $title, $message)
	{
		return mail($receiver, $title, $message, ['From' => $this->sender]);
	}
}
?>