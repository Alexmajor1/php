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
		
		$this->ctrl->mods =[
			'menu' => [
				'id' => 'mainmenu',
				'menuitems' => [
					'homePage' =>
					[
						'caption' => 'home page',
						'url' => 'index.php?page=admin\\\\main'
					],
					'users' => [
						'caption' => 'users',
						'url' => 'index.php?page=admin\\\\users'
					],
					'roles' => [
						'caption' => 'roles',
						'url' => 'index.php?page=admin\\\\roles'
					],
					'rules' => [
						'caption' => 'rules',
						'url' => 'index.php?page=admin\\\\rules'
					],
					'forums' => [
						'caption' => 'forums',
						'url' => 'index.php?page=admin\\\\forums'
					],
					'themes' => [
						'caption' => 'themes',
						'url' => 'index.php?page=admin\\\\themes'
					],
					'topics' => [
						'caption' => 'topics',
						'url' => 'index.php?page=admin\\\\topics'
					],
					'logout' => [
						'caption' => 'logout',
						'url' => 'index.php?page=logout'
					],
				]
			],
		];
	}
}
?>