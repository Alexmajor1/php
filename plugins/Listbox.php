<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;

class Listbox extends Plugin
{
	function generate()
	{
		$res = '';
		
		foreach($this->data['value']['listitems'] as $item)
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/listItem.html', "r");
			$html = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/listItem.html'));
			
			$html = str_ireplace(['{name}', '{value}'], [$item['name'],$item['value']], $html);
			
			$res .= $html;
		}
		
		$this->data['value']['listitems'] = $res;
		
		$this->html = $this->data['value'];
	}
}