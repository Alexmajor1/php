<?php
namespace framework;

class View
{
	public $content;
	private $cfg;

	function __construct()
	{
		$this->cfg = Config::getInstance();
		$view_file = $this->cfg->getSetting('template');
		$path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/kernel/'.$view_file.'.html';
		$temp = fopen($path, "r");
		$this->content = fread($temp, filesize($path));
	}
	
	function SetTarget($target)
	{
		if(!empty($target))
		{
			$this->content = str_replace('{target}',$target, $this->content);
		}
	}
	
	function LoadModule($module, $params)
	{	
		$data = strtok($module, ':');
		
		$path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/'.$data.'.html';
		
		if(!file_exists($path))
		{
			$path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/framework/modules/'.$data.'.html';
		}
		
		$file = fopen($path, "r");
		$html = fread($file, filesize($path));
		
		foreach($params as $key => $value)
		{
			if(is_array($value))
			{
				foreach($value as $param => $val)
				{
					if(!is_array($val)) $html = str_replace('{'.$param.':'.$key.'}', $val, $html);
					
				}
			}else
			{
				$html = str_replace('{'.$key.'}', $value, $html);
			}
		}
		
		$this->content = str_replace('{'.$module.'}',$html, $this->content);
	}
}
?>