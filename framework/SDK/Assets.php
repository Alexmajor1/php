<?php
namespace framework;

class Assets
{
	private $js;
	private $css;
	private $tmp;
	private $page;
	private $modules;
	
	function __construct($cfg)
	{
		$arr = explode('\\', $cfg->getSetting('template'));
		if(count($arr)>1)
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/templates/'.$arr[0];
		else
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/templates/'.$cfg->getSetting('site_template');
		
		$this->page = $cfg->getSetting('template');
		
		$this->modules = array_keys($cfg->getSetting('modules'));
		
		$dirs = $cfg->getSetting('assets');
		$root_path = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/'.$dirs['path'];
		
		$css_path = $root_path.'/'.$dirs['styles']['dir'];
		$css_file = $css_path.'/'.$dirs['styles']['name'].'.css';
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.'/'.$dirs['scripts']['dir'];
		$js_file = $js_path.'/'.$dirs['scripts']['name'].'.js';
		$this->js = fopen($js_file, 'w+');
	}
	
	function fileAppend($path)
	{
		if(file_exists($path))
		{
			$file = fopen($path, 'r');
			$code = fread($file, filesize($path));
			
			if(strpos($path,'.css'))
				fwrite($this->css, $code);
			else
				fwrite($this->js, $code);
			fclose($file);
		}
	}
	
	function generate()
	{
		$this->fileAppend($this->tmp.'/styles/style.css');
		$this->fileAppend($this->tmp.'/styles/pages/'.$this->page.'.css');
		
		foreach($this->modules as $module)
			$this->fileAppend($this->tmp.'/styles/modules/'.$module.'.css');
		
		fclose($this->css);
		
		$this->fileAppend($this->tmp.'/scripts/script.js');
		$this->fileAppend($this->tmp.'/scripts/pages/'.$this->page.'.js');
		
		foreach($this->modules as $module)
			$this->fileAppend($this->tmp.'/scripts/modules/'.$module.'.js');
		
		fclose($this->js);
	}
}
?>