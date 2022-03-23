<?php
namespace framework\kernel;

class Layout
{
	private $title;
	private $style;
	private $scripts;
	private $cfg;
	public $content;
	
	function __construct()
	{
		$this->cfg = Config::getInstance();
		$this->title = $this->cfg->GetSetting('layout')['title'];
		
		$assets = new Assets($this->cfg);
		$assets->generate();
		
		$this->style = 'assets/css/'.$this->cfg->GetSetting('layout')['style'].'.css';
		$this->scripts = $this->cfg->GetSetting('layout')['scripts'];
		$path = $_SERVER['DOCUMENT_ROOT'].$this->cfg->GetSetting('base').'/templates/'.
			$this->cfg->GetSetting('site_template').'/layouts/'.$this->cfg->getSetting('layout')['name'].'.html';
		$this->content = file_get_contents($path);
	}
	
	function LoadView($temp)
	{
		$this->content = str_replace('{title}', $this->title, $this->content);
		$this->content = str_replace('{style}', $this->style, $this->content);
		$this->content = str_replace('{scripts}', '<script src="assets/js/script.js"></script>', $this->content);
		
		$temp->SetTarget($this->cfg->getSetting('target'));
		
		$this->content = str_replace('{content}', $temp->content, $this->content);
	}
}
?>