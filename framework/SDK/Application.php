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
		$cache = Cache::getInstance($this->cfg);
		$cache->clear(true);
	}
	
	function route()
	{
		$router = new kernel\Router();
		$cfg_file = $router->route();
		
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
		
		if($cfg_file){
			$this->data = $cfg_file;
			$this->cfg->addSource($this->data);
		}
		
		$this->ctrl = new $ctrl($alias);
		if($ctrl != 'controllers\\'.$this->cfg->getSetting('controller'))
			$this->ctrl->addConfig(['site_template' => explode('\\', $page)[0]]);
		
		if(!$cfg_file) $this->ctrl->logout();
	}
	
	function run()
	{
		$this->ctrl->checkRules($this->ctrl, $this->data);
		$this->ctrl->getModules();
		$this->ctrl->getWidgets();
		
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
		$this->cfg->setSetting('modules', $this->ctrl->mods);
		$this->ctrl->generate();
	}
}
?>