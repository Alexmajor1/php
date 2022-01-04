<?php
namespace rules;

use framework\Rule;
use framework\Request;

class AuthRule extends Rule
{
	function execute()
	{
		$req = new Request();
		
		if(key_exists('token', $req->cookie())) {
			$sess = new Session($this->getProperty('session'), $auth->getUserByToken());
			$sess->create();
			$this->toPage('cabinet');
		}
		
		if($this->ctrl->getProperty('name') == 'authorization' and !$req->post('User')) $this->ctrl->toPage('main');
	}
}
?>