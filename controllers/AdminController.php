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

class AdminController extends Controller
{
	public $rules = ['Admin'];
	public $widgets = ['Menu', 'PageFooter'];
	
	function index()
	{
		$layout = $this->getProperty('layout');
		$layout['title'] = 'Admin panel';
		$this->addConfig(['layout', $layout]);
		
		$users = count((new User($this->db))->read(['id']));
		$this->mods['text']['users']['text'] = "Users count: $users";
		
		$roles = count((new Role($this->db))->read(['id']));
		$this->mods['text']['roles']['text'] = "Roles count: $roles";
		
		$forums = count((new Forum($this->db))->read(['id']));
		$this->mods['text']['forums']['text'] = "Forums count: $forums";
		
		$themes = count((new Theme($this->db))->read(['id']));
		$this->mods['text']['themes']['text'] = "Themes count: $themes";
		
		$topics = count((new Topic($this->db))->read(['id']));
		$this->mods['text']['topics']['text'] = "Topics count: $topics";
	}
	
	function users()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit user';
			else $layout['title'] = 'Add user';
		}
		else $layout['title'] = 'Users';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new User($this->db);
		$res = $model->editor($this->mods, ['User_name', 'User_role']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/users');
		}
	}
	
	function roles()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit role';
			else $layout['title'] = 'Add role';
		}
		else $layout['title'] = 'Roles';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new Role($this->db);
		$res = $model->editor($this->mods, ['Role_name']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/roles');
		}
	}
	
	function rules()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit rule';
			else $layout['title'] = 'Add rule';
		}
		else $layout['title'] = 'Rules';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new Rule($this->db);
		$res = $model->editor($this->mods, ['Rule_name', 'Rule_role']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/rules');
		}
	}
	
	function forums()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit forum';
			else $layout['title'] = 'Add forum';
		}
		else $layout['title'] = 'Forums';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new Forum($this->db);
		$res = $model->editor($this->mods, ['user_id', 'name']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/forums');
		}
	}
	
	function themes()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit theme';
			else $layout['title'] = 'Add theme';
		}
		else $layout['title'] = 'Themes';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new Theme($this->db);
		$res = $model->editor($this->mods, ['user_id', 'forum_id', 'name']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/themes');
		}
	}
	
	function topics()
	{
		$layout = $this->getProperty('layout');
		$mode = (new Request())->get('mode');
		$id = (new Request())->get('id');
		
		if($mode)
		{
			if($id) $layout['title'] = 'Edit topic';
			else $layout['title'] = 'Add topic';
		}
		else $layout['title'] = 'Topics';
		
		$this->addConfig(['layout', $layout]);
		
		$model = new Topic($this->db);
		$res = $model->editor($this->mods, ['user_id', 'theme_id', 'name']);
		
		if(is_array($res)){
			$this->mods = $res;
		}elseif($res){
			$this->toPage('admin/topics');
		}
	}
}
?>