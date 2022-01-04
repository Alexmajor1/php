<?php
namespace framework;

class Validator
{
	private $Data;
	
	function __construct($Data)
	{
		$this->Data = $Data;
	}
	
	function numeric($field)
	{
		return is_numeric($this->Data[$field]);
	}
	
	function row($field)
	{
		return is_string($this->Data[$field]);
	}
	
	function void($field)
	{
		return empty($this->Data[$field]);
	}
	
	function sql($field)
	{
		$value = $this->Data[$field];
		
		return (stripos($value, 'select') !== false && 
			stripos($value, 'from') !== false) ||
			(stripos($value, 'insert') !== false && 
			stripos($value, 'into') !== false && 
			stripos($value, 'values') !== false) ||
			(stripos($value, 'update') !== false && 
			stripos($value, 'set') !== false);
	}
	
	function email($field)
	{
		return filter_var($this->Data[$field], FILTER_VALIDATE_EMAIL);
	}
}
?>