<?php
namespace migrations;

use framework\migration;

class test extends migration
{
	function getFields()
	{
		return $this->id().$this->string('text', 255).$this->primaryKey('id');
	}
}
?>