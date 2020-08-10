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
	
	function GetContent($view)
	{
		$this->page->LoadLayout($this->cfg);
		$this->page->LoadView($view, $this->cfg);
		$page = explode('\\', $this->page->name);
		
		if($this->cfg->getSetting('site_template') != '')
		{
			
			$temp = new Template($this->cfg, end($page));
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
			$sql = 'SELECT '.$value[$elem.'items'].'_name FROM '.$value[$elem.'items'].'s';
			$data = $this->db->DataQuery($sql);
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