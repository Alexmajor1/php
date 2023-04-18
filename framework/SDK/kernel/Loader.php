<?php
namespace framework\kernel;

use framework\QueryBuilder;

class Loader
{
	private $cfg;
	private $page;
	private $modules;
	
	function __construct($page)
	{
		$this->page = $page;
		$this->modules = array();
		$this->cfg = Config::getInstance();
	}
	
	function GetContent()
	{
		$this->page->LoadLayout();
		$this->page->LoadView();
		
		$page = explode('\\', $this->page->name);
		
		if($this->cfg->getSetting('site_template') != '')
			$temp = new Template($this->cfg);
		else
			$temp = new Template('default', end($page));
		
		$temp->apply($this->page->getView());
		$this->page->updView($temp->content);
		$this->page->LoadModules($this->modules);
	}
	
	function GetModule($name, $settings)
	{
		$this->modules[$name] = $settings;
	}
	
	function plugin($key, $value)
	{
		$name = '\\Plugins\\'.ucfirst($key);
		$plugin = new $name(['value' => $value, 'builder' => new QueryBuilder(), 'cfg' => $this->cfg]);
		
		return $plugin->show();
	}
	
	function LoadContent()
	{
		$this->page->SetView();
		$this->page->PrintPage();
	}
}
?>