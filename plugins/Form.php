<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;
use framework\Alias;

class Form extends Plugin
{
	function generate()
	{
		$res = '';
		$root_path = $_SERVER['DOCUMENT_ROOT'].$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/';
		foreach($this->data['value']['fields'] as $key => $field)
		{
			$html = file_get_contents($root_path.$field['field_type'].'.html');
			
			$field['name'] = $key;
			
			if($field['field_type'] == 'group') {
				$res1 = '';
				
				if(is_array($field['groupitems']))
				{	
					foreach($field['groupitems'] as $item)
					{
						$html1 = file_get_contents($root_path.'groupItem.html');
						foreach($item as $id1 => $item1)
							$html1 = str_ireplace('{'.$id1.'}', $item1, $html1);
							
						$res1 .= $html1;
					}
					
					$field['groupitems'] = $res1;
					
				} else {
					
					$sql = 'SELECT '.$field['groupitems'].'_name FROM '.$field['groupitems'].'s';
					$data = $this->data['db']->DataQuery($sql);
					
					foreach($data as $id => $item)
					{
						$html1 = file_get_contents($root_path.'groupItem.html');
						
						$html1 = str_ireplace(['{type}', '{value}'], [$field['type'],$item[$field['groupitems'].'_name']], $html1);
						
						if($item[$field['groupitems'].'_name'] != 'Admin') $res1 .= $html1;
					}
					$field['groupitems'] = $res1;
				}
			}
			
			foreach($field as $id => $item)
				$html = str_ireplace('{'.$id.'}', $item, $html);
				
			$res .= $html;
		}
		
		$this->data['value']['fields'] = $res;
		
		$this->html = $this->data['value'];
	}
}