<?php
namespace framework\kernel;

class Template
{
	public $content;
	private $path;
	private $layout;
	private $view;
	
	function __construct($cfg)
	{
		$this->path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
			.DIRECTORY_SEPARATOR.'..'.$cfg->GetSetting('base')
			.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR
			.$cfg->GetSetting('site_template').DIRECTORY_SEPARATOR;
			
		$this->layout = new Layout($this->path);
		
		$path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
			.DIRECTORY_SEPARATOR.'..'.$cfg->GetSetting('base')
			.DIRECTORY_SEPARATOR;
			
		$this->view = new View($path);
	}
	
	function apply()
	{
		$this->layout->getHtml();
		$this->view->getHtml();
		
		$this->content = $this->layout->html->content;
		$this->content = str_ireplace(
			'{content}', 
			$this->view->html->content, 
			$this->layout->html->content
		);
	}
}
?>