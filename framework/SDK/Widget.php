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
	
	function loadContent($cfg)
	{
		foreach($this->positions as $position){
			$content = '';
		
			foreach($this->cfg[$position] as $key => $param)
			{
				$path = $_SERVER['DOCUMENT_ROOT'].'/'.$cfg->GetSetting('base').'/templates/'.$cfg->GetSetting('site_template').'/modules/'.$key.'.html';
				$tmpl = fopen($path, "r");
				$content .= fread($tmpl, filesize($path));
				
				foreach($param as $key => $value)
					$content = str_ireplace('{'.$key.'}', $value, $content);
			}
			
			$this->cfg[$position] = $content;
		}
	}
	
	function show($mods)
	{
		$name = strtolower(str_ireplace('Widget', '',explode('\\', get_called_class())[1]));
		$mods[$name] = $this->cfg;
		
		return $mods;
	}
}
?>