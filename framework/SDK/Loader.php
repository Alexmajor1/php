<?php
namespace framework;

class Loader
{
	private $cfg;
	private $db;
	private $page;
	private $modules;
	
	function __construct($page, $db)
	{
		$this->db = $db;
		$this->page = $page;
		$this->modules = array();
	}
	
	function SetConfig($cfg)
	{
		$this->cfg = $cfg;
	}
	
	function GetContent()
	{
		$this->page->LoadLayout($this->cfg);
		$this->page->LoadView($this->cfg);
		$page = explode('\\', $this->page->name);
		
		if($this->cfg->getSetting('site_template') != '')
		{
			
			$temp = new Template($this->cfg);
			$temp->apply($this->page->getView());
			$this->page->updView($temp->content);
			$this->page->LoadModules($this->modules);
		} else {
			$temp = new Template('default', end($page));
			$temp->apply($this->page->getView());
			$this->page->updView($temp->content);
			$this->page->LoadModules($this->modules);
		}
	}
	
	function GetModule($name, $settings)
	{
		$this->modules[$name] = $settings;
	}
	
	function group($key, $value, $elem)
	{
		if(is_array($value[$elem.'items']))
		{
			foreach($value[$elem.'items'] as $set => $val)
			{
				$value[$elem.'items'] .= $value[$elem.'items'].'<input type="'.$elem.'" name="'.$elem.$val[0].'" value="'.$val[1].'">'.$val[1];
			}
		}else{
			$data = $this->db->select($value[$elem.'items'].'s', [$value[$elem.'items'].'_name' => $value[$elem.'items'].'_name'])->all();
			$value[$elem.'items'] .= 's'; 
			foreach($data as $set => $val)
			{	
				$value[$elem.'items'] .= '<input id="'.$val[0].'Label" type="'.$elem.'" name="'.$value[$elem.'items'].'" value="'.$val[0].'">'.$val[0];
			}
		}
		return $value;
	}
	
	function plugin($key, $value)
	{
		$name = '\\Plugins\\'.$key;
		$plugin = new $name(['value' => $value, 'db' => $this->db, 'cfg' => $this->cfg]);
		return $plugin->show();
	}
	
	function LoadContent()
	{
		$this->page->SetView($this->cfg);
		$this->page->PrintPage();
	}
}
?>