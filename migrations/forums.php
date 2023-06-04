<?php
namespace migrations;

use framework\migration;

class forums extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('title', 255)
			.$this->integer('user_id')
			.$this->foreignKey('user_id', 'users')
			.$this->primaryKey('id');
	}
}
?>