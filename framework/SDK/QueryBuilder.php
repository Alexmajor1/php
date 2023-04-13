<?php
namespace framework;

class QueryBuilder
{
	private $cursor;
	private $sql;
	
	function __construct()
	{
		$this->query = new Query();
	}
	
	function insert($table, $data)
	{
		$this->sql = "INSERT INTO $table";
		$fields = '(';
		$values = '(';
		
		foreach($data as $field => $value) {
			$fields .= "$field, ";
			
			if(!is_numeric($value)) $values .= "\"$value\", ";
			else $values .= "$value, ";
		}
		
		$fields = substr_replace($fields, ')', strlen($fields)-2,1);
		$values = substr_replace($values, ')', strlen($values)-2,1);
		$this->sql .= "$fields VALUES$values";
		
		return $this;
	}
	
	function select($table, $data)
	{
		$this->sql = 'SELECT';
		
		if($data != '*')
			foreach($data as $alias => $field)
				if(!is_numeric($alias)) $this->sql .= " $field as $alias,";
				else $this->sql .= " $field,";
		
		$this->sql = substr_replace($this->sql, " FROM $table", strlen($this->sql)-1,1);
		
		return $this;
	}
	
	function update($table, $data)
	{
		$this->sql = "UPDATE $table SET";
		
		foreach($data as $field => $value)
			if(!is_numeric($value)) $this->sql .= " $field=\"$value\",";
			else $this->sql .= " $field=$value,";
		
		$this->sql = substr_replace($this->sql, '', strlen($this->sql)-1,1);
		
		return $this;
	}
	
	function delete($table)
	{
		$this->sql = "DELETE FROM $table";
		
		return $this;
	}
	
	function where($conditions, $operation = '')
	{
		$this->sql .= ' WHERE';
		
		foreach($conditions as $field => $value)
			if(is_array($value)) $this->sql .= " $field=".$value[0]." $operation";
			elseif(!is_numeric($value)) $this->sql .= " $field=\"$value\" $operation";
			else $this->sql .= " $field=$value $operation";
		
		$this->sql = substr_replace(
			$this->sql, 
			'', 
			strlen($this->sql)-strlen($operation), 
			strlen($operation));
			
		return $this;
	}
	
	function all()
	{
		return $this->query->DataQuery($this->sql);
	}
	
	function one()
	{
		return $this->query->RowQuery($this->sql);
	}
	
	function value()
	{
		return $this->query->ValueQuery($this->sql);
	}
	
	function change()
	{
		return $this->query->ChangeQuery($this->sql);
	}
}
?>