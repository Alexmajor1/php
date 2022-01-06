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

class AdminController extends Controller
{
	public $rules = ['Admin'];
	public $widgets = ['Menu', 'PageFooter'];
	
	function index()
	{
		$layout = $this->getProperty('layout');
		$layout['title'] = 'Admin panel';
		$this->addConfig(['layout', $layout]);
		
		$users = (new UserEditor($this->db))->rowsCount();
		$this->mods['text']['users']['text'] = "Users count: $users";
		
		$roles = (new RoleEditor($this->db))->rowsCount();
		$this->mods['text']['roles']['text'] = "Roles count: $roles";
		
		$forums = (new ForumEditor($this->db))->rowsCount();
		$this->mods['text']['forums']['text'] = "Forums count: $forums";
		
		$themes = (new ThemeEditor($this->db))->rowsCount();
		$this->mods['text']['themes']['text'] = "Themes count: $themes";
		
		$topics = (new TopicEditor($this->db))->rowsCount();
		$this->mods['text']['topics']['text'] = "Topics count: $topics";
	}
	
	function users()
	{
		$layout = $this->getProperty('layout');
		$model = new UserEditor();
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Users', 'add' => 'Add user', 'edit' => 'Edit user'])]);
		$res = $model->editor($this->mods, ['User_name', 'User_role']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/users');
	}
	
	function roles()
	{
		$layout = $this->getProperty('layout');
		$model = new RoleEditor($this->db);
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Roles', 'add' => 'Add role', 'edit' => 'Edit role'])]);
		$res = $model->editor($this->mods, ['Role_name']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/roles');
	}
	
	function rules()
	{
		$layout = $this->getProperty('layout');
		$model = new RuleEditor($this->db);
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Rules', 'add' => 'Add rule', 'edit' => 'Edit rule'])]);
		$res = $model->editor($this->mods, ['Rule_name', 'Rule_role']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/rules');
	}
	
	function forums()
	{
		$layout = $this->getProperty('layout');
		$model = new ForumEditor($this->db);
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Forums', 'add' => 'Add forum', 'edit' => 'Edit forum'])]);
		$res = $model->editor($this->mods, ['user_id', 'name']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/forums');
	}
	
	function themes()
	{
		$layout = $this->getProperty('layout');
		$model = new ThemeEditor($this->db);
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Themes', 'add' => 'Add theme', 'edit' => 'Edit theme'])]);
		$res = $model->editor($this->mods, ['user_id', 'forum_id', 'name']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/themes');
	}
	
	function topics()
	{
		$layout = $this->getProperty('layout');
		$model = new TopicEditor($this->db);
		$this->addConfig(['layout', $model->getTitle($layout, ['main' => 'Topics', 'add' => 'Add topic', 'edit' => 'Edit topic'])]);
		$res = $model->editor($this->mods, ['user_id', 'theme_id', 'name']);
		
		if(is_array($res)) $this->mods = $res;
		elseif($res) $this->toPage('admin/topics');
	}
}
?>