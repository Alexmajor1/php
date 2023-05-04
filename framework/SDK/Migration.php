<?php
namespace framework;

class Migration 
{
	protected $name;
	protected $db;
	function __construct($con)
	{
		$arr = explode('\\', get_called_class());
		$this->name = strtolower(end($arr));
		$this->db = DB::getInstance($con);
	}
	
	function id()
	{
		return '`id` int(11) NOT NULL AUTO_INCREMENT, ';
	}
	
	function primaryKey($name)
	{
		return "PRIMARY KEY (`$name`)";
	}
	
	function foreignKey($field, $target)
	{
		return "FOREIGN KEY (`$field`) REFERENCES `$target` (`id`), ";
	}
	
	function string($name, $size=0)
	{
		if($size == 0)
			return "`$name` varchar, ";
		else
			return "`$name` varchar($size), ";
	}
	
	function integer($name, $size=0)
	{
		if($size == 0)
			return "`$name` int, ";
		else
			return "`$name` int($size), ";
	}
	
	function create($engine, $charset)
	{
		return (new Query())->changeQuery('CREATE TABLE '.
			$this->name.'('.$this->getFields().
			")ENGINE=$engine DEFAULT CHARSET=$charset;");
	}
	
	function delete()
	{
		return (new Query())->changeQuery("DROP TABLE ".$this->name);
	}
}
?>