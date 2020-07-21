<?php
namespace Controllers;

use framework\Controller;
use framework\Session;

class AdminController extends Controller
{
	function main()
	{
		$this->addConfig(['site_template', 'admin']);
		
		$settings = $this->getProperty('session');
		
		$sess = new Session($this->db, $settings);
		if($sess->getLogin() == '') $this->toPage('main');
	}
}
?>