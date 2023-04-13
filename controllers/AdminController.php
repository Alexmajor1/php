<?php
namespace Controllers;

use framework\Controller;
use framework\Request;

use models\User;
use models\Role;
use models\Rule;
use models\Forum;
use models\Theme;
use models\Topic;

use library\Admin;
use library\General;

class AdminController extends Controller
{
	public $rules = ['Admin'];
	public $widgets = ['Menu', 'PageFooter'];
	
	function index()
	{
		General::getTitle($this, 'Admin panel');
		
		$this->mods['text']['users']['text'] = Admin::count(new User(), 'Users');
		$this->mods['text']['roles']['text'] = Admin::count(new Role(), 'Roles');
		$this->mods['text']['forums']['text'] = Admin::count(new Forum(), 'Forums');
		$this->mods['text']['themes']['text'] = Admin::count(new Theme(), 'Themes');
		$this->mods['text']['topics']['text'] = Admin::count(new Topic(), 'Topics');
	}
	
	function users()
	{
		Admin::tablePages(
			$this, 
			new User(), 
			[
				'main' => 'Users', 
				'add' => 'Add user', 
				'edit' => 'Edit user'
			], 
			[
				'User_name', 
				'User_role'
			], 
			'admin\\\\users'
		);
	}
	
	function roles()
	{
		Admin::tablePages(
			$this, 
			new Role(), 
			[
				'main' => 'Roles', 
				'add' => 'Add role', 
				'edit' => 'Edit role'
			], 
			[
				'Role_name'
			], 
			'admin\\\\roles'
		);
	}
	
	function rules()
	{
		Admin::tablePages(
			$this, 
			new Rule(), 
			[
				'main' => 'Rules', 
				'add' => 'Add Rules', 
				'edit' => 'Edit Rules'
			], 
			[
				'Rule_name', 
				'Rule_role'
			], 
			'admin\\\\rules'
		);
	}
	
	function forums()
	{
		Admin::tablePages(
			$this, 
			new Forum(), 
			[
				'main' => 'Forums', 
				'add' => 'Add forum', 
				'edit' => 'Edit forum'
			], 
			[
				'user_id', 
				'name'
			], 
			'admin\\\\forums'
		);
	}
	
	function themes()
	{
		Admin::tablePages(
			$this, 
			new Theme(), 
			[
				'main' => 'Themes', 
				'add' => 'Add theme', 
				'edit' => 'Edit theme'
			], 
			[
				'user_id', 
				'forum_id', 
				'name'
			], 
			'admin\\\\themes'
		);
	}
	
	function topics()
	{
		Admin::tablePages(
			$this, 
			new Topic(), 
			[
				'main' => 'Topics', 
				'add' => 'Add topic', 
				'edit' => 'Edit topic'
			], 
			[
				'user_id', 
				'theme_id', 
				'name'
			], 
			'admin\\\\topics'
		);
	}
}
?>