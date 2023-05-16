<?php
namespace framework;

class Widget
{
	public $cfg;
	public $positions = ['content'];
	
	function __construct($cfg)
	{
		$this->cfg = $cfg;
	}
	
	function plugin($key, $value, $cfg)
	{
		$name = '\\Plugins\\'.ucfirst($key);
		$plugin = new $name([
			'value' => $value, 
			'db' => DB::getInstance(), 
			'cfg' => $cfg
		]);
		
		return $plugin->show();
	}
	
	function loadContent($cfg)
	{
		$content = '';
		
		foreach($this->positions as $position){
			foreach($this->cfg[$position] as $key => $param){
				$html = '';
				
				if(in_array($key, $cfg->GetSetting('plugins')))
					$values = $this->plugin($key, $param, $cfg);
				
				$base_path = __DIR__.DIRECTORY_SEPARATOR.'..'
					.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR
					.$cfg->GetSetting('base').DIRECTORY_SEPARATOR.'templates'
					.DIRECTORY_SEPARATOR.$cfg->GetSetting('site_template')
					.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR;
				
				$path = $base_path.$key.'.html';
				$html = file_get_contents($path);
				
				foreach($param as $key => $value)
					$html = str_ireplace('{'.$key.'}', $value, $html);
				
				$content .= $html;
			}
		}
		
		$this->cfg[$position] = $content;
	}
	
	function show($mods)
	{
		$raw_name = explode('\\', get_called_class())[1];
		$name = strtolower(str_ireplace('Widget', '', $raw_name));
		$mods[$name] = $this->cfg;
		
		return $mods;
	}
}
?>