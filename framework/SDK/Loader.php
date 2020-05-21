<?php
namespace framework;

class Loader
{
	private $cfg;
	private $db;
	private $page;
	private $modules;
	
	function __construct($page, $db)
	{
		$this->db = $db;
		$this->page = $page;
		$this->modules = array();
	}
	
	function SetConfig($cfg)
	{
		$this->cfg = $cfg;
	}
	
	function GetContent($view)
	{
		$this->page->LoadLayout($this->cfg);
		$this->page->LoadView($view, $this->cfg);
		if($this->cfg->getSetting('site_template') != '')
		{
			$temp = new Template($this->cfg, $this->page->name);
			$temp->apply($this->page->getView());
			$this->page->updView($temp->content);
			$this->page->LoadModules($this->modules);
		} else {
			$temp = new Template('default', $this->page->name);
			$temp->apply($this->page->getView());
			$this->page->updView($temp->content);
			$this->page->LoadModules($this->modules);
		}
	}
	
	function GetModule($name, $settings)
	{
		$this->modules[$name] = $settings;
	}
	
	function group($key, $value, $elem)
	{
		if(is_array($value[$elem.'items']))
		{
			foreach($value[$elem.'items'] as $set => $val)
			{
				$value[$elem.'items'] .= $value[$elem.'items'].'<input type="'.$elem.'" name="'.$elem.$val[0].'" value="'.$val[1].'">'.$val[1];
			}
		}else{
			$sql = 'SELECT '.$value[$elem.'items'].'_name FROM '.$value[$elem.'items'].'s';
			$data = $this->db->DataQuery($sql);
			$value[$elem.'items'] .= 's'; 
			foreach($data as $set => $val)
			{	
				$value[$elem.'items'] .= '<input id="'.$val[0].'Label" type="'.$elem.'" name="'.$value[$elem.'items'].'" value="'.$val[0].'">'.$val[0];
			}
		}
		return $value;
	}
	
	function menu($key, $value)
	{
		if(is_array($value['menuitems']))
		{
			$str = '';
			foreach($value['menuitems'] as $set => $val)
			{
				$link = $this->db->ValueQuery("SELECT name FROM aliases WHERE page=\"".$val['url']."\"");
				$str .= "<li><a href=\"$link\">".$val['caption'].'</a></li>';
			}
		}else{
			$sql = 'SELECT '.$value['menuitems'].'_name FROM '.$value['menuitems'].'s';
			$data = $this->db->DataQuery($sql);
			$str = '';
			foreach($data as $set=>$val)
			{
				$link = $this->db->ValueQuery("SELECT name FROM aliases WHERE page=\"".$val['url']."\"");
				$str .= "<li><a href=\"$link\">".$val['caption'].'</a></li>';
			}
		}
		$value['menuitems'] = $str;
		return $value;
	}
	
	function form($key, $value)
	{
		$res = '';
		
		foreach($value['fields'] as $key => $field)
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/'.$field['field_type'].'.html', "r");
			$html = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/'.$field['field_type'].'.html'));
			
			$field['name'] = $key;
			
			if($field['field_type'] == 'group') {
				$res1 = '';
				
				if(is_array($field['groupitems']))
				{	
					foreach($field['groupitems'] as $item)
					{
						$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/groupItem.html', "r");
						$html1 = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/groupItem.html'));
						
						foreach($item as $id1 => $item1)
							$html1 = str_ireplace('{'.$id1.'}', $item1, $html1);
							
						$res1 .= $html1;
					}
					
					$field['groupitems'] = $res1;
					
				} else {
					
					$sql = 'SELECT '.$field['groupitems'].'_name FROM '.$field['groupitems'].'s';
					$data = $this->db->DataQuery($sql);
					
					foreach($data as $id => $item)
					{
						$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/groupItem.html', "r");
						$html1 = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/groupItem.html'));
						
						$res1 = str_ireplace(['{type}', '{value}'], [$field['type'],$item[0]], $html1);
						
						if($item[0] != 'Admin') $field['groupitems'] .= $res1;
					}
				}
			}
			
			foreach($field as $id => $item)
				$html = str_ireplace('{'.$id.'}', $item, $html);
				
			$res .= $html;
		}
		
		$value['fields'] = $res;
		
		return $value;
	}
	
	function listbox($key, $value)
	{
		$res = '';
		
		foreach($value['listitems'] as $item)
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/listItem.html', "r");
			$html = fread($file, filesize($_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template').'/modules/listItem.html'));
			
			$html = str_ireplace(['{name}', '{value}'], [$item['name'],$item['value']], $html);
			
			$res .= $html;
		}
		
		$value['listitems'] = $res;
		
		return $value;
	}
	
	function table($value)
	{
		$table = new Table($value, $this->db, $this->cfg);
		return $table->html;
	}
	
	function LoadContent()
	{
		$this->page->SetView($this->cfg);
		$this->page->PrintPage();
	}
}
?>