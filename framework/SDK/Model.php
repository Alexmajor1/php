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
		
		return $res->all();
	}
	
	function delete($where)
	{
		return $this->db->delete($this->table)->where($where, 'AND')->change();
	}
}
?>