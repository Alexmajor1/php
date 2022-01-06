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
		$valid = new Validator(['password' => $this->password]);
		
		$res = $valid->checkWithMsg(
			!$valid->lenght('password', 10)
			'password is short(>10)</br>'
		);
		$res .= $valid->checkWithMsg(
			!$valid->content('password', 'digit')
			'password must contain digits</br>'
		);
		$res .= $valid->checkWithMsg(
			!$valid->content('password', 'alpha')
			'password must contain letters</br>'
		);
		$res .= $valid->checkWithMsg(
			!$valid->content('password', 'upper')
			'password must contain uppercase letters</br>'
		);
		$res .= $valid->checkWithMsg(
			$valid->content('password', 'space')
			'password should not contain spaces</br>'
		);
		$res .= $valid->checkWithMsg(
			$valid->content('password', 'punct')
			'password should not contain punctuation</br>'
		);
		
		if(strlen($res) == 0)
			return 'ok';
		else
			return $res;
	}
	
	function validate($data)
	{
		$valid = new Validator($data);
		
		return $valid->sql('User') || $valid->sql('Password');
	}
	
	function execute()
	{
		if($this->CheckUser()) return 'this login is not available';
		
		$res = $this->CheckPassword();
		
		if($res !== 'ok') return $res;
		
		$role = new Role();
		$role_id = $role->read(['id_Role'], ['role_name' => $this->role])->id;
		
		return $this->model->create([
					'user_name' => $this->user, 
					'user_password' => md5($this->password), 
					'user_role' => $role_id
				]);
	}
}
?>