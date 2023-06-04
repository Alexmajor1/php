<?php
namespace migrations;

use framework\migration;

class rules extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('name', 255)
			.$this->integer('role_id')
			.$this->foreignKey('role_id', 'roles')
			.$this->primaryKey('id');
	}
}
?>