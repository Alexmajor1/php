<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;

class Listbox extends Plugin
{
	function generate()
	{
		$res = '';
		
		if(key_exists('source', $this->data['value'])) {
			$name = '\\models\\'.ucfirst($this->data['value']['source']);
			$model = new $name();
			if(key_exists('value', $this->data['value']))
				$this->data['current'] = $this->data['value']['value'];
			
			$this->data['value']['listitems'] = 
				$model->read(['value' => 'id', 'name' => $this->data['value']['field']])->toArray();
		} 
		
		foreach($this->data['value']['listitems'] as $item){
			$path = $_SERVER['DOCUMENT_ROOT'].
				$this->data['cfg']->GetSetting('base').
				DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR. 
				$this->data['cfg']->GetSetting('site_template').
				DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'listItem.html';
			$html = file_get_contents($path);
			if(key_exists('current', $this->data) && $item['name'] == $this->data['current'])
				$html = str_ireplace(['{name}', '{sel}','{value}'], 
					[$item['name'], 'selected', $item['value']], $html);
			else
				$html = str_ireplace(['{name}', '{value}'], [$item['name'],$item['value']], $html);
			$res .= $html;
		}
		
		$this->data['value']['listitems'] = $res;
		$this->html = $this->data['value'];
	}
}
?>