<?php
namespace framework\kernel;

class Assets
{
	private $cfg;
	private $js;
	private $css;
	private $base_path_styles;
	private $base_path_scripts;
	private $page;
	private $modules;
	private $jsSize;
	private $cssSize;
	
	function __construct($cfg)
	{
		$arr = explode('\\', $cfg->getSetting('template'));
		
		$path = __DIR__.DIRECTORY_SEPARATOR.'..'
			.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'
			.$cfg->GetSetting('base').DIRECTORY_SEPARATOR;
		
		if(count($arr)>1)
			$tmp = $path.'templates'.DIRECTORY_SEPARATOR.$arr[0];
		else
			$tmp = $path.'templates'.DIRECTORY_SEPARATOR
				.$cfg->getSetting('site_template');
				
		$this->base_path_styles = $tmp.DIRECTORY_SEPARATOR.'styles'
			.DIRECTORY_SEPARATOR;
		$this->base_path_scripts = $tmp.DIRECTORY_SEPARATOR.'scripts'
			.DIRECTORY_SEPARATOR;
		
		$this->page = $cfg->getSetting('template');
		
		if($cfg->getSetting('modules'))
			$this->modules = array_keys($cfg->getSetting('modules'));
		
		$dirs = $cfg->getSetting('assets');
		$root_path = $path.$dirs['path'];
		
		if(!is_dir($root_path)) mkdir($root_path);
		
		$css_path = $root_path.DIRECTORY_SEPARATOR.$dirs['styles']['dir'];
		
		if(!is_dir($css_path)) mkdir($css_path);
		
		$css_file = $css_path.DIRECTORY_SEPARATOR.$dirs['styles']['name']
			.'.css';
		$this->cssSize = filesize($css_file);
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.DIRECTORY_SEPARATOR.$dirs['scripts']['dir'];
		
		if(!is_dir($js_path)) mkdir($js_path);
		
		$js_file = $js_path.DIRECTORY_SEPARATOR.$dirs['scripts']['name'].'.js';
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
		$size_css += filesize($this->base_path_styles.'style.css');
		if(file_exists($this->base_path_styles.'pages'.DIRECTORY_SEPARATOR
			.$this->page.'.css'))
			$size_css += filesize($this->base_path_styles.'pages'
				.DIRECTORY_SEPARATOR.$this->page.'.css');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				if(file_exists($this->base_path_styles.'modules'
					.DIRECTORY_SEPARATOR.$module.'.css'))
					$size_css += filesize($this->base_path_styles.'modules'
						.DIRECTORY_SEPARATOR.$module.'.css');
		
		$size_js = 0;
		$size_js += filesize($this->base_path_scripts.'script.js');
		if(file_exists($this->base_path_scripts.'pages'.DIRECTORY_SEPARATOR
			.$this->page.'.js'))
			$size_js += filesize($this->base_path_scripts.'pages'
				.DIRECTORY_SEPARATOR.$this->page.'.js');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				if(file_exists($this->base_path_scripts.'modules'
					.DIRECTORY_SEPARATOR.$module.'.js'))
					$size_js += filesize($this->base_path_scripts.'modules'
						.DIRECTORY_SEPARATOR.$module.'.js');
		
		$widgets = $this->cfg->getSetting('widgets');
		foreach($widgets as $name => $options)
			if(isset($options[$this->cfg->getSetting('site_template')])){
				$size_css += filesize($this->base_path_styles.'modules'
					.DIRECTORY_SEPARATOR.$name.'.css');
				if(file_exists($this->base_path_scripts.'modules'
					.DIRECTORY_SEPARATOR.$name.'.js'))
					$size_js += filesize($this->base_path_scripts.'modules'
						.DIRECTORY_SEPARATOR.$name.'.js');
			}
				
		return (($size_css == $this->cssSize) 
			&& (($size_js == $this->jsSize)));
	}
	
	function generate()
	{
		if(!$this->compareSize()) {
			$this->fileAppend($this->base_path_styles.'style.css');
			$this->fileAppend($this->base_path_styles.'pages'
				.DIRECTORY_SEPARATOR.$this->page.'.css');
			
			if(isset($this->modules))
				foreach($this->modules as $module)
					$this->fileAppend($this->base_path_styles.'modules'
						.DIRECTORY_SEPARATOR.$module.'.css');
			
			$this->fileAppend($this->base_path_scripts.'script.js');
			$this->fileAppend($this->base_path_scripts.'pages'
				.DIRECTORY_SEPARATOR.$this->page.'.js');
			
			if(isset($this->modules))
				foreach($this->modules as $module)
					$this->fileAppend($this->base_path_scripts.'modules'
						.DIRECTORY_SEPARATOR.$module.'.js');
					
			$widgets = $this->cfg->getSetting('widgets');
			foreach($widgets as $name => $options)
				if(isset($options[$this->cfg->getSetting('site_template')])){
					$this->fileAppend($this->base_path_styles.'modules'
						.DIRECTORY_SEPARATOR.$name.'.css');
					$this->fileAppend($this->base_path_scripts.'modules'
						.DIRECTORY_SEPARATOR.$name.'.js');
				}
		}		
		fclose($this->css);
		fclose($this->js);
	}
}
?>