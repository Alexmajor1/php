<?php
namespace models\editors;

use framework\ModelEditor;

class TopicEditor extends ModelEditor {
	function getUser($id)
	{
		$model = new \models\User();
		if($id != 0)
			return $model->read(['name' => 'User_name'], ['id' => $id])->name;
		else
			return $model->read(['name' => 'User_name'])->name;
	}
	
	function getTheme($id)
	{
		$model = new \models\Theme();
		if($id != 0)
			return $model->read(['name' => 'name'], ['id' => $id])->name;
		else
			return $model->read(['name' => 'name'])->name;
	}
}
?>