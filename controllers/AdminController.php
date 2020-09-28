<?php
namespace Controllers;

use framework\Controller;

use models\User;

class AdminController extends Controller
{
	public $rule = 'AdminRule';
	
	function index()
	{
		//
	}
	
	function users()
	{
		$model = new User($this->db);
		$res = $model->editor($this->mods, ['User_name', 'User_role']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/users');
		}
	}
}
?>