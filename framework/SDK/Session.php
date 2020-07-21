<?php
namespace framework;

class Session
{
	private $db;
	private $options;
	private $user;
	
	function __construct($db, $options, $id = '')
	{
		$this->db = $db;
		$this->options = $options;
		$req = new Request();
		$this->user = $id;
		
		if($id == ''){
			$sql = "SELECT session_user FROM ".$options['source']." WHERE session_key = \"".$req->cookie($options['key']).'"';
			$this->user = $db->ValueQuery($sql);
		}
	}
	
	function create()
	{
		$req = new Request();
		
		if(!$req->cookie($this->options['key']))
		{
			$sess_id = '';
			$chars = 'abcdefghijklmnoprsqtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
			$len = strlen($chars);
	
			for($i=0;$i<10;$i++)
			{
				$sess_id .= substr($chars, rand(1, $len)-1, 1);
			}
			print_r($this->user[0]);
			$sql = "INSERT INTO ".$this->options['source']."(session_key, session_user) VALUES(\"$sess_id\", ".$this->user[0][0].")";
			$res = $this->db->ChangeQuery($sql);
			
			if(!$res)
			{
				return false;
			}
			
			setcookie($this->options['key'], $sess_id);
		}
	}
	
	function close()
	{
		$req = new Request();
		
		setcookie($this->options['key'], null, -1);
		
		$sql = "DELETE FROM ".$options['source']." WHERE session_key = \"".$req->cookie($options['key']).'"';
		$res = $this->db->ChangeQuery($sql);
		
	}
	
	function get_user_id()
	{
		return $this->user;
	}
	
	function get_id()
	{
		return $this->sess_key;
	}
	
	function getLogin()
	{
		$sql = 'SELECT user_name FROM users WHERE id_user = '.$this->user;
		
		return $this->db->ValueQuery($sql);
	}
	
	function getRole()
	{
		$sql = 'SELECT role_name FROM roles WHERE id_role in 
				(SELECT user_role FROM users WHERE id_user = '.$this->user[0][0].')';
		
		return $this->db->ValueQuery($sql);
	}
	
	function getPermissions()
	{
		$sql = 'SELECT rule_name FROM ruless WHERE id_rule in 
				(SELECT user_role FROM users WHERE id_user = '.$this->user.')';
		return $this->db->ValueQuery($sql);
	}
}
?>