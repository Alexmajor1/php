<?php
namespace framework;

class Model
{
	protected $builder;
	protected $table;
	protected $rows;
	protected $iter;
	protected $data;
	protected $cache;
	
	function __construct()
	{
		$this->builder = new QueryBuilder();
		$this->cache = Cache::getInstance();
		$arr = explode('\\', get_called_class());
		$this->table = strtolower(end($arr)).'s';
	}
	
	function create($data)
	{
		$res = $this->builder->insert($this->table, $data)->change();
		
		if($res){
			$res = $this->builder->select($this->table, ['*'])->where(['id' => $this->builder->LastInsert()])->one();
			
			if($res){
				$this->cache->append($this->table.'_'.$res['id'], $res);
				$this->data = $res;
				
				return $this;
			}
		}
		return $res;
	}
	
	function read($data, $where = [])
	{
		if(key_exists('id', $where))
			$cache = $this->cache->read($this->table.'_'.$where['id']);
		elseif(count($where) > 0)
			$cache = $this->cache->read($this->table.'_filter_'.array_keys($where)[0].'_'.array_values($where)[0]);
		else
			$cache = $this->cache->read($this->table.'_all');
					
		if(!$cache){
			$res = $this->builder->select($this->table, $data);
			
			if(!empty($where)) $res->where($where,'AND');
			
			$data = $res->all();
			
			if($data)
				if(key_exists('id', $where))
					$cache = $this->cache->append($this->table.'_'.$where['id'], $data);
				elseif(count($where) > 0)
					$cache = $this->cache->append($this->table.'_filter_'.array_keys($where)[0].'_'.array_values($where)[0], $data);
				else
					$cache = $this->cache->append($this->table.'_all', $data);
		} else {
			$data = $cache;
		}
		
		if(is_array($data) && count($data) > 0){
			if(!key_exists(0, $data)) {
				$this->data = $data;
				$this->rows = $data;
			} else {
				$this->iter = 0;
				$this->rows = $data;
				$this->data = $this->rows[$this->iter];
			}
			return $this;
		}
		return false;
	}
	
	function update($data, $where = [])
	{
		$res = $this->builder->update($this->table, $data)->where($where);
		$passed = $res->change();
		
		if($passed) {
			$res = $this->builder->select($this->table, '*');
		
			if(!empty($where)) $res->where($where,'AND');
			
			$data = $res->one();
			
			if($data) {
				if(key_exists('id', $where))
					$cache = $this->cache->append($this->table.'_'.$where['id'], $data);
				elseif(count($where) > 0)
					$cache = $this->cache->append($this->table.'_filter_'.array_keys($where)[0].'_'.array_values($where)[0], $data);
				else
					$cache = $this->cache->append($this->table.'_all', $data);
					
				$this->data = $data;
				if(isset($this->iter))
					$this->rows[$this->iter] = $this->data;
				
				return true;
			}
		}
		
		return $passed;
	}
	
	function delete($where)
	{
		if(key_exists('id', $where))
			$cache = $this->cache->erase($this->table.'_'.$where['id']);
		else
			$cache = $this->cache->erase($this->table.'_filter_'.array_keys($where)[0].'_'.array_values($where)[0]);
			
		return $this->builder->delete($this->table)->where($where, 'AND')->change();
	}
	
	function count()
	{
		if($this->rows)
			return count($this->rows);
		elseif($this->data)
			return 1;
		
		return false;
	}
	
	function toArray()
	{
		return $this->rows;
	}
	
	function __get($key)
	{
		if(key_exists($key, $this->data)) return $this->data[$key];
		
		return false;
	}
	
	function __set($key, $value)
	{
		if(!key_exists($key, $this->data)) return false;
		
		$this->data[$key] = $value;
		
		return true;
	}
	
	function __isset($key)
	{
		return key_exists($key, $this->data);
	}
	
	function __unset($key)
	{
		if(!key_exists($key, $this->data)) return;
		
		unset($this->data[$key]);
		
		return true;
	}
}
?>