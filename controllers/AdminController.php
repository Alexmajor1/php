<?php
namespace Controllers;

use framework\Controller;

use models\User;
use models\Role;
use models\Rule;
use models\Forum;
use models\Theme;
use models\Topic;

class AdminController extends Controller
{
	public $rule = 'AdminRule';
	
	function index()
	{
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