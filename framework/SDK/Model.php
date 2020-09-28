<?php
namespace framework;

class Model
{
	private $db;
	private $table;
	
	function __construct($db)
	{
		$this->db = $db;
		$this->table = strtolower(explode('\\', get_called_class())[1]).'s';
	}
	
	function create($data)
	{
		return $this->db->insert($this->table, $data)->change();
	}
	
	function read($data, $where = [])
	{
		$res = $this->db->select($this->table, $data);
		
		if(!empty($where)) $res->where($where,'AND');
		
		return $res->all();
	}
	
	function update($data, $where = [])
	{
		$res = $this->db->update($this->table, $data);
		
		if(!empty($where)) $res->where($where,'AND');
		
		return $res->change();
	}
	
	function delete($where)
	{
		return $this->db->delete($this->table)->where($where, 'AND')->change();
	}
	
	function editor($mods, $fields){
		$req = new Request();
		
		if($req->get('mode') == 'delete')
			return $this->delete(['id' => $req->get('id')]);
		elseif($req->get('id')){
			$data = $this->read($fields, ['id' => $req->get('id')])[0];
			
			foreach($fields as $key=>$value)
				$mods['form']['fields'][explode('_',$value)[1]]['value'] = $data[$key];
			
			return $mods;
		}elseif($req->get('name')){
			$data = array();
			foreach($fields as $value)
				$data[$value] = $req->get(explode('_',$value)[1]);
			
			if($req->get('id')){
				return $this->update($data,['id' => $req->get('id')]);
			}else{
				return $this->create($data);
			}
		}
	}
}
?>