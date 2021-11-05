<?php
namespace framework;

class Plugin
{
	public $data;
	public $html;
	
	function __construct($data)
	{
		$this->data = $data;
	}
	
	function show()
	{
		$this->generate();
		return $this->html;
	}
}
?>