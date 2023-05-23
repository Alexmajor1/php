<?php
namespace framework\kernel;

class Html
{
	private $cfg;
	public $content;
	
	function __construct($path)
	{
		$this->cfg = Config::getInstance();
		$this->content = file_get_contents($path);
	}
	
	function setData($data)
	{
		foreach($data as $key => $value){
			if(!is_array($value))
				$this->content = str_replace('{'.$key.'}', $value, $this->content);
		}
	}
}
?>