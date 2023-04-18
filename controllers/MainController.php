<?php
namespace Controllers;

use framework\Controller;
use framework\Request;
use framework\Session;

use models\Authorization;
use models\Registration;
use models\Cabinet;

use migrations\test;

use library\General;

class MainController extends Controller
{
	public $rules = ['Auth', 'Cabinet'];
	public $widgets = ['PageFooter'];
	
	function authorization()
	{
		$req = new Request();
		$auth = new Authorization();
		
		if($res = $auth->validate($req->post())) {
			$this->getError('sql injection has detected');
			$this->toPage('main');
		}
		
		if($auth->remember)
			$auth->setUserToken();
		
		if($auth->Execute($this->getProperty('session'))) {
			if($auth->isAdmin($this->getProperty('session')))
				$this->toPage('admin\\\\main');
			else $this->toPage('cabinet');
		} else {
			$this->getError('wrong login or password');
			$this->toPage('main');
		}
		
	}
	
	function registration()
	{
		General::getTitle($this, 'Registration');
		
		$req = new Request();
		
		if((strcmp($this->page->name, 'registration') == 0) and $req->post('login')) {
			$reg = new Registration($req->post());
			
			if($reg->validate($req->post())) {
				$this->getError('sql injection has detected');
				$this->toPage('registration');
			}
			
			if($res = $reg->execute())
				if(is_string($res)) {
					$this->getError($res);
					$this->toPage('registration');
				} else $this->toPage('main');
			
			$this->getError('error');
			$this->toPage('registration');
		}
	}
	
	function logout()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($settings);
		$sess->close();
		
		session_destroy();
		
		$this->toPage('main');
	}
	
	function cabinet()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($settings);
		if($sess->getLogin() == '') $this->toPage('main');
		
		$cab = new Cabinet($sess, $this->mods);
		$req = new Request();
		
		$cab->forumUpdate($req);
		
		$layout = $this->getProperty('layout');
		$layout['title'] = $cab->title;
		$this->addConfig(['layout', $layout]);
		
		$this->mods = $cab->mods;
	}
	
	function test()
	{
		$migration = new test($this->getProperty('database'));
		
		return ['migrate' => $migration->create('InnoDB', 'utf8')];
	}
}
?>