<?php
namespace migrations;

use framework\migration;

class topics extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('text', 255)
			.$this->integer('user_id')
			.$this->integer('theme_id')
			.$this->foreignKey('user_id', 'users')
			.$this->foreignKey('theme_id', 'themes')
			.$this->primaryKey('id');
	}
}
?>