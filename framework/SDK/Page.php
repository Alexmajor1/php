<?php
namespace framework;

class Page
{
	public $name;
	private $layout;
	public $html;
	private $view;
	private $cfg;
	
	function __construct($cfg)
	{
		$this->cfg = $cfg;
		$this->name = $cfg->GetSetting('name');
		$this->html = new Html($this);
	}
	
	function LoadLayout()
	{
		$this->layout = new Layout($this->cfg);
	}
	
	function LoadView()
	{
		$this->view = new View($this->cfg);
	}
	
	function getView()
	{
		return $this->view->content;
	}
	
	function SetView()
	{
		$this->layout->LoadView($this->view, $this->cfg);
	}
	
	function updView($temp)
	{
		$this->view->content = $temp;
	}
	
	function LoadModules($modules)
	{
		foreach($modules as $key=>$value)
		{
			if(is_array($value))
			{
				foreach($value as $mod => $params)
				{
					if(!key_exists('id', $value))
					{
						$this->view->LoadModule($key.':'.$mod, $params);
					}else
					{
						$this->view->LoadModule($key, $value);
					}
				}
			}
		}
	}
	
	function PrintPage()
	{
		$result = preg_replace('/\s\w+="{\w+}"/', '', $this->layout->content);
		$result = preg_replace('/{\w+}/', '', $result);
		
		$lang = new Localization($this->cfg);
		$result = $lang->translate($result);
		
		echo $result;
	}
}
?>