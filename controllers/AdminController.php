<?php
namespace Controllers;

use framework\Controller;
use framework\Session;

class AdminController extends Controller
{
	function main()
	{
		$settings = $this->getProperty('session');
		
		$sess = new Session($this->db, $settings);
		if($sess->getLogin() == '') $this->toPage('main');
	}
}
?>