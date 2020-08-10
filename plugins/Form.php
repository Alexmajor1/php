<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;

class Form extends Plugin
{
	function generate()
	{
		$res = '';
		
		foreach($this->data['value']['fields'] as $key => $field)
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/'.$field['field_type'].'.html', "r");
			$html = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/'.$field['field_type'].'.html'));
			
			$field['name'] = $key;
			
			if($field['field_type'] == 'group') {
				$res1 = '';
				
				if(is_array($field['groupitems']))
				{	
					foreach($field['groupitems'] as $item)
					{
						$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/groupItem.html', "r");
						$html1 = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/groupItem.html'));
						
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
						$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/groupItem.html', "r");
						$html1 = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->data['cfg']->GetSetting('base').'/templates/'.$this->data['cfg']->GetSetting('site_template').'/modules/groupItem.html'));
						
						$res1 = str_ireplace(['{type}', '{value}'], [$field['type'],$item[0]], $html1);
						
						if($item[0] != 'Admin') $field['groupitems'] .= $res1;
					}
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