<?php
namespace Controllers;

use framework\Controller;
use framework\Request;
use framework\Session;

use models\Authorization;
use models\Registration;
use models\Cabinet;

class MainController extends Controller
{
	public $rule = 'CabinetRule';
	
	function authorization()
	{
		$req = new Request();
		
		if(key_exists('token', $req->cookie()))
		{
			$sess = new Session($this->db, $this->getProperty('session'), $auth->getUserByToken());
			$sess->create();
			$this->toPage('cabinet');
		}
		
		if((strcmp($this->page->name, 'authorization') == 0) and $req->post('User'))
		{
			$auth = new Authorization($req, $this->db);
			
			if($auth->validate($req->post()))
			{
				$this->getError('sql injection has detected');
				$this->toPage('main');
			}
			
			if($auth->remember)
			{
				$auth->setUserToken();
			}
			
			if($auth->Execute($this->getProperty('session')))
			{
				if($auth->isAdmin($this->getProperty('session')))
				{
					$this->toPage('admin\\\\main');
				}
				else{
					$this->toPage('cabinet');
				}
			} else
			{
				$this->toPage('main');
			}
		}
	}
	
	function registration()
	{
		$req = new Request();
		
		if((strcmp($this->page->name, 'registration') == 0) and $req->post('login'))
		{
			$reg = new Registration($this->db, $req->post());
			
			if($auth->validate($req->post()))
			{
				$this->mods['form']['fields']['status']['text'] = 'sql injection has detected';
				return;
			}
			
			if($res = $reg->execute())
			{
				if(is_string($res)) {$this->mods['form']['fields']['status']['text'] = $res;} else {$this->toPage('main');}
			} else
			{
				$this->mods['form']['fields']['status']['text'] = 'error';
			}
		}
	}
	
	function logout()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($this->db, $settings);
		$sess->close();
		
		session_destroy();
		
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