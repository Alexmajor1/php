<?php
namespace rules;

use framework\Rule;
use framework\Session;

class CabinetRule extends Rule
{
	function execute()
	{
		if($this->ctrl->getProperty('name') == 'cabinet'){
			$settings = $this->ctrl->getProperty('session');
			$sess = new Session($settings);
			
			if($sess->getLogin() == '') $this->ctrl->toPage('main');
		}
	}
}
?>