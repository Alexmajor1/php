<?php
namespace framework;

class ModelEditor extends Model
{
	function __construct()
	{
		$this->db = DB::getInstance();
		$arr = explode('\\', str_ireplace('Editor', '', get_called_class()));
		$this->table = strtolower(end($arr)).'s';
	}
	
	function rowsCount()
	{
		return $this->read(['id'])->count();
	}
	
	function getTitle($layout, $title)
	{
		$req = new Request();
		$mode = $req->get('mode');
		$id = $req->get('id');
		
		if($mode) {
			if($id) $layout['title'] = $title['edit'];
			else $layout['title'] = $title['add'];
		} else $layout['title'] = $title['main'];
		
		return $layout;
	}
	
	function editor($mods, $fields){
		$req = new Request();
		
		if($req->get('mode') == 'delete')
			return $this->delete(['id' => $req->get('id')]);
		elseif($req->get('id')){
			$data = $this->read($fields, ['id' => $req->get('id')]);
			
			foreach($fields as $value)
				$mods['form']['fields'][$value]['value'] = $data->$value;
			
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
			
			if($req->post('id'))
				return $this->update($data,['id' => $req->post('id')]);
			else return $this->create($data);
		}
	}
}
?>