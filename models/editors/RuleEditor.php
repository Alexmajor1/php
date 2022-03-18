<?php
namespace models\editors;

use framework\ModelEditor;

class RuleEditor extends ModelEditor {
	function getRole($id)
	{
		$model = new \models\Role();
		if($id != 0)
			return $model->read(['name' => 'Role_name'], ['id' => $id])->name;
		else
			return $model->read(['name' => 'Role_name'])->name;
	}
}
?>