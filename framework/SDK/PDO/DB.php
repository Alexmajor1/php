<?php
namespace framework\PDO;

class DB 
{
	private static $instances;
	private $cursor;
	
	protected function __construct($ConData)
	{
		$this->cursor = PDO($ConData['driver'].':dbname='.$ConData['db'].';'.$ConData['host'], , $ConData['user'], $ConData['password']);
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
		return $this->cursor->lastInsertId;
	}
	
	function Errors()
	{
		$err = $this->cursor->errorInfo();
		return 'SQLSTATE['.$err[0].']: Syntax error or access violation: '.$err[1].' '.$err[2];
	}
	
	function close()
	{
		$this->cursor = null;
	}
}
?>