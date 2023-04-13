<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;
use framework\Alias;
use framework\Builder;
use framework\Session;
use framework\QueryBuilder;

class Form extends Plugin
{
	function csrf()
	{
		$chars = 'abcdefghijklmnoprsqtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
		$len = strlen($chars);
		$token = '';
		
		for($i=0;$i<64;$i++)
		{
			$token .= substr($chars, rand(1, $len)-1, 1);
		}
		$settings = $this->data['cfg']->getSetting('session');
		$sess = new Session($settings);
		if(!$sess->addToken($token)) {
			echo 'csrf token crashed';
			die;
		}
		
		return $token;
	}
	
	function generate()
	{
		$res = '';
		$root_path = $_SERVER['DOCUMENT_ROOT'].
			$this->data['cfg']->GetSetting('base').
			DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR. 
			$this->data['cfg']->GetSetting('site_template').
			DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR;
		foreach($this->data['value']['fields'] as $key => $field) {
			$html = file_get_contents($root_path.$field['field_type'].'.html');
			if($key == '_csrf_token') {
				$field['value'] = $this->csrf();
			}
			$field['name'] = $key;
			
			if(in_array($field['field_type'], $this->data['cfg']->GetSetting('plugins'))) {
				$name = '\\Plugins\\'.ucfirst($field['field_type']);
				$plugin = new $name([
					'value' => $field, 'bulder' => new QueryBuilder(), 'cfg' => $this->data['cfg']]);
				$field = $plugin->show();
			}
			
			if($field['field_type'] == 'group') {
				$res1 = '';
				if(is_array($field['groupitems'])) {	
					foreach($field['groupitems'] as $item) {
						$html1 = file_get_contents($root_path.'groupItem.html');
						foreach($item as $id1 => $item1)
							$html1 = str_ireplace('{'.$id1.'}', $item1, $html1);
							
						$res1 .= $html1;
					}
					
					$field['groupitems'] = $res1;
					
				} else {
					
					$sql = 'SELECT '.$field['groupitems'].'_name FROM '.$field['groupitems'].'s';
					$data = $this->data['builder']->DataQuery($sql);
					
					foreach($data as $id => $item) {
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
?>