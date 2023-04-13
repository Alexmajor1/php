<?php
namespace framework;

class DB
{
	private static $instances;
	private $cursor;
	
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
	
	function query($str)
	{
		return $this->cursor->query($str);
	}
	
	function LastInsert()
	{
		return $this->cursor->insert_id;
	}
	
	function Errors()
	{
		return $this->cursor->error_list;
	}
	
	function close()
	{
		$this->cursor->close();
	}
}
?>