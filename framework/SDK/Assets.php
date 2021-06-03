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
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$arr[0];
		else
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->getSetting('site_template');
		
		$this->page = $cfg->getSetting('template');
		
		$this->modules = array_keys($cfg->getSetting('modules'));
		
		$dirs = $cfg->getSetting('assets');
		$root_path = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/'.$dirs['path'];
		
		$css_path = $root_path.'/'.$dirs['styles']['dir'];
		$css_file = $css_path.'/'.$dirs['styles']['name'].'.css';
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.'/'.$dirs['scripts']['dir'];
		$js_file = $js_path.'/'.$dirs['scripts']['name'].'.js';
		$this->js = fopen($js_file, 'w+');
	}
	
	function generate()
	{
		if(file_exists($this->tmp.'/styles/style.css'))
		{
			$file = fopen($this->tmp.'/styles/style.css', 'r');
			$code = fread($file, filesize($this->tmp.'/styles/style.css'));
			fwrite($this->css, $code);
			fclose($file);
		}
		
		if(file_exists($this->tmp.'/styles/pages/'.$this->page.'.css'))
		{
			$file = fopen($this->tmp.'/styles/pages/'.$this->page.'.css', 'r');
			$code = fread($file, filesize($this->tmp.'/styles/pages/'.$this->page.'.css'));
			fwrite($this->css, $code);
			fclose($file);
		}
		
		foreach($this->modules as $module)
		{
			if(file_exists($this->tmp.'/styles/modules/'.$module.'.css'))
			{
				$file = fopen($this->tmp.'/styles/modules/'.$module.'.css', 'r');
				$code = fread($file, filesize($this->tmp.'/styles/modules/'.$module.'.css'));
				fwrite($this->css, $code);
				fclose($file);
			}
		}
		fclose($this->css);
		
		if(file_exists($this->tmp.'/scripts/script.js'))
		{
			$file = fopen($this->tmp.'/scripts/script.js', 'r');
			$code = fread($file, filesize($this->tmp.'/scripts/script.js'));
			fwrite($this->js, $code);
			fclose($file);
		}
		
		if(file_exists($this->tmp.'/scripts/pages/'.$this->page.'.js'))
		{
			$file = fopen($this->tmp.'/scripts/pages/'.$this->page.'.js', 'r');
			$code = fread($file, filesize($this->tmp.'/scripts/pages/'.$this->page.'.js'));
			fwrite($this->js, $code);
			fclose($file);
		}
		
		foreach($this->modules as $module)
		{
			if(file_exists($this->tmp.'/scripts/modules/'.$module.'.js'))
			{
				$file = fopen($this->tmp.'/scripts/modules/'.$module.'.js', 'r');
				$code = fread($file, filesize($this->tmp.'/scripts/modules/'.$module.'.js'));
				fwrite($this->js, $code);
				fclose($file);
			}
		}
		fclose($this->js);
	}
	
	function clear()
	{
		
	}
}
?>