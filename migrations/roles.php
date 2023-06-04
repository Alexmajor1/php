<?php
namespace migrations;

use framework\migration;

class roles extends migration
{
	function getFields()
	{
		return $this->id()
			.$this->string('name', 255)
			.$this->primaryKey('id');
	}
}
?>