<?php
namespace models;

use framework\Validator;

class Registration
{
	private $user;
	private $password;
	private $role;
	private $model;
	
	function __construct($data)
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
		$res = '';
		
		if(strlen($this->password)<10)
		{
			$res .= 'password is short(>10)</br>';
		}
		
		if(!preg_match('/[[:digit:]+]/', $this->password))
		{
			$res .= 'password must contain digits</br>';
		}
		
		if(!preg_match('/[[:alpha:]+]/', $this->password) or preg_match('/[[а-яА-я]+]/', $this->password))
		{
			$res .= 'password must contain letters</br>';
		}
		
		if(!preg_match('/[[:upper:]+]/', $this->password))
		{
			$res .= 'password must contain uppercase letters</br>';
		}
		
		if(preg_match('/[[:space:]+]/', $this->password))
		{
			$res .= 'password should not contain spaces</br>';
		}
		
		if(preg_match('/[[:punct:]+]/', $this->password))
		{
			$res .= 'password should not contain punctuation</br>';
		}
		if(strlen($res) == 0)
			return 'ok';
		else
			return $res;
	}
	
	function validate($data)
	{
		$valid = new Validator($data);
		
		return $valid->sql('User') or $valid->sql('Password');
	}
	
	function execute()
	{
		if($this->CheckUser()) return 'this login is not available';
		
		$res = $this->CheckPassword();
		if($res !== 'ok') return $res;
		
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