<?php
namespace models;

use framework\Validator;

class Registration
{
	private $user;
	private $password;
	private $role;
	private $model;
	
	function __construct($db, $data)
	{
		$this->model = new User();
		$this->user = $data['login'];
		$this->password = $data['password'];
		$this->role = $data['role'];
	}
	
	function CheckUser()
	{
		return $this->model->read(['id_user'], ['user_name' => $this->user]);
	}
	
	function CheckPassword()
	{
		if(strlen($this->password)<10)
		{
			return 'password is short(>10)';
		}
		
		if(!preg_match('/[[:digit:]+]/', $this->password))
		{
			return 'password must contain digits';
		}
		
		if(!preg_match('/[[:alpha:]+]/', $this->password) or preg_match('/[[а-яА-я]+]/', $this->password))
		{
			return 'password must contain letters';
		}
		
		if(!preg_match('/[[:upper:]+]/', $this->password))
		{
			return 'password must contain uppercase letters';
		}
		
		if(preg_match('/[[:space:]+]/', $this->password))
		{
			return 'password should not contain spaces';
		}
		
		if(preg_match('/[[:punct:]+]/', $this->password))
		{
			return 'password should not contain punctuation';
		}
		
		return 'ok';
	}
	
	function validate($data)
	{
		$valid = new Validator($data);
		
		return $valid->sql('User') or $valid->sql('Password');
	}
	
	function execute()
	{
		if($this->CheckUser()) return 'this login is not available';
		if($res = $this->CheckPassword() !== 'ok') return $res;
		
		$role = new Role();
		$role_id = $role->read(['id_Role'], ['role_name' => $this->role])[0];
		
		return $this->model->create([
					'user_name' => $this->user, 
					'user_password' => md5($this->password), 
					'user_role' => $role_id[0]
				]);
	}
}
?>