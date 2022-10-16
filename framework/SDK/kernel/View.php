<?php
namespace framework\kernel;

class View
{
	public $content;
	private $cfg;
	private $tmp_path;

	function __construct()
	{
		$this->cfg = Config::getInstance();
		$view_file = $this->cfg->getSetting('template');
		$this->tmp_path = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$this->cfg->GetSetting('base');
		$path = $this->tmp_path.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->cfg->GetSetting('site_template').DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.$view_file.'.html';
		if(file_exists($path))
			$this->content = file_get_contents($path);
	}
	
	function SetTarget($target)
	{
		$this->content = str_replace('{target}',$target, $this->content);
	}
	
	function LoadModule($module, $params)
	{
		$data = explode(':', $module)[0];
		$path = $this->tmp_path.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->cfg->GetSetting('site_template').DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$data.'.html';
		
		if(!file_exists($path)) $path = $this->tmp_path.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$data.'.html';
		
		$html = file_get_contents($path);
		
		if(isset($params))
			foreach($params as $key => $value)
				if(is_array($value)){
					foreach($value as $param => $val)
						if(!is_array($val)) $html = str_replace('{'.$param.':'.$key.'}', $val, $html);
				}else $html = str_replace('{'.$key.'}', $value, $html);
		
		$this->content = str_replace('{'.$module.'}',$html, $this->content);
	}
}
?>