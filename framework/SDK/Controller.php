<?php
namespace framework;
session_start();

class Controller
{
	public $db;
	public $mods;
	private $conf;
	public $page;
	public $alias;
	private $html;
	public $rule = '';
	
	function __construct($data)
	{
		if($data == null) return $this;
		$this->alias = $data;
		$this->db = $this->alias->db;
		$this->conf = $this->alias->cfg;
	}
	
	function addConfig($cfg)
	{
		$this->conf->setSetting($cfg[0], $cfg[1]);
	}
	
	function getModules()
	{
		$this->mods = array_merge($this->conf->getSetting('modules'), $this->mods);
	}
	
	function getPage()
	{
		$this->page = new Page($this->conf, $this->db);
	}
	
	function getProperty($name)
	{
		return $this->conf->getSetting($name);
	}
	
	function generate()
	{
		$this->page->html->draw($this->conf, $this->alias, $this->mods);
	}
	
	function getError($err)
	{
		setcookie('error', $err, time()+1);
	}
	
	function toPage($name)
	{
		if($name != 'main')
			$header = $this->alias->encode('index.php?page='.$name);
		else
			$header = '/'.$this->getProperty('base');
		
		header("location:$header");
	}
}
?>