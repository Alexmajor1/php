<?php
namespace migrations;

use framework\migration;

class sessions extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('key', 255)
			.$this->integer('user_id')
			.$this->foreignKey('user_id', 'users')
			.$this->primaryKey('id');
	}
}
?>