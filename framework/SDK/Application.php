<?php
namespace framework;

class Application
{
	private $cfg;
	private $ctrl;
	private $data;
	
	function __construct($conf)
	{
		$this->cfg = Config::getInstance($conf);
		DB::getInstance($this->cfg->getSetting('database'));
		$alias = new Alias();
		$req = (new Request())->get();
		
		if((!key_exists('page', $req))&&(!key_exists('alias', $req)))
			$page = 'main';
		else
			$page = explode('page=', $alias->decode($req['alias']))[1];
		
		if(stripos($page, '\\') > 0)
			$ctrl = 'controllers\\'.explode('\\', ucfirst($page))[0].'Controller';
		else
			$ctrl = 'controllers\\'.$this->cfg->getSetting('controller');
		
		$this->ctrl = new $ctrl($alias);
	}
	
	function AddData()
	{
		if(isset($this->ctrl->rules))
			foreach($this->ctrl->rules as $rule)
				if($rule != '') {
					$rule = 'rules\\'.$rule.'Rule';
					
					$check = new $rule($this->ctrl);
					$check->path = $this->data;
					$check->execute();
					$this->ctrl = $check->ctrl;
					$this->data = $check->path;
				}
				
		include ($this->data);
		
		$this->ctrl->addConfig(['name', $name]);
		
		$this->ctrl->getPage();
		
		if(isset($modules))
			$this->ctrl->addConfig(['modules', $modules]);
		
		if(isset($modules))
			$this->ctrl->getModules();
		
		if(isset($target))
			$this->ctrl->addConfig(['target', $target]);
		
		if(isset($template))
			$this->ctrl->addConfig(['template', $template]);
		
		if(isset($this->ctrl->widgets))
			foreach($this->ctrl->widgets as $name)
				if($name != '') {
					$class = 'widgets\\'.$name.'Widget';
					$widget = new $class($this->ctrl->getProperty('widgets')[strtolower($name)]);
					if(method_exists($widget, 'execute')) $widget->execute($this->cfg);
					$this->ctrl->mods = $widget->show($this->ctrl->mods);
				}
	}
	
	function route()
	{
		$router = new Router();
		$cfg_file = $router->route();
		
		if($cfg_file) $this->data = $cfg_file;
		else $this->ctrl->logout();
	}
	
	function run()
	{
		$this->addData();
		if($this->ctrl->page->name != 'main') {
			$method = $this->ctrl->page->name;
			
			if(stripos($method, '\\') > 0) $method = explode('\\', $method)[1];
			if($method == 'main') $method = 'index';
			
			$res = $this->ctrl->$method();
			
			if($res){
				header("Content-Type: application/json");
				echo json_encode($res, JSON_PRETTY_PRINT);
				die;
			}
		}
		$this->ctrl->generate();
	}
}
?>