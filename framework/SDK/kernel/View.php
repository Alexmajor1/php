<?php
namespace framework\kernel;

use framework\QueryBuilder;

class View
{
	public $html;
	private $view;
	private $cfg;
	private $base_path;

	function __construct($root_path)
	{
		$this->cfg = Config::getInstance();
		$view_file = $this->cfg->getSetting('template');
			
		$this->root_path = $root_path;
		
		$path = $this->root_path.'templates'.DIRECTORY_SEPARATOR
			.$cfg->GetSetting('site_template').DIRECTORY_SEPARATOR.'kernel'
			.DIRECTORY_SEPARATOR.$view_file.'.html';
		
		$this->view = explode(';', file_get_contents($path));
		
		$path = $this->root_path.'templates'.DIRECTORY_SEPARATOR
			.$cfg->GetSetting('site_template').DIRECTORY_SEPARATOR
			.$view_file.'.html';
		
		$this->html = new Html($path);
	}
	

	function plugin($key, $value)
	{
		$name = '\\plugins\\'.ucfirst($key);
		$plugin = new $name([
			'value' => $value,
			'builder' => new QueryBuilder(),
			'cfg' => $this->cfg
		]);

		return $plugin->show();
	}
	
	function getHtml()
	{
		$content = [];
		
		$alias = new Alias();
		
		foreach($this->view as $element)
		{
			if($element == '') continue;
			$rel = explode('->', $element);
			$module = explode(':', $rel[0])[0];
			$module = str_replace(['{', '}'], '', $module);
			$module = trim($module);
			
			$base_path = $this->root_path.'templates'.DIRECTORY_SEPARATOR
				.$cfg->GetSetting('site_template').DIRECTORY_SEPARATOR
				.'modules'.DIRECTORY_SEPARATOR;
			
			if(!file_exists($base_path.$key.'.html')){
					$base_path = $this->root_path.'templates'
					.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR
					.'modules'.DIRECTORY_SEPARATOR;
					if(!file_exists($base_path.$key.'.html')){
						$base_path = $root_path.'framework'.DIRECTORY_SEPARATOR
							.'modules'.DIRECTORY_SEPARATOR;
					}
				}
			
			$path = $base_path.$module.'.html';
			
			$key = str_replace(['{', '}'], '', $rel[0]);
			$key = trim($key);
			
			$keys = explode(':', $key);
			if(count($keys) > 1)
				$params = $this->cfg->GetSetting('modules')[$keys[0]][$keys[1]];
			else
				$params = $this->cfg->GetSetting('modules')[$key];
			
			if(in_array($module, $this->cfg->GetSetting('plugins')))
					$params = $this->plugin($module, $params);
				
			$html = new Html($path);
			
			if(key_exists('target', $params))
				$params['target'] = $alias->encode($params['target']);
			
			$html->setData($params);
			
			$position = explode(':', $rel[1])[0];
			$position = str_replace(['{', '}'], '', $position);
			$position = trim($position);
			$content[$position] = $html->content;
		}
		
		$this->html->setData([
			'target' => $alias->encode($this->cfg->getSetting('target'))
		]);
		
		$this->html->setData($content);
	}
}
?>