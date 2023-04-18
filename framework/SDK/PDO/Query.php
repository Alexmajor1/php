<?php
namespace framework\PDO;

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
		
		return $this->query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	function RowQuery($str)
	{
		$this->query = $this->db->query($str);
		
		if(!$this->query) return [];
		
		return $this->query->fetchAll(PDO::FETCH_ASSOC)[0];
	}
	
	function ValueQuery($str)
	{
		$this->query = $this->db->query($str);
		
		if(!$this->query) return null;
		
		return $this->query->fetchColumn();
	}
	
	function ChangeQuery($str)
	{
		$this->query = $this->db->exec($str);
		
		return $this->query;
	}
	
 	function FieldsDescriptors()
	{
		$result = [];
		
		for($id = 0; $id < $this->query->columnCount();$id++)
			$result[$id] = $this->query->getColumnMeta($id)['name'];
		
		return $result;
	}
	
	function RowsCount()
	{
		return $this->query->rowCount();
	}
	
	function ColsCount()
	{
		return $this->query->columnCount();
	}
	
	function LastInsert()
	{
		return $this->db->LastInsert();
	}
	
	function Clear()
	{
		$this->query->closeCursor();
	}
	
	function Errors()
	{
		return $this->db->Errors();
	}
}
?>