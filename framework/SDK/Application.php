<?php
namespace framework;

class Application
{
	private $cfg;
	private $db;
	private $alias;
	private $ctrl;
	private $data;
	
	function __construct($conf)
	{
		$this->cfg = new Config($conf);
		$this->db = new DB($this->cfg->getSetting('database'));
		$this->alias = new Alias($this->cfg, $this->db);
		
		$req = new Request();
		$page = explode('page=', $this->alias->decode($req->get('alias')))[1];
		
		if(stripos($page, '/') > 0)
			$ctrl = 'controllers\\'.explode('/', ucfirst($page))[0].'Controller';
		else
			$ctrl = 'controllers\\'.$this->cfg->getSetting('controller');
		
		$this->ctrl = new $ctrl($this->alias);
	}
	
	function AddData()
	{
		include ($this->data);
		
		$this->ctrl->addConfig(['name', $name]);
		$this->ctrl->addConfig(['modules', $modules]);
		
		$this->ctrl->getModules();
		$this->ctrl->getPage();
		
		if(isset($target))
		{
			$this->ctrl->addConfig(['target', $target]);
		}
		
		if(isset($template))
		{
			$this->ctrl->addConfig(['template', $template]);
		}
	}
	
	function route()
	{
		$req = new Request();
		
		switch($this->ctrl->getProperty('alias')['mode'])
		{
			case 'page':
			{
				if(!key_exists('page', $req->get)) header('location:index.php?page=main');
				$this->ctrl->addConfig(['page',$req->get('page')]);
				if($req->get['page'] == 'logout')
				{
					$this->ctrl->logout();
				}
				
				$page = explode('/', $req->get['page']);
				
				if(count($page) > 1){
					$tmpl = $page[0];
				} else {
					$tmpl = $this->ctrl->getProperty('site_template');
				}
				
				$this->data = $_SERVER['DOCUMENT_ROOT']."".$this->ctrl->getProperty('base')."/templates/".$tmpl."/kernel/cfg/".end($page).".php";
			};
			break;
			case 'alias':
			{
				if(!key_exists('alias', $req->get()))
				{
					$main = $this->alias->encode('index.php?page=main');
					header("location: $main");
				}
		
				$page = $this->alias->decode($req->get('alias'));
				
				if(explode('page=', $page)[1] == 'logout')
				{
					$this->ctrl->logout();
				}
				
				$page = explode('/', explode('page=', $page)[1]);
				
				if(count($page) > 1){
					$tmpl = $page[0];
				} else {
					$tmpl = $this->ctrl->getProperty('site_template');
				}
				
				$this->data = $_SERVER['DOCUMENT_ROOT'].'/'.$this->ctrl->getProperty('base')."/templates/".$tmpl."/kernel/cfg/".end($page).".php";
			};
			break;
		}
		
		$this->addData();
	}
	
	function run()
	{
		if($this->ctrl->page->name != 'main')
		{
			$method = $this->ctrl->page->name;
			if(stripos($method, '\\') > 0)
				$method = explode('\\', $method)[1];
			
			$this->ctrl->$method();
		}
		$this->ctrl->generate();
	}
}
?>