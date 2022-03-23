<?php
namespace Controllers;

use framework\Controller;
use framework\Request;

use models\editors\UserEditor;
use models\editors\RoleEditor;
use models\editors\RuleEditor;
use models\editors\ForumEditor;
use models\editors\ThemeEditor;
use models\editors\TopicEditor;

use library\Admin;
use library\General;

class AdminController extends Controller
{
	public $rules = ['Admin'];
	public $widgets = ['Menu', 'PageFooter'];
	
	function index()
	{
		General::getTitle($this, 'Admin panel');
		
		$this->mods['text']['users']['text'] = Admin::count(new UserEditor(), 'Users');
		$this->mods['text']['roles']['text'] = Admin::count(new RoleEditor(), 'Roles');
		$this->mods['text']['forums']['text'] = Admin::count(new ForumEditor(), 'Forums');
		$this->mods['text']['themes']['text'] = Admin::count(new ThemeEditor(), 'Themes');
		$this->mods['text']['topics']['text'] = Admin::count(new TopicEditor(), 'Topics');
	}
	
	function users()
	{
		Admin::tablePages($this, new UserEditor(), ['main' => 'Users', 'add' => 'Add user', 'edit' => 'Edit user'], ['User_name', 'User_role'], 'admin/users');
	}
	
	function roles()
	{
		Admin::tablePages($this, new RoleEditor(), ['main' => 'Roles', 'add' => 'Add role', 'edit' => 'Edit role'], ['Role_name'], 'admin/roles');
	}
	
	function rules()
	{
		Admin::tablePages($this, new RuleEditor(), ['main' => 'Rules', 'add' => 'Add Rules', 'edit' => 'Edit Rules'], ['Rule_name', 'Rule_role'], 'admin/rules');
	}
	
	function forums()
	{
		Admin::tablePages($this, new ForumEditor(), ['main' => 'Forums', 'add' => 'Add forum', 'edit' => 'Edit forum'], ['user_id', 'name'], 'admin/forums');
	}
	
	function themes()
	{
		Admin::tablePages($this, new ThemeEditor(), ['main' => 'Themes', 'add' => 'Add theme', 'edit' => 'Edit theme'], ['user_id', 'forum_id', 'name'], 'admin/themes');
	}
	
	function topics()
	{
		Admin::tablePages($this, new TopicEditor(), ['main' => 'Topics', 'add' => 'Add topic', 'edit' => 'Edit topic'], ['user_id', 'theme_id', 'name'], 'admin/topics');
	}
}
?>