<?php
namespace framework\kernel;

class Assets
{
	private $cfg;
	private $js;
	private $css;
	private $tmp;
	private $page;
	private $modules;
	private $jsSize;
	private $cssSize;
	
	function __construct($cfg)
	{
		$arr = explode('\\', $cfg->getSetting('template'));
		if(count($arr)>1)
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/templates/'.$arr[0];
		else
			$this->tmp = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/templates/'.$cfg->getSetting('site_template');
		
		$this->page = $cfg->getSetting('template');
		
		if($cfg->getSetting('modules'))
			$this->modules = array_keys($cfg->getSetting('modules'));
		
		$dirs = $cfg->getSetting('assets');
		$root_path = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/'.$dirs['path'];
		
		if(!is_dir($root_path)) mkdir($root_path);
		
		$css_path = $root_path.'/'.$dirs['styles']['dir'];
		
		if(!is_dir($css_path)) mkdir($css_path);
		
		$css_file = $css_path.'/'.$dirs['styles']['name'].'.css';
		$this->cssSize = filesize($css_file);
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.'/'.$dirs['scripts']['dir'];
		
		if(!is_dir($js_path)) mkdir($js_path);
		
		$js_file = $js_path.'/'.$dirs['scripts']['name'].'.js';
		$this->jsSize = filesize($js_file);
		$this->js = fopen($js_file, 'w+');
		$this->cfg = $cfg;
	}
	
	function fileAppend($path)
	{
		if(file_exists($path))
		{
			$code = file_get_contents($path);
			
			if(strpos($path,'.css')) fwrite($this->css, $code.PHP_EOL);
			else fwrite($this->js, $code.PHP_EOL);
		}
	}
	
	function compareSize()
	{
		$size_css = 0;
		$size_css += filesize($this->tmp.'/styles/style.css');
		if(file_exists($this->tmp.'/styles/pages/'.$this->page.'.css'))
			$size_css += filesize($this->tmp.'/styles/pages/'.$this->page.'.css');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				if(file_exists($this->tmp.'/styles/modules/'.$module.'.css'))
					$size_css += filesize($this->tmp.'/styles/modules/'.$module.'.css');
		
		$size_js = 0;
		$size_js += filesize($this->tmp.'/scripts/script.js');
		if(file_exists($this->tmp.'/scripts/pages/'.$this->page.'.js'))
			$size_js += filesize($this->tmp.'/scripts/pages/'.$this->page.'.js');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				if(file_exists($this->tmp.'/scripts/modules/'.$module.'.js'))
					$size_js += filesize($this->tmp.'/scripts/modules/'.$module.'.js');
		
		$widgets = $this->cfg->getSetting('widgets');
		foreach($widgets as $name => $options)
			if(isset($options[$this->cfg->getSetting('site_template')])){
				$size_css += filesize($this->tmp.'/styles/modules/'.$name.'.css');
				if(file_exists($this->tmp.'/scripts/modules/'.$name.'.js'))
					$size_js += filesize($this->tmp.'/scripts/modules/'.$name.'.js');
			}
				
		return (($size_css == $this->cssSize) && (($size_js == $this->jsSize)));
	}
	
	function generate()
	{
		if(!$this->compareSize()) {
			$this->fileAppend($this->tmp.'/styles/style.css');
			$this->fileAppend($this->tmp.'/styles/pages/'.$this->page.'.css');
			
			if(isset($this->modules))
				foreach($this->modules as $module)
					$this->fileAppend($this->tmp.'/styles/modules/'.$module.'.css');
			
			$this->fileAppend($this->tmp.'/scripts/script.js');
			$this->fileAppend($this->tmp.'/scripts/pages/'.$this->page.'.js');
			
			if(isset($this->modules))
				foreach($this->modules as $module)
					$this->fileAppend($this->tmp.'/scripts/modules/'.$module.'.js');
					
			$widgets = $this->cfg->getSetting('widgets');
			foreach($widgets as $name => $options)
				if(isset($options[$this->cfg->getSetting('site_template')])){
					$this->fileAppend($this->tmp.'/styles/modules/'.$name.'.css');
					$this->fileAppend($this->tmp.'/scripts/modules/'.$name.'.js');
				}
		}		
		fclose($this->css);
		fclose($this->js);
	}
}
?>