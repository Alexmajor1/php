<?php
namespace framework\kernel;

class Page
{
	private $name;
	private $loader;
	private $cfg;
	
	function __construct()
	{
		$this->cfg = Config::getInstance();
		$this->name = $this->cfg->GetSetting('name');
		
	}
	
	function getName()
	{
		return $this->name;
	}
	
	function PrintPage()
	{
		$this->loader = new Loader($this);
		$this->loader->setContent();
		$result = preg_replace('/\s\w+="{\w+}"/', '', $this->loader->getContent());
		$result = preg_replace('/{\w+}/', '', $result);
		$lang = new Localization($this->cfg);
		$result = $lang->translate($result);
		
		echo $result;
	}
}
?>