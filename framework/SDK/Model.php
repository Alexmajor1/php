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
				echo 'update';
				return $this->update($data,['id' => $req->post('id')]);
			}else{
				echo 'create';
				return $this->create($data);
			}
			echo 'loose';
		}
	}
}
?>