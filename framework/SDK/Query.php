<?php
namespace framework;

class Query
{
	private $db;
	private $query;
	
	function __construct()
	{
		$this->db = DB::getInstance();
	}
	
	function DataQuery($str) {
		$this->query = $this->db->query($str);
		
		if(!$this->query) return [];
		
		return $this->query->fetch_all(MYSQLI_ASSOC);
	}
	
	function RowQuery($str)
	{
		$this->query = $this->db->query($str);
		
		if(!$this->query) return [];
		
		return $this->query->fetch_row();
	}
	
	function ValueQuery($str)
	{
		$this->query = $this->db->query($str);
		
		if(!$this->query) return null;
		
		return $this->query->fetch_row()[0];
	}
	
	function ChangeQuery($str)
	{
		$this->query = $this->db->query($str);
		
		return $this->query;
	}
	
 	function FieldsDescriptors()
	{
		return $this->query->fetch_fields();
	}
	
	function RowsCount()
	{
		return $this->query->num_rows();
	}
	
	function ColsCount()
	{
		return $this->query->field_count($this->query);
	}
	
	function LastInsert()
	{
		return $this->db->LastInsert();
	}
	
	function Clear()
	{
		$this->query->free();
	}
	
	function Errors()
	{
		return $this->db->Errors();
	}
}
?>