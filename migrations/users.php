<?php
namespace migrations;

use framework\migration;

class users extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('name', 16)
			.$this->string('password', 32)
			.$this->string('remember', 10)
			.$this->integer('role_id')
			.$this->foreignKey('role_id', 'roles')
			.$this->primaryKey('id');
	}
}
?>