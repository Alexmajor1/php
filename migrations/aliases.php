<?php
namespace migrations;

use framework\migration;

class aliases extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('name', 255)
			.$this->string('page', 255)
			.$this->primaryKey('id');
	}
}
?>