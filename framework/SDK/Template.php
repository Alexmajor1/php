<?php
namespace framework;

class Template
{
	public $content;
	
	function __construct($cfg)
	{
		$page = $cfg->getSetting('template');
		$path = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/'.$page.'.html';
		$this->content = file_get_contents($path);
	}
	
	function apply($html)
	{
		$arr = explode(';', $html);
		
		foreach($arr as $value){
			$temp = explode('->', $value);
			
			if(sizeof($temp) == 1)break;
			
			$this->content = str_replace($temp[1], $temp[0], $this->content);
		}
	}
}
?>