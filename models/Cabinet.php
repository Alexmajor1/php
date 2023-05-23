<?php
namespace models;

class Cabinet
{
	private $UserPermissions;
	private $sess;
	public $mods;
	public $title = 'Cabinet';
	
	function __construct($sess, $mods)
	{
		$this->UserPermissions = $sess->getPermissions();
		$this->sess = $sess;
		$this->mods = $mods;
	}
	
	function CheckPermission($permission)
	{
		return in_array($this->UserPermissions, $permission, true);
	}
	
	function forumUpdate($req)
	{
		$forum = new Forum();
		$theme = new Theme();
		$topic = new Topic();
		
		if(key_exists('author', $req->post()))
		{
			$author = $req->post('author');
			$message = $req->post('message');
			
			if($req->get('theme')){
				$topic->create([
					'theme_id' => $req->get('theme'),
					'user_id' => $author,
					'name' => $message
				]);
			} else if($req->get('forum')){
				$theme->create([
					'forum_id' => $req->get('forum'),
					'user_id' => $author,
					'name' => $message
				]);
			} else {
				$res = $forum->create([
					'user_id' => $author,
					'name' => $message
				]);
			}
		}
		
		if(key_exists('theme', $req->get())){
			$this->title = $theme->read(['name' => 'name'], ['id' => $req->get('theme')])->title;
			$this->mods['table']['mode'] = 'data';
			$this->mods['table']['data']['value'] = $req->get('theme');
		} else if(key_exists('forum', $req->get())){
			$this->title = $forum->read(['name' => 'name'], ['id' => $req->get('forum')])->title;
			$this->mods['table']['mode'] = 'alt';
			$this->mods['table']['alt']['value'] = $req->get('forum');
		} else {
			$this->mods['table']['mode'] = 'main';
		}
		
		$this->mods['text']['user']['text'] = $this->sess->getLogin();
		$this->mods['text']['role']['text'] = $this->sess->getRole();
		$this->mods['form']['fields']['author']['value'] = $this->sess->get_user_id();
		
		if(count($req->get()) > 0)
			$this->mods['form']['target'] = $req->getCurrentUrl();
	}
}
?>