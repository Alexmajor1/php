<?php
namespace Plugins;

use framework\Plugin;

class Menu extends Plugin
{
	function generate()
	{
		if(is_array($this->data['value']['menuitems'])){
			$str = '';
			foreach($this->data['value']['menuitems'] as $set => $val){
				$link = ($this->data['builder'])->select('aliases', ['name' => 'name'])->where(['page' => $val['url']])->one();
				$str .= '<li><a href="'.$link['name'].'">'.$val['caption'].'</a></li>';
			}
		}else{
			$sql = 'SELECT '.$this->data['value']['menuitems'].'_name FROM '.$this->data['value']['menuitems'].'s';
			$data = ($this->data['builder'])->execute($sql);
			$str = '';
			foreach($data as $set=>$val){
				$link = ($this->data['builder'])->execute("SELECT name FROM aliases WHERE page=\"".$val['url']."\"");
				$str .= "<li><a href=\"$link\">".$val['caption'].'</a></li>';
			}
		}
		
		$this->data['value']['menuitems'] = $str;
		$this->html = $this->data['value'];
	}
}
?>