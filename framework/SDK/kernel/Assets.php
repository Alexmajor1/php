<?php
namespace framework\kernel;

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
		
		if($cfg->getSetting('modules'))
			$this->modules = array_keys($cfg->getSetting('modules'));
		
		$dirs = $cfg->getSetting('assets');
		$root_path = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/'.$dirs['path'];
		
		if(!is_dir($root_path)) mkdir($root_path);
		
		$css_path = $root_path.'/'.$dirs['styles']['dir'];
		
		if(!is_dir($css_path)) mkdir($css_path);
		
		$css_file = $css_path.'/'.$dirs['styles']['name'].'.css';
		$this->css = fopen($css_file, 'w+');
		
		$js_path = $root_path.'/'.$dirs['scripts']['dir'];
		
		if(!is_dir($js_path)) mkdir($js_path);
		
		$js_file = $js_path.'/'.$dirs['scripts']['name'].'.js';
		$this->js = fopen($js_file, 'w+');
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
	
	function generate()
	{
		$this->fileAppend($this->tmp.'/styles/style.css');
		$this->fileAppend($this->tmp.'/styles/pages/'.$this->page.'.css');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				$this->fileAppend($this->tmp.'/styles/modules/'.$module.'.css');
		
		fclose($this->css);
		
		$this->fileAppend($this->tmp.'/scripts/script.js');
		$this->fileAppend($this->tmp.'/scripts/pages/'.$this->page.'.js');
		
		if(isset($this->modules))
			foreach($this->modules as $module)
				$this->fileAppend($this->tmp.'/scripts/modules/'.$module.'.js');
		
		fclose($this->js);
	}
}
?>