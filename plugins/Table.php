<?php
namespace Plugins;

use framework\Plugin;
use framework\Request;

class Table extends Plugin
{
	private $db;
	private $cfg;
	private $path;
	
	function generate()
	{
		$this->cfg = $this->data['cfg'];
		$this->db = $this->data['db'];
		$this->path = $_SERVER['DOCUMENT_ROOT'].
			$this->cfg->GetSetting('base').
			'/templates/'.
			$this->cfg->GetSetting('site_template');
			
		if(key_exists('fields', $this->data['value'])) $data = $this->tableDB($this->data['value']);
		else $data = $this->tableArr($this->data['value']);
		
		$value = $data[0];
		if(key_exists('pager', $this->data['value']))
			$value['pager'] = $this->tablePager([
				'pageSize' => $this->data['value']['pager']['pageSize'],
				'rowCount' => $data[1]
			]);
		
		$this->html = $value;
		
	}
	
	function getTableArrSort($rows)
	{
		$head_sort = array();
		$pageLink = '';
		
		foreach($_REQUEST as $key => $val)
			if(!strstr('alias', $key)){
				$pageLink .= "&$key=$val";
				
				switch($val){
					case 'asc':$head_sort[$key] = SORT_ASC;break;
					case 'desc':$head_sort[$key] = SORT_DESC;break;
				}
			}else $pageLink .= "$val";
		
		if(!empty($head_sort))
			return [$pageLink, $head_sort, $this->tableArrSort($rows, $head_sort)];
		
		return [$pageLink, $head_sort];
	}
	
