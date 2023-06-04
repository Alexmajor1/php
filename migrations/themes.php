<?php
namespace migrations;

use framework\migration;

class themes extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('title', 255)
			.$this->integer('user_id')
			.$this->integer('forum_id')
			.$this->foreignKey('user_id', 'users')
			.$this->foreignKey('forum_id', 'forums')
			.$this->primaryKey('id');
	}
}
?>