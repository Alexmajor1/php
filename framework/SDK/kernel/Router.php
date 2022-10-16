<?php
namespace framework\kernel;

class Router
{
	private $req;
	private $cfg;
	private $path;
	private $alias;
	
	function __construct()
	{
		$this->req = new \framework\Request();
		$this->cfg = Config::getInstance();
		$this->path = $_SERVER['DOCUMENT_ROOT'].$this->cfg->getSetting('base').DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;
		$this->alias = $this->alias = new Alias();
	}
	
	function route()
	{
		switch($this->cfg->getSetting('alias')['mode']){
			case 'page': return $this->page(); break;
			case 'alias': return $this->alias(); break;
		}
	}
	
	function page()
	{
		if(!key_exists('page', $this->req->get())){
			$this->cfg->setSetting('page','main');
			$page = 'page=main';
		} else {
			$this->cfg->setSetting('page',$this->req->get('page'));
			if($this->req->get['page'] == 'logout') return false;
			
			$page = explode('\\', $this->req->get['page']);
		}
		
		if(count($page) > 1) $tmpl = $page[0];
		else $tmpl = $this->cfg->getSetting('site_template');
		
		return $this->path.$tmpl.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'cfg'.DIRECTORY_SEPARATOR.end($page).".php";
	}
	
	function alias()
	{
		if(!key_exists('alias', $this->req->get())) $page = 'page=main';
		else $page = $this->alias->decode($this->req->get('alias'));
		
		if(count(explode('page=', $page)) > 1) {
			if(explode('page=', $page)[1] == 'logout') return false;
			$page = explode('\\', explode('page=', $page)[1]);
		} else {
			$page = ['404'];
		}
		
		if(count($page) > 1) $tmpl = $page[0];
		else $tmpl = $this->cfg->getSetting('site_template');
		
		return $this->path.$tmpl.DIRECTORY_SEPARATOR.'kernel'.DIRECTORY_SEPARATOR.'cfg'.DIRECTORY_SEPARATOR.end($page).".php";
	}
}
?>