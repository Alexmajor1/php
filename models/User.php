<?php
namespace models;

use framework\Model;
use framework\Editor;

class User extends Model
{
	use editor;
	
	function getRole($id)
	{
		$model = new \models\Role();
		if($id != 0){
			return $model->read(['name' => 'Role_name'], ['id' => $id])->name;
		}else
			return $model->read(['name' => 'Role_name'])->name;
	}
}
?>