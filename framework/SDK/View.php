<?php
namespace framework;

class View
{
	public $content;
	private $cfg;

	function __construct($cfg)
	{
		$view_file = $cfg->getSetting('template');
		$temp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/kernel/'.$view_file.'.html', "r");
		$this->content = fread($temp, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/kernel/'.$view_file.'.html'));
		$this->cfg = $cfg;
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
		$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/'.$data.'.html', "r");
		$html = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/'.$data.'.html'));
		
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