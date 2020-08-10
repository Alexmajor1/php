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
		$this->path = $_SERVER['DOCUMENT_ROOT'].'/'.$this->cfg->GetSetting('base').'/templates/'.$this->cfg->GetSetting('site_template');
		if(key_exists('fields', $this->data['value']))
			$data = $this->tableDB($this->data['value']);
		else
			$data = $this->tableArr($this->data['value']);
		$value = $data[0];
		if(key_exists('pager', $this->data['value']))
			$value['pager'] = $this->tablePager([
				'pageSize' => $this->data['value']['pager']['pageSize'],
				'rowCount' => $data[1]
			]);
		
		$this->html = $value;
		
	}
	
	function tableArr($value)
	{
		$str = '';
		$head_sort = array();
		$pageLink = '';
		foreach($_REQUEST as $key => $val)
			if((strstr('asc', $val) == false) and (strstr('desc', $val) == false))
			{
				if($key != 'alias')
					$pageLink .= "&$key=$val";
				else
					$pageLink .= "$val";
			}
			else{
				switch($val)
				{
					case 'asc':$head_sort[$key] = SORT_ASC;break;
					case 'desc':$head_sort[$key] = SORT_DESC;break;
				}
			}
		
		if(!empty($head_sort))
			$value['rows'] = $this->tableArrSort($value['rows'], $head_sort);
		
		$file = fopen($this->path.'/modules/tableHeader.html', "r");
		$html = fread($file, filesize($this->path.'/modules/tableHeader.html'));
		
		foreach($value['headers'] as $key => $val)
		{			
			$html1 = $html;
			if(count($head_sort) == 0){
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, "&$key=desc", $val], $html1);
				$str .= $html1."\n";
			}else{
				$str1 = '';
				foreach($value['headers'] as $key1 => $val1)
				{
					if($key1 == $key)
					{
						if(key_exists($key1, $head_sort))
						{
							switch($head_sort[$key1])
							{
								case SORT_ASC:$str1 .= "&$key1=desc";break;
								case SORT_DESC:$str1 .= "&$key1=asc";break;
							}
						}else{
							$str1 .= "&$key1=desc";
						}
					}else{
						if(key_exists($key1, $head_sort))
						{
							switch($head_sort[$key1])
							{
								case SORT_ASC:$str1 .= "&".($key1+1)."=asc";break;
								case SORT_DESC:$str1 .= "&".($key1+1)."=desc";break;
							}
						}
					}
				}
				$html1 = str_ireplace(['{pageLink}', '{sort}','{value}'], [$pageLink, $str1, $val], $html1);
				$str .= $html1."\n";
			}
		}
		
		$value['headers'] = $str;
			
		$str = '';
		$req = new Request(null);
		$num = (key_exists('page', $req->get()))?$req->get('page'):1;
		$end = $num*$value['pager']['pageSize'];
		$start = $end-$value['pager']['pageSize'];
		
		$file1 = fopen($this->path.'/modules/tableRow.html', "r");
		$html1 = fread($file1, filesize($this->path.'/modules/tableRow.html'));
		
		$file2 = fopen($this->path.'/modules/tableCol.html', "r");
		$html2 = fread($file2, filesize($this->path.'/modules/tableCol.html'));
		
		$str = '';
		for($i=$start;$i<$end;$i++)
		{
			$row = $value['rows'][$i];
			$str1 = '';
			foreach($row as $val)
			{
				if(!is_array($val)) 
				{
					$html21 = $html2;
					$html21 = str_ireplace('{value}', $val, $html21);
					
					$str1 .= "$html21\n";
				} else {
					$this->fields($val);
				}
			}
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
		switch($data['type']) {
			case 'text': $res = $data['value']['text'];break;
			case 'link': $res = '<a href = "'.$data['value']['url'].'">'.$data['value']['caption'].'</a>';break;
			case 'image': $res = '<img src = "'.$data['value']['url'].'">';break;
		}
		
		return $res;
	}
	
	function tableDB($value)
	{
		$str = '';
		$sql = 'select id, '.$value['fields'].' from '.$value[$value['mode']]['source'];
		
		if(key_exists('relation',$value[$value['mode']]))
		{
			$sql .= ' where '.$value[$value['mode']]['relation'].'='.$value[$value['mode']]['value'];
		}
		
		$order = 'order by ';
		foreach($_REQUEST as $key => $val)
			if($val == 'asc' or $val == 'desc')
				$order .= "$key $val,";
		if(strlen($order)> 9) $sql .= $order;
		
		$rows = $this->db->DataQuery($sql);
		
		$file = fopen($this->path.'/modules/tableHeader.html', "r");
		$html = fread($file, filesize($this->path.'/modules/tableHeader.html'));
		
		if(!key_exists('headers', $value[$value['mode']]))
		{
			$tmp = $this->db->FieldsDescriptors();
			foreach($tmp as $val)
			{
				$html1 = $html;
				$html1 = str_ireplace([/*'{pageLink}', '{sort}',*/'{value}'], [/*$pageLink, "&$key=desc",*/$val], $html1);
				$val1 = $val->name;
				$value['headers'] = $val1;
				$str .= $html1;
			}
		} else {
			foreach($value[$value['mode']]['headers'] as $val)
			{
				$html1 = $html;
				$html1 = str_ireplace([/*'{pageLink}', '{sort}',*/'{value}'], [/*$pageLink, "&$key=desc",*/ $val], $html1);
				$str .= $html1;
			}
		}
		$req = new Request(null);
		$num = '';
		if(key_exists('page', $req->get()))
			$num = $req->get('page');
		
		if($num>0){
			$page = $value['pageSize'];
			$offset = ($num*$page)-$page;
			$sql .= " limit $offset, $page";
		} else {
			$page = $value['pager']['pageSize'];
			$sql .= " limit $page";
		}
		$value['headers'] = $str;
		
		$file1 = fopen($this->path.'/modules/tableRow.html', "r");
		$html1 = fread($file1, filesize($this->path.'/modules/tableRow.html'));
		
		$file2 = fopen($this->path.'/modules/tableCol.html', "r");
		$html2 = fread($file2, filesize($this->path.'/modules/tableCol.html'));
		
		$str = '';
		foreach($rows as $id => $row)
		{
			$str1 = '';
			foreach($row as $key => $val)
			{
				if($key !== 0) {
					$cell = $val;
					
					if($value[$value['mode']]['types']){
						$cell = $this->fieldsDB(['value' => $val, 'id' => $row[0], 'type' => $value[$value['mode']]['types'][$key-1]]);
					}
				
					$html21 = $html2;
					$html21 = str_ireplace('{value}', $cell, $html21);
				
					$str .= "$html21\n";
				}
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
		
		if($type['name'] != 'text') {
			$file = fopen($this->path.'/modules/'.$type['name'].'.html', "r");
			$html = fread($file, filesize($this->path.'/modules/'.$type['name'].'.html'));
		}
		
		switch($type['name']) {
			case 'text': $res = $data['value'];break;
			case 'link': {
				$res = str_ireplace(['{target}','{name}'], [$req->get('alias').$data['type']['url'].$data['id'],$data['value']], $html);
				}break;
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
		
		$file1 = fopen($this->path.'/modules/tablePager.html', "r");
		$html1 = fread($file1, filesize($this->path.'/modules/tablePager.html'));
		
		$file2 = fopen($this->path.'/modules/link.html', "r");
		$html2 = fread($file2, filesize($this->path.'/modules/link.html'));
		
		$str = '';
		$pageLink = '';
		
		foreach($_REQUEST as $key => $val)
		{
			if(($key != 'page' and $key != 'alias') or $key == '0')
			{
				$pageLink .= "&$key=$val";
			}
			else if($key != 'page')
				$pageLink .= "$val";
		}
		 
		for($i=1;$i<=$pageCount;$i++)
		{
			$html21 = $html2;
			$html21 = str_ireplace(['{target}','{name}'], ["$pageLink&page=$i",$i], $html21);
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
		{
			if(key_exists($id, $sort))
			{
				$str .= '$tmp['.($id).'], '.$sort[$id].',';
			}else
			{
				$str .= '$tmp['.($id).'],';
			}
		}
		
		$str = substr($str, 0, -1);
		
		eval("array_multisort($str);");
			
		foreach($tmp as $num => $row)
			foreach($row as $key => $col)
				$rows[$key][$num] = $col;
		
		return $rows;
	}
}
?>