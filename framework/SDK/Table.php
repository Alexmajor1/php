<?php
namespace framework;

class Table
{
	public $html;
	private $db;
	
	function __construct($value, $db)
	{
		$this->db = $db;
		if(key_exists('fields', $value))
			$data = $this->tableDB($value);
		else
			$data = $this->tableArr($value);
		$value = $data[0];
		if(key_exists('pager', $value))
			$value['pager'] = $this->tablePager([
				'pageSize' => $value['pager']['pageSize'],
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
		
		foreach($value['headers'] as $key => $val)
		{
			if(count($head_sort) == 0)
				$str .= "<th><a href = \"$pageLink&$key=desc\">$val</a></th>\n";
			else{
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
				$str .= "<th><a href = \"$pageLink$str1\">$val</a></th>\n";
			}
		}
		
		$value['headers'] = $str;
			
		$str = '';
		$req = new Request(null);
		$num = (key_exists('page', $req->get()))?$req->get('page'):1;
		$end = $num*$value['pager']['pageSize'];
		$start = $end-$value['pager']['pageSize'];
		
		for($i=$start;$i<$end;$i++)
		{
			$row = $value['rows'][$i];
			$str .= "<tr>\n";
			
			foreach($row as $val)
			{
				if(!is_array($val)) 
				{
					$str .= "<td>$val</td>\n";
				} else {
					$this->fields($val);
				}
			}
			$str .= "<tr>\n";
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
		$sql = 'select '.$value['fields'].' from '.$value[$value['mode']]['source'];
		
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
		
		if(!key_exists('headers', $value[$value['mode']]))
		{
			$tmp = $this->db->FieldsDescriptors();
			foreach($tmp as $val)
			{
				$val1 = $val->name;
				$value['headers'] = $val1;
				$str .= "<th>$val1</th>";
			}
		} else {
			foreach($value[$value['mode']]['headers'] as $val)
			{
				$str .= "<th>$val</th>";
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
		$str = '';
		foreach($rows as $id => $row)
		{
			$str .= '<tr>';
			foreach($row as $key => $val)
			{
				$cell = $val;
				if($value[$value['mode']]['types']){
					$cell = $this->fieldsDB(['value' => $val, 'id' => $id, 'key' => $key, 'type' => $value[$value['mode']]['types'][$key]]);
				}
				$str .= "<td>$cell</td>\n";
			}
			$str .= '</tr>';
		}
		$value['rows'] = $str;
		$count = sizeof($rows);
		return [$value, $count];
	}
	
	function fieldsDB($data)
	{
		$req = new Request();
		$type = $data['type'];
		
		switch($type['name']) {
			case 'text': $res = $data['value'];break;
			case 'link': {
				$res = '<a href = "'.$req->get('alias').$data['type']['url'].$data['id'].'">'.$data['value'].'</a>';
				}break;
			case 'image': $res = '<img src = "'.$data['value'].'">';break;
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
		
		$str = '<div id="pager" class="block">';
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
			$str .= "<a href=\"$pageLink&page=$i\">$i</a>";
		
		return $str.'</div>';
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