<?php
namespace framework\kernel;

class Loader
{
	private $cfg;
	private $template;

	function __construct($page)
	{
		$this->page = $page;
		$this->modules = array();
		$this->cfg = Config::getInstance();
		
		$page = explode('\\', $this->page->getName());

		if($this->cfg->getSetting('site_template') != '')
			$this->template = new Template($this->cfg);
		else
			$this->template = new Template('default', end($page));
	}

	function setContent()
	{
		$page = explode('\\', $this->page->getName());
		
		if(count($page) > 1)
			$this->cfg->setSetting('site_template', $page[0]);
		
		$this->template = new Template($this->cfg);

		$this->template->apply();
	}
	
	function getContent()
	{
		return $this->template->content;
	}
}
?>