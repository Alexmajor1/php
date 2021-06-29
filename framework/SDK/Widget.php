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
		$name = '\\Plugins\\'.$key;
		$plugin = new $name(['value' => $value, 'db' => DB::getInstance(), 'cfg' => $cfg]);
		return $plugin->show();
	}
	
	function loadContent($cfg)
	{
		$content = '';
		foreach($this->positions as $position){
			foreach($this->cfg[$position] as $key => $param)
			{
				$html = '';
				
				if(in_array($key, $cfg->GetSetting('plugins'))) {
					$values = $this->plugin($key, $param, $cfg);
					
					$path = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/modules/'.$key.'.html';
					$tmpl = fopen($path, "r");
					$html = fread($tmpl, filesize($path));
					
					foreach($values as $id => $value){
						$html = str_ireplace('{'.$id.'}', $value, $html);
					}
				} else {
					$path = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/modules/'.$key.'.html';
					$tmpl = fopen($path, "r");
					$html = fread($tmpl, filesize($path));
					
					foreach($param as $key => $value)
						$html = str_ireplace('{'.$key.'}', $value, $html);
				}
				
				$content .= $html;
			}
		}
		
		$this->cfg[$position] = $content;
	}
	
	function show($mods)
	{
		$name = strtolower(str_ireplace('Widget', '',explode('\\', get_called_class())[1]));
		$mods[$name] = $this->cfg;
		
		return $mods;
	}
}
?>