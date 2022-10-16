<?php
namespace rules;

use framework\Rule;
use framework\Session;
use framework\Request;

class AdminRule extends Rule
{
	function execute()
	{
		$this->ctrl->addConfig(['site_template' => 'admin']);
		
		$settings = $this->ctrl->getProperty('session');
		$sess = new Session($settings);
		
		if(strcmp($sess->getLogin(), '') == 0) $this->ctrl->toPage('main');
		
		$arr = explode('cfg'.DIRECTORY_SEPARATOR, $this->path);
		$req = new Request();
		
		if($req->get('mode')) $this->path = $arr[0].'cfg/'.$req->get('mode').'.'.$arr[1];
		else $this->path = $arr[0].'cfg'.DIRECTORY_SEPARATOR.$arr[1];
	}
}
?>