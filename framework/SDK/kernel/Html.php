<?php
namespace framework\kernel;

class Html
{
	private $ldr;
	private $cfg;
	
	function __construct($page)
	{
		$this->ldr = new Loader($page);
		$this->cfg = Config::getInstance();
	}
	
	function draw($cfg, $alias, $mods)
	{	
		foreach($mods as $key => $value)
		{
			if($this->cfg->GetSetting('alias')['mode'] == 'alias')
				if(key_exists('target', $value))
					$value['target'] = $alias->encode($value['target']);
				else
					foreach($value as $mod => $params)
						if(is_array($params) and key_exists('target', $params)){
							$params['target'] = $alias->encode($params['target']);
							$value[$mod] = $params;
						}
			
			if(in_array($key, $this->cfg->GetSetting('plugins'))) $value = $this->ldr->plugin($key, $value);
			
			$this->ldr->GetModule($key, $value);
		}
		
		if($this->cfg->getSetting('target'))
			$this->cfg->setSetting
				('target', $alias->encode
					($this->cfg->getSetting('target')));

		$this->ldr->GetContent();
		$this->ldr->LoadContent();
	}
}
?>