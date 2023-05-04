<?php
namespace models;

use framework\Model;
use framework\Editor;

class Topic extends Model
{
	use editor;
	
	function getUser($id)
	{
		$model = new \models\User();
		if($id != 0)
			return $model->read(['value' => 'id', 'name' => 'User_name'], ['id' => $id])->name;
		else
			return $model->read(['value' => 'id', 'name' => 'User_name'])->name;
	}
	
	function getTheme($id)
	{
		$model = new \models\Theme();
		if($id != 0)
			return $model->read(['value' => 'id', 'name' => 'name'], ['id' => $id])->name;
		else
			return $model->read(['value' => 'id', 'name' => 'name'])->name;
	}
}
?>