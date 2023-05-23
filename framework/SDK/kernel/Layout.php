<?php
namespace framework\kernel;

class Layout
{
	private $title;
	private $style;
	private $scripts;
	private $cfg;
	public $html;
	
	function __construct($base_path)
	{
		$this->cfg = Config::getInstance();
		$this->title = $this->cfg->GetSetting('layout')['title'];
		
		$assets = new Assets($this->cfg);
		$assets->generate();
		
		$this->style = 'assets'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR
			.$this->cfg->GetSetting('layout')['style'].'.css';
		$this->scripts = $this->cfg->GetSetting('layout')['scripts'];
		
		$path = $base_path.'layouts'.DIRECTORY_SEPARATOR
			.$this->cfg->getSetting('layout')['name'].'.html';
		
		$this->html = new Html($path);
	}
	
	function getHtml()
	{
		$script_html = '';
		foreach($this->scripts as $script)
		{
			$script_html .= '<script src="assets/js/'.$script.'.js"></script>';
		}
		
		$this->html->setData([
			'title' => $this->title,
			'style' => $this->style,
			'scripts' => $script_html
		]);
	}
}
?>