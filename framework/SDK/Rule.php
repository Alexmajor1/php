<?php
namespace framework;

class Rule
{
	public $ctrl;
	public $path;
	
	function __construct($ctrl)
	{
		$this->ctrl = $ctrl;
	}
}
?>