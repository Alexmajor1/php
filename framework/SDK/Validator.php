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
		if(is_numeric(stripos($this->Data[$field], 'select')) and 
			is_numeric(stripos($this->Data[$field], 'from')))
			return true;
			
		if(is_numeric(stripos($this->Data[$field], 'insert')) and 
			is_numeric(stripos($this->Data[$field], 'into')) and 
			is_numeric(stripos($this->Data[$field], 'values')))
			return true;
			
		if(is_numeric(stripos($this->Data[$field], 'update')) and 
			is_numeric(stripos($this->Data[$field], 'set')))
			return true;
			
		return false;
	}
	
	function email($field)
	{
		return filter_var($this->Data[$field], FILTER_VALIDATE_EMAIL);
	}
}
?>