<?php
namespace library;

class Admin
{
	static function count($model, $name)
	{
		$count = $model->rowsCount();
		return "$name count: $count";
	}
	
	static function tablePages(&$ctrl, $model, $titles, $cols, $backward)
	{
		$layout = $ctrl->getProperty('layout');
		
		$ctrl->addConfig(['layout' => $model->getTitle($layout, $titles)]);
		$res = $model->editor($ctrl->mods, $cols);
		
		if(is_array($res)) $ctrl->mods = $res;
		elseif($res) $ctrl->toPage($backward);
	}
}
?>