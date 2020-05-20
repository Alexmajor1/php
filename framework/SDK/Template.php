<?php
namespace framework;

class Template
{
	public $content;
	
	function __construct($cfg, $page)
	{
		$temp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/'.$page.'.html', "r");
		$this->content = fread($temp, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/'.$page.'.html'));
	}
	
	function apply($html)
	{
		$arr = explode(';', $html);
		
		foreach($arr as $value)
		{
			$temp = explode('->', $value);
			if(sizeof($temp) == 1)break;
			
			$this->content = str_replace($temp[1], $temp[0], $this->content);
		}
	}
}
?>