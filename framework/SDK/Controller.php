<?php
namespace framework;
session_start();

class Controller
{
	public $db;
	public $mods = [];
	private $conf;
	public $page;
	public $alias;
	private $html;
	public $rule = '';
	
	function __construct($alias)
	{
		if($alias != null){
			$this->alias = $alias;
			$this->conf = kernel\Config::getInstance();
			$this->db = DB::getInstance();
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
	
	function getPage()
	{
		$this->page = new kernel\Page();
	}
	
	function getPageName()
	{
		return $this->page->name;
	}
	
	function getProperty($name)
	{
		return $this->conf->getSetting($name);
	}
	
	function generate()
	{
		$this->page->drawHtml($this->alias, $this->mods);
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