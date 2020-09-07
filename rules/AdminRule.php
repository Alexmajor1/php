<?php
namespace rules;

use framework\Rule;
use framework\Session;

class AdminRule extends Rule
{
	function execute()
	{
		$this->ctrl->addConfig(['site_template', 'admin']);
		
		$settings = $this->ctrl->getProperty('session');
		
		$sess = new Session($this->ctrl->db, $settings);
		
		if($sess->getLogin() == '') $this->ctrl->toPage('main');
	}
}
?>