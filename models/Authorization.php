<?php
namespace models;

use framework\Request;
use framework\Session;
use framework\Validator;

class Authorization
{
	private $request;
	public $user;
	private $password;
	public $remember;
	private $model;
	
	function __construct()
	{
		$this->model = new User();
		$this->request = new Request();
		$this->user = $this->request->post('User');
		$this->password = $this->request->post('Password');
		$this->remember = $this->request->post('Remember');
	}
	
	function getUserByToken()
	{
		$res = $this->model->read(
			['user_name'], 
			['user_remember' => $this->request->cookie('token')]
		);
		
		if($res)
			return $res->one();
		else
			return false;
	}
	
	function setUserToken()
	{
		$token = '';
		$chars = 'abcdefghijklmnoprsqtuvwxyz'+
			'ABCDEFGHIJKLMNOPQRSTUVWXYZ'+
			'01234567890';
		$len = strlen($chars);

		for($i=0;$i<10;$i++)
			$token .= substr($chars, rand(1, $len)-1, 1);
		
		$res = $this->model->update(
			['user_remember', $token], 
			['user_name' => $this->user]
		);
		
		if($res)
			setcookie('token', $token);
	}
	
	function validate($data)
	{
		$valid = new Validator($data);
		
		return $valid->sql('User') or $valid->sql('Password');
	}
	
	function isAdmin($conf)
	{
		$sess = new Session($conf, $this->user);
		$sess->create();
		
		return $sess->getRole() == 'Admin';
	}
	
	function Execute($cfg)
	{	
		$sess = new Session($cfg);
		
		if(!$sess->checkToken($this->request->post('_csrf_token')))
			return false;
		
		$this->user = $sess->get_user_id();
		if($this->request->cookie($cfg['key']))
			return ($this->user != null);
		
		if(!$this->user)
			$this->user = $this->model->read(
				['id'], 
				[
					'user_name' => $this->request->post('User'), 
					'user_password' => md5($this->password)
				]
			);
		
		return ($this->user);
	}
}
?>