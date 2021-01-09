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
		$css_file = $css_path.'/'.$dirs['styles']['name'];
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.'/'.$dirs['scripts']['dir'];
		$js_file = $js_path.'/'.$dirs['scripts']['dir'];
		$this->js = fopen($js_file, 'w+');
	}
	
	function generate()
	{
		$file = fopen($this->tmp.'/styles/style.css', 'r');
		$code = fread($root, filesize($this->tmp.'/styles/style.css'));
		fwrite($this->css, $code);
		fclose($file);
		
		$file = fopen($this->tmp.'/styles/pages/'.$this->page.'.css', 'r');
		$code = fread($root, filesize($this->tmp.'/styles/pages/'.$this->page.'.css'));
		fwrite($this->css, $code);
		fclose($file);
		
		foreach($this->modules as $module)
		{
			$file = fopen($this->tmp.'/styles/modules/'.$module.'.css', 'r');
			$code = fread($root, filesize($this->tmp.'/styles/modules/'.$module.'.css'));
			fwrite($this->css, $code);
			fclose($file);
		}
		fclose($this->css);
		
		$file = fopen($this->tmp.'/scripts/script.js', 'r');
		$code = fread($root, filesize($this->tmp.'/scripts/script.js'));
		fwrite($this->js, $code);
		fclose($file);
		
		$file = fopen($this->tmp.'/scripts/pages/'.$this->page.'.js', 'r');
		$code = fread($root, filesize($this->tmp.'/scripts/pages/'.$this->page.'.js'));
		fwrite($this->js, $code);
		fclose($file);
		
		foreach($this->modules as $module)
		{
			$file = fopen($this->tmp.'/scripts/modules/'.$module.'.js', 'r');
			$code = fread($root, filesize($this->tmp.'/scripts/modules/'.$module.'.js'));
			fwrite($this->js, $code);
			fclose($file);
		}
		fclose(this->js);
	}
	
	function clear()
	{
		
	}
}
?>