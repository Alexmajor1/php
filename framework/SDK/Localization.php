<?php
namespace framework;

class Localization
{
	private $lang = '';
	private $dict = [];
	
	function __construct($cfg)
	{
		$req = new Request();
		
		$this->lang = $req->get('lang');
		
		if(strlen($this->lang) > 0){
			$path = $_SERVER['DOCUMENT_ROOT'].$cfg->GetSetting('base').'/languages/'.$this->lang.'.html';
			if(file_exists($path)){
				$content = file_get_contents($path);
				$tmp = explode("\n", $content);
				
				foreach($tmp as $item){
					$str = explode('=', $item);
					$this->dict[$str[0]] = $str[1];
				}
			}
		}
	}
	
	function translate($content)
	{
		foreach($this->dict as $source => $target)
			$content = str_ireplace($source, $target, $content);
		
		return $content;
	}
}
?>