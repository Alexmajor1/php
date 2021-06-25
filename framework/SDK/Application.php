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
		$this->cfg = Config::getInstance($conf);
		$this->db = DB::getInstance($this->cfg->getSetting('database'));
		$this->alias = new Alias();
		
		$req = new Request();
		
		if((!key_exists('page', $req->get()))&&(!key_exists('alias', $req->get()))){
			$page = 'main';
		} else {
			$page = explode('page=', $this->alias->decode($req->get('alias')))[1];
		}
		
		if(stripos($page, '\\') > 0)
			$ctrl = 'controllers\\'.explode('\\', ucfirst($page))[0].'Controller';
		else
			$ctrl = 'controllers\\'.$this->cfg->getSetting('controller');
		
		$this->ctrl = new $ctrl($this->alias);
	}
	
	function AddData()
	{
		include ($this->data);
		
		$this->ctrl->addConfig(['name', $name]);
		$this->ctrl->addConfig(['modules', $modules]);
		
		$this->ctrl->getPage();
		
		$this->ctrl->getModules();
		
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
				if(!key_exists('page', $req->get())){
					$this->ctrl->addConfig(['page','main']);
					
					$page = 'page=main';
				} else {
					$this->ctrl->addConfig(['page',$req->get('page')]);
					if($req->get['page'] == 'logout')
					{
						$this->ctrl->logout();
					}
					
					$page = explode('\\', $req->get['page']);
				}
				
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
					$page = 'page=main';
				} else {
					$page = $this->alias->decode($req->get('alias'));
				}
				
				if(explode('page=', $page)[1] == 'logout')
				{
					$this->ctrl->logout();
				}
				
				$page = explode('\\', explode('page=', $page)[1]);
				
				if(count($page) > 1){
					$tmpl = $page[0];
				} else {
					$tmpl = $this->ctrl->getProperty('site_template');
				}
				
				$this->data = $_SERVER['DOCUMENT_ROOT'].'/'.$this->ctrl->getProperty('base')."/templates/".$tmpl."/kernel/cfg/".end($page).".php";
			};
			break;
			echo 'route';
		}
		
		if(isset($this->ctrl->rules))
		{
			foreach($this->ctrl->rules as $rule)
			{
				if($rule != '')
				{
					$rule = 'rules\\'.$rule.'Rule';
					
					$check = new $rule($this->ctrl);
					$check->path = $this->data;
					$check->execute();
					$this->ctrl = $check->ctrl;
					$this->data = $check->path;
				}
			}
		}
		
		$this->addData();
		
		if(isset($this->ctrl->widgets))
		{
			foreach($this->ctrl->widgets as $name)
			{
				if($name != '')
				{
					$class = 'widgets\\'.$name.'Widget';
					$widget = new $class($this->ctrl->getProperty('widgets')[strtolower($name)]);
					if(method_exists($widget, 'execute')) $widget->execute($this->cfg);
					$this->ctrl->mods = $widget->show($this->ctrl->mods);
				}
			}
		}
	}
	
	function run()
	{
		if($this->ctrl->page->name != 'main')
		{
			$method = $this->ctrl->page->name;
			
			if(stripos($method, '\\') > 0)
				$method = explode('\\', $method)[1];
			if($method == 'main') $method = 'index';
			
			$this->ctrl->$method();
		}
		$this->ctrl->generate();
	}
}
?>