	function getTableArrHeaders($headers, $pageLink, $head_sort)
	{
		$str = '';
		
		$html = file_get_contents($this->path.'/modules/tableHeader.html');
		
		foreach($headers as $key => $val){			
			$html1 = $html;
			
			if(count($head_sort) == 0){
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, "&$key=desc", $val], $html1);
				$str .= $html1."\n";
			}else{
				$str1 = '';
				foreach($headers as $key1 => $val1)
					if($key1 == $key)
						if(key_exists($key1, $head_sort))
							switch($head_sort[$key1]){
								case SORT_ASC: $pageLink = str_ireplace("&$key1=asc" , "&$key1=desc", $pageLink);break;
								case SORT_DESC: $pageLink = str_ireplace("&$key1=desc" , "&$key1=asc", $pageLink);break;
							}
						else $str1 .= "&$key1=desc"; 
				
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, $str1, $val], $html1);
				$str .= $html1."\n";
			}
		}
		
		return $str;
	}
	
	function tableArr($value)
	{
		$result = $this->getTableArrSort($value['rows']);
		$head_sort = $result[1];
		$pageLink = $result[0];
		
		if(count($result) == 3)
			$value['rows'] = $result[2];
		
		$value['headers'] = $this->getTableArrHeaders($value['headers'], $pageLink, $head_sort);
		$str = '';
		$req = new Request(null);
		$num = (key_exists('p', $req->get()))?$req->get('p'):1;
		$end = $num * $value['pager']['pageSize'];
		$start = $end-$value['pager']['pageSize'];
		$html1 = file_get_contents($this->path.'/modules/tableRow.html');
		$html2 = file_get_contents($this->path.'/modules/tableCol.html');
		
		$str = '';
		for($i=$start;$i<$end;$i++){
			$row = $value['rows'][$i];
			$str1 = '';
			foreach($row as $val)
				if(!is_array($val)) {
					$html21 = $html2;
					$html21 = str_ireplace('{value}', $val, $html21);
					$str1 .= "$html21\n";
				}else $this->fields($val);
			$html11 = $html1;
			$html11 = str_ireplace('{cols}', $str1, $html11);
			
			$str .= "$html11\n";
			
		}
		$count = sizeof($value['rows']);
		$value['rows'] = $str;
		
		return [$value, $count];
	}
	
	function fields($data)
	{
		switch($data['type']){
			case 'text': $res = $data['value']['text'];break;
			case 'link': $res = '<a href = "'.$data['value']['url'].'">'.$data['value']['caption'].'</a>';break;
			case 'image': $res = '<img src = "'.$data['value']['url'].'">';break;
		}
		
		return $res;
	}
	
	function getData($value)
	{
		$sql = 'select '.$value['fields'].' from '.$value[$value['mode']]['source'];
		
		if(key_exists('relation',$value[$value['mode']]))
			$sql .= ' where '.$value[$value['mode']]['relation'].'='.$value[$value['mode']]['value'];
		
		$order = ' order by ';
		$fields = explode(', ', $value['fields']);
		
		foreach($_REQUEST as $key => $val)
			if($val == 'asc' or $val == 'desc')
				$order .= 
					$fields[$key].
					" $val,";
		
		if(strlen($order)> 10) $sql .= mb_substr($order, 0, -1);
		
		$req = new Request(null);
		$num = '';
		
		if(key_exists('p', $req->get())) $num = $req->get('p');
		
		if($num>0){
			$page = $value['pageSize'];
			$offset = ($num*$page)-$page;
			$sql .= " limit $offset, $page";
		}else{
			$page = $value['pager']['pageSize'];
			$sql .= " limit $page";
		}
		
		return $this->db->DataQuery($sql);
	}
	
	function getHeaders($value)
	{
		$pageLink = $_REQUEST['alias'];
		$str = '';
		$head_sort = array();
		
		foreach($_REQUEST as $key => $val)
			if(is_numeric($key)) {
				$head_sort[$key] = $val;
				$pageLink .= "&$key=$val";
			}
		
		if(!key_exists('headers', $value[$value['mode']]))
			$tmp = $this->db->FieldsDescriptors();
		else $tmp = $value[$value['mode']]['headers'];
		
		$html = file_get_contents($this->path.'/modules/tableHeader.html');
		$i = 0;
		foreach($tmp as $val){
			$html1 = $html;
			$key = $i;
			$val = (is_object($val))?$val->name:$val;
			
			if(key_exists($key, $head_sort)){
				switch($head_sort[$key]) {
					case 'asc': $pageLink = str_ireplace("&$key=asc" , "&$key=desc", $pageLink);break;
					case 'desc': $pageLink = str_ireplace("&$key=desc" , "&$key=asc", $pageLink);break;
				}
				
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, '', $val], $html1);
			}else
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, "&$key=desc", $val], $html1);
			
			$val1 = $val;
			$value['headers'] = $val1;
			$str .= $html1;
			$i++;
		}
		
		return $str;
	}
	
	function tableDB($value)
	{
		$rows = $this->getData($value);
		$value['headers'] = $this->getHeaders($value);
		$html1 = file_get_contents($this->path.'/modules/tableRow.html');
		$html2 = file_get_contents($this->path.'/modules/tableCol.html');
		$str = '';
		
		foreach($rows as $id => $row){
			$str1 = '';
			
			foreach($row as $key => $val){
				$cell = $val;
				if($value[$value['mode']]['types']){
					$cell = $this->fieldsDB([
						'value' => $val, 
						'id' => $row['id'], 
						'type' => $value[$value['mode']]['types'][$key]
					]);
					
					if($cell == '') continue;
				}
			
				$html21 = $html2;
				$html21 = str_ireplace('{value}', $cell, $html21);
				$str1 .= "$html21\n";
			}
			
			$html11 = $html1;
			$html11 = str_ireplace('{cols}', $str1, $html11);
			$str .= "$html11\n";
		}
		
		$value['rows'] = $str;
		$count = sizeof($rows);
		
		return [$value, $count];
	}
	
	function fieldsDB($data)
	{
		$req = new Request();
		$type = $data['type'];
		$res = '';
		
		if($type['name'] == 'hide') return '';
		if($type['name'] != 'text')
			$html = file_get_contents($this->path.'/modules/'.$type['name'].'.html');
		
		switch($type['name']) {
			case 'text': $res = $data['value'];break;
			case 'link':
				$res = str_ireplace(
					['{target}','{name}'], 
					[$req->get('alias').$data['type']['url'].$data['id'],$data['value']], 
					$html);
				break;
			case 'image': $res = str_ireplace('{link}', $data['value'], $html);break;
		}
		
		return $res;
	}
	
	function tablePager($value)
	{
		$pageCount = 0;
		
		if($value['rowCount']%$value['pageSize']>0)
			$pageCount = intdiv($value['rowCount'],$value['pageSize'])+1;
		else
			$pageCount = intdiv($value['rowCount'],$value['pageSize']);
		
		if($pageCount == 1) return '';
		
		$html1 = file_get_contents($this->path.'/modules/tablePager.html');
		$html2 = file_get_contents($this->path.'/modules/link.html');
		$str = '';
		$pageLink = '';
		
		foreach($_REQUEST as $key => $val)
			if(($key != 'p' and $key != 'alias') or $key == '0')
				$pageLink .= "&$key=$val";
			else if($key != 'p') $pageLink .= "$val";
		 
		for($i=1;$i<=$pageCount;$i++) {
			$html21 = $html2;
			$html21 = str_ireplace(['{target}','{name}'], ["&p=$i$pageLink",$i], $html21);
			$str .= $html21;
		}
		
		$html11 = $html1;
		$html11 = str_ireplace('{pagesLinks}', $str, $html11);
		
		return $html11;
	}
	
	function tableArrSort($rows, $sort)
	{
		$tmp = array();
		
		foreach($rows as $num => $row)
			foreach($row as $key => $col)
				$tmp[$key][$num] = $col;
		
		$str = '';
		
		foreach($tmp as $id => $value)
			if(key_exists($id, $sort))
				$str .= '$tmp['.($id).'], '.$sort[$id].',';
			else $str .= '$tmp['.($id).'],';
		
		$str = substr($str, 0, -1);
		
		eval("array_multisort($str);");
			
		foreach($tmp as $num => $row)
			foreach($row as $key => $col)
				$rows[$key][$num] = $col;
		
		return $rows;
	}
}
?>