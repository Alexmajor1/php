<?php
namespace framework;

class DB
{
	private static $instances;
	private $cursor;
	private $query;
	private $sql;
	
	protected function __construct($ConData)
	{
		$this->cursor = new \mysqli($ConData['host'], $ConData['user'], $ConData['password'], $ConData['db']);
	}
	
	protected function __clone(){}
	
	public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
	
	public static function getInstance($ConData = [])
	{
		$subclass = static::class;
		
        if (!isset(self::$instances[$subclass]))
			self::$instances[$subclass] = new static($ConData);
		
		return self::$instances[$subclass];
	}
	
	function close()
	{
		$this->cursor->close();
	}
	
	function DataQuery($str) {
		$this->query = $this->cursor->query($str);
		
		if(!$this->query) return [];
		
		return $this->query->fetch_all(MYSQLI_ASSOC);
	}
	
	function RowQuery($str)
	{
		$this->query = $this->cursor->query($str);
		
		if(!$this->query) return [];
		
		return $this->query->fetch_row();
	}
	
	function ValueQuery($str)
	{
		$this->query = $this->cursor->query($str);
		
		if(!$this->query) return null;
		
		return $this->query->fetch_row()[0];
	}
	
	function ChangeQuery($str)
	{
		$this->query = $this->cursor->query($str);
		
		return $this->query;
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
		return $this->DataQuery($this->sql);
	}
	
	function one()
	{
		return $this->RowQuery($this->sql);
	}
	
	function value()
	{
		return $this->ValueQuery($this->sql);
	}
	
	function change()
	{
		return $this->ChangeQuery($this->sql);
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
		return $this->cursor->insert_id;
	}
	
	function Clear()
	{
		$this->query->free();
	}
	
	function Errors()
	{
		return $this->cursor->error_list;
	}
}
?>