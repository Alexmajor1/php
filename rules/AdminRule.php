<?php
namespace rules;

use framework\Rule;
use framework\Session;
use framework\Request;

class AdminRule extends Rule
{
	function execute()
	{
		$this->ctrl->addConfig(['site_template', 'admin']);
		
		$settings = $this->ctrl->getProperty('session');
		
		$sess = new Session($this->ctrl->db, $settings);
		if($sess->getLogin() == '') $this->ctrl->toPage('main');
		
		$arr = explode('cfg/', $this->path);
		
		$req = new Request();
		if($req->get('mode')){
			$this->path = $arr[0].'cfg/'.$req->get('mode').'.'.$arr[1];
		}else
			$this->path = $arr[0].'cfg/'.$arr[1];
	}
}
?>