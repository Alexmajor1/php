<?php
namespace framework;

class Page
{
	public $name;
	private $layout;
	public $html;
	private $view;
	
	function __construct($cfg)
	{
		$this->name = $cfg->GetSetting('name');
		$this->html = new Html($this);
	}
	
	function LoadLayout($cfg)
	{
		$this->layout = new Layout($cfg);
	}
	
	function LoadView($cfg)
	{
		$this->view = new View($cfg);
	}
	
	function getView()
	{
		return $this->view->content;
	}
	
	function SetView($cfg)
	{
		$this->layout->LoadView($this->view, $cfg);
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
		echo $result;
	}
}
?>