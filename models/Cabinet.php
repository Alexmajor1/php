<?php
namespace models;

class Cabinet
{
	private $UserPermissions;
	private $sess;
	public $mods;
	
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
	
	function forumUpdate($req, $db)
	{
		if(key_exists('author', $req->post()))
		{
			$author = $req->post('author');
			$message = $req->post('message');
			
			if($req->get('topic')){
				$topic = new Topic($db);
				$topic->create([
					'theme_id' => $req->get('topic'),
					'user_id' => $author,
					'name' => $message
				]);
			} else if($req->get('theme')){
				$theme = new Theme($db);
				$theme->create([
					'forum_id' => $req->get('theme'),
					'user_id' => $author,
					'name' => $message
				]);
			} else {
				$forum = new Forum($db);
				$forum->create([
					'user_id' => $author,
					'name' => $message
				]);
			}
		}
		if(key_exists('topic', $req->get())){
			$this->mods['table']['mode'] = 'data';
			$this->mods['table']['data']['value'] = $req->get('topic');
		} else if(key_exists('theme', $req->get())){
			$this->mods['table']['mode'] = 'alt';
			$this->mods['table']['alt']['value'] = $req->get('theme');
		} else {
			$this->mods['table']['mode'] = 'main';
		}
		
		$this->mods['text:user']['text'] = $this->sess->getLogin();
		$this->mods['text:role']['text'] = $this->sess->getRole();
		
		$this->mods['form']['fields']['author']['value'] = $this->sess->get_user_id();
		if(count($req->get()) > 0){
			$this->mods['form']['target'] = $req->getCurrentUrl();
		}
	}
}
?>