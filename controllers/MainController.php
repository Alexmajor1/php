<?php
namespace Controllers;

use framework\Controller;
use framework\Request;
use framework\Validator;
use framework\Session;

use models\Authorization;
use models\Registration;
use models\Cabinet;

class MainController extends Controller
{
	function authorization()
	{
		$req = new Request();
		
		if(key_exists('token', $req->cookie()))
		{
			$sess = new Session($this->db, $this->getProperty('session'), $auth->getUserByToken());
			$sess->create();
			$this->toPage('cabinet');
		}
		if($this->page->name == 'authorization' and $req->post('User'))
		{
			$valid = new Validator($req->post());
			
			if($valid->sql('User') or $valid->sql('Password'))
			{
				echo 'sql injection has detected';
				return;
			}
			
			$auth = new Authorization($req, $this->db);
			
			if($auth->remember)
			{
				$auth->setUserToken();
			}
			
			if($auth->Execute($this->getProperty('session')))
			{
				$sess = new Session($this->db, $this->getProperty('session'), $auth->user);
				$sess->create();
				if($sess->getRole() == 'Admin')
				{
					$this->toPage('admin/main');
				}
				else $this->toPage('cabinet');
			} else
			{
				$this->toPage('main');
			}
		}
	}
	
	function registration()
	{
		$req = new Request();
		
		if($this->page->name == 'registration' and $req->post('user'))
		{
			$valid = new Validator($req->post());
			if($valid->sql('user') or $valid->sql('password'))
			{
				echo 'sql injection has detected';
				return;
			}
			
			$reg = new Registration($req->post());
			
			if($res = $reg->execute($this->db))
			{
				if(is_string($res)) echo $res; else $this->toPage('main');
			} else
			{
				echo 'error';
			}
		}
	}
	
	function logout()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($this->db, $settings);
		$sess->close();
		
		$this->toPage('main');
	}
	
	function cabinet()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($this->db, $settings);
		
		if($sess->getLogin() == '') $this->toPage('main');
		
		$cab = new Cabinet($sess, $this->mods);
		$req = new Request();
		
		$cab->forumUpdate($req, $this->db);
		$this->mods = $cab->mods;
	}
}
?>