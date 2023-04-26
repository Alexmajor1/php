<?php
namespace framework;

trait Editor
{	
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
			foreach($fields as $value){
				if(method_exists($this, 'get'.ucfirst($mods['form']['fields'][$value]['name']))) {
					$method = 'get'.ucfirst($mods['form']['fields'][$value]['name']);
					$mods['form']['fields'][$value]['value'] = $this->$method($data->$value);
				} else
					$mods['form']['fields'][$value]['value'] = $data->$value;
			}
			
			$mods['form']['fields']['id'] = [
				'field_type' => 'hidden',
				'name' => 'id',
				'value' => $req->get('id'),
			];
			
			return $mods;
		}elseif(count($req->post())>0){
			$data = $req->post();
			unset($data['id']);
			
			if($req->post('id'))
				return $this->update($data,['id' => $req->post('id')]);
			else return $this->create($data);
		} elseif($req->get('mode') == 'form') {
			foreach($fields as $id => $value)
				if(method_exists($this, 'get'.ucfirst($mods['form']['fields'][$value]['name']))) {
					$method = 'get'.ucfirst($mods['form']['fields'][$value]['name']);
					$mods['form']['fields'][$value]['value'] = $this->$method(0);
				} else
					$mods['form']['fields'][$value]['value'] = '';
		}
	}
}
?>