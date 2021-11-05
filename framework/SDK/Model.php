<?php
namespace framework;

class Model
{
	private $db;
	private $table;
	private $rows;
	private $iter;
	private $data;
	
	function __construct()
	{
		$this->db = DB::getInstance();
		$this->table = strtolower(explode('\\', get_called_class())[1]).'s';
	}
	
	function create($data)
	{
		$res = $this->db->insert($this->table, $data)->change();
		if($res){
			$res = $this->db->select($this->table, '*')->where(['id' => $this->db->LastInsert()])->one();
			if($res){
				$this->data = $res;
				return $this;
			}
		}
		return $res;
	}
	
	function read($data, $where = [])
	{
		$res = $this->db->select($this->table, $data);
		
		if(!empty($where)) $res->where($where,'AND');
		
		$data = $res->all();
		
		if($data){
			if(count($data) == 1) {
				$this->data = $data[0];
			} else {
				$this->iter = 0;
				$this->rows = $data;
				$this->data = $this->rows[$this->iter];
			}
			return $this;
		}
		return $data;
	}
	
	function update($data, $where = [])
	{
		$res = $this->db->update($this->table, $data);
		
		$passed = $res->change();
		
		if($passed) {
			$res = $this->db->select($this->table, '*');
		
			if(!empty($where)) $res->where($where,'AND');
			
			$data = $res->one();
			
			if($data) {
				$this->data = $data;
				if(isset($this->iter)) {
					$this->rows[$this->iter] = $this->data;
				}
				return true;
			}
		}
		
		return $passed;
	}
	
	function delete($where)
	{
		return $this->db->delete($this->table)->where($where, 'AND')->change();
	}
	
	function count()
	{
		if($this->rows){
			return count($this->rows);
		}elseif($this->data){
			return 1;
		}
		return false;
	}
	
	function editor($mods, $fields){
		$req = new Request();
		
		if($req->get('mode') == 'delete')
			return $this->delete(['id' => $req->get('id')]);
		elseif($req->get('id')){
			$data = $this->read($fields, ['id' => $req->get('id')]);
			
			foreach($fields as $key=>$value){ 
				$mods['form']['fields'][$value]['value'] = $data[$key];
			}
			
			$mods['form']['fields']['id'] = [
				'field_type' => 'hidden',
				'name' => 'id',
				'value' => $req->get('id'),
			];
			
			return $mods;
		}elseif(count($req->post())>0){
			$data = array();
			foreach($fields as $value)
				$data[$value] = $req->post($value);
			
			if($req->post('id')){
				return $this->update($data,['id' => $req->post('id')]);
			}else{
				return $this->create($data);
			}
			echo 'loose';
		}
	}
	
	function __get($key){
		if(key_exists($key, $this->data)) return $this->data[$key];
		return false;
	}
	
	function __set($key, $value){
		if(!key_exists($key, $this->data)) return false;
		$this->data[$key] = $value;
		return true;
	}
	
	function __isset($key){
		return key_exists($key, $this->data);
	}
	
	function __unset($key){
		if(!key_exists($key, $this->data)) return;
		unset($this->data[$key]);
		return true;
	}
}
?>