<?php
namespace models\editors;

use framework\ModelEditor;

class ThemeEditor extends ModelEditor {
	function getUser($id)
	{
		$model = new \models\User();
		if($id != 0)
			return $model->read(['name' => 'User_name'], ['id' => $id])->name;
		else
			return $model->read(['name' => 'User_name'])->name;
	}
	
	function getForum($id)
	{
		$model = new \models\Forum();
		if($id != 0)
			return $model->read(['name' => 'name'], ['id' => $id])->name;
		else
			return $model->read(['name' => 'name'])->name;
	}
}
?>