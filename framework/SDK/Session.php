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
			$this->user = $db->select($options['source'], ['session_user' => 'session_user'])->where(['session_key' => $req->cookie($options['key'])], '')->value();
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
			
			$res = $this->db->insert($this->options['source'], ['session_key' => $sess_id,'session_user' => $this->user[0][0]])->change();
			
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
		
		$res = $this->db->delete($options['source'])->where(['session_key' => $req->cookie($options['key'])], '')->ChangeQuery($sql);
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
		return $this->db->select('users', ['user_name' => 'user_name'])->where(['id' => $this->user[0][0]], '')->value();
	}
	
	function getRole()
	{
		return $this->db->select('roles, users', ['role_name' =>'role_name'])->where(['users.id' => $this->user[0][0], 'roles.id' => ['user_role']], 'AND')->value();
	}
	
	function getPermissions()
	{
		return $this->db->select('rules, users', ['rule_name' => 'rule_name'])->where(['Rule_role' => ['user_role'], 'users.id' => $this->user[0][0]], 'AND')->all();
	}
}
?>