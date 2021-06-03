<?php
namespace framework;

class Layout
{
	private $title;
	private $style;
	private $scripts;
	private $cfg;
	public $content;
	
	function __construct($cfg)
	{
		$this->title = $cfg->GetSetting('title');
		$assets = new Assets($cfg);
		$assets->generate();
		
		$this->style = 'assets/css/'.$cfg->GetSetting('layout')['style'].'.css';
		$this->scripts = $cfg->GetSetting('layout')['scripts'];
		$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/layouts/'.$cfg->getSetting('layout')['name'].'.html', "r");
		$this->content = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/layouts/'.$cfg->getSetting('layout')['name'].'.html'));
		$this->cfg = $cfg;
	}
	
	function LoadView($temp, $cfg)
	{
		$this->content = str_replace('{title}', $this->title, $this->content);
		$this->content = str_replace('{style}', $this->style, $this->content);
		
		$this->content = str_replace('{scripts}', '<script src="assets/js/script.js"></script>', $this->content);
		$temp->SetTarget($cfg->getSetting('target'));
		$this->content = str_replace('{content}', $temp->content, $this->content);
	}
}
?>