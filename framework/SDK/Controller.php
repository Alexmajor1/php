<?php
namespace framework;
session_start();

class Controller
{
	public $mods = [];
	private $conf;
	private $page;
	private $alias;
	public $rule = '';
	
	function __construct($alias)
	{
		if($alias != null){
			$this->alias = $alias;
			$this->conf = kernel\Config::getInstance();
			$this->page = new kernel\Page();
		}
	}
	
	function addConfig($cfg)
	{
		$this->conf->setSetting(array_key_first($cfg), array_values($cfg)[0]);
	}
	
	function getModules()
	{
		$this->mods = array_merge($this->conf->getSetting('modules'), $this->mods);
	}
	
	function getPageName()
	{
		return $this->page->getName();
	}
	
	function getProperty($name)
	{
		return $this->conf->getSetting($name);
	}
	
	function editConfig($src)
	{
		$this->conf->changeSource($src);
	}
	
	function checkRules(&$ctrl, &$data)
	{
		if(isset($this->rules))
			foreach($this->rules as $rule)
				if($rule != '') {
					$rule = 'rules\\'.$rule.'Rule';
					
					$check = new $rule($this);
					$check->path = $data;
					$check->execute();
					$ctrl = $check->ctrl;
					$data = $check->path;
				}
		if(!isset($data)) return $ctrl->addConfig(['name'  => '403']);
		$ctrl->editConfig($data);
	}
	
	function getWidgets()
	{
		if(isset($this->widgets))
			foreach($this->widgets as $name)
				if($name != '') {
					$class = 'widgets\\'.$name.'Widget';
					$widget = new $class($this->getProperty('widgets')[strtolower($name)]);
					if(method_exists($widget, 'execute')) $widget->execute($this->conf);
					$this->mods = $widget->show($this->mods);
				}
		
		$this->addConfig(['modules' => $this->mods]);
	}
	
	function generate()
	{
		$this->page->PrintPage();
	}
	
	function getError($err)
	{
		setcookie('error', $err, ['expires' => time()+1, 'httponly' => true]);
	}
	
	function toPage($name)
	{
		if($name != 'main') $header = $this->alias->encode('index.php?page='.$name);
		else $header = '/'.$this->getProperty('base');
		
		header("location:$header");
		die;
	}
}
?>