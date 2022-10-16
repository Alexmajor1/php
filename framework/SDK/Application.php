<?php
namespace framework;

class Application
{
	private $cfg;
	private $ctrl;
	private $data;
	
	function __construct($conf)
	{
		$this->cfg = kernel\Config::getInstance($conf);
		DB::getInstance($this->cfg->getSetting('database'));
		$alias = new kernel\Alias();
		$req = (new Request())->get();
		
		if((!key_exists('page', $req))&&(!key_exists('alias', $req)))
			$page = 'main';
		elseif($alias->decode($req['alias']))
			$page = explode('page=', $alias->decode($req['alias']))[1];
		else
			$page = '404';
		
		if(stripos($page, '\\') > 0)
			$ctrl = 'controllers\\'.explode('\\', ucfirst($page))[0].'Controller';
		else
			$ctrl = 'controllers\\'.$this->cfg->getSetting('controller');
		
		$this->ctrl = new $ctrl($alias);
		if($ctrl != 'controllers\\'.$this->cfg->getSetting('controller'))
			$this->ctrl->addConfig(['site_template' => explode('\\', $page)[0]]);
	}
	
	function AddData()
	{
		include ($this->data);
		
		if(!isset($name)) return null;
		$this->ctrl->addConfig(['name'  => $name]);
		
		$this->ctrl->getPage();
		
		if(isset($modules)){
			$this->ctrl->addConfig(['modules' => $modules]);
			$this->ctrl->getModules();
		}
		
		if(isset($target))
			$this->ctrl->addConfig(['target' => $target]);
		
		if(isset($template))
			$this->ctrl->addConfig(['template' => $template]);
		
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
		$router = new kernel\Router();
		$cfg_file = $router->route();
		
		if($cfg_file) $this->data = $cfg_file;
		else $this->ctrl->logout();
	}
	
	function run()
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
		if(!isset($this->data)) return $this->ctrl->addConfig(['name'  => '403']);
		$this->addData();
		
		if($this->ctrl->getPageName() != 'main') {
			$method = $this->ctrl->getPageName();
			
			if(stripos($method, '\\') > 0) $method = explode('\\', $method)[1];
			if($method == 'main') $method = 'index';
			
			if(method_exists($this->ctrl, $method)) {
				$res = $this->ctrl->$method();
				if($res){
					header("Content-Type: application/json");
					echo json_encode($res, JSON_PRETTY_PRINT);
					return null;
				}
			}
		}
		$this->ctrl->generate();
	}
}
?>