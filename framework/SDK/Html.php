<?php
namespace framework;

class Html
{
	private $ldr;
	private $page;
	
	function __construct($page, $db)
	{
		$this->page = $page;
		$this->ldr = new Loader($this->page, $db);
	}
	
	function draw($cfg, $alias, $mods)
	{
		$this->ldr->setConfig($cfg);
		foreach($mods as $key => $value)
		{
			if($cfg->GetSetting('alias')['mode'] == 'alias')
			{
				if(key_exists('target', $value))
				{
					$value['target'] = $alias->encode($value['target']);
				}else
				{
					foreach($value as $mod => $params)
					{
						if(is_array($params) and key_exists('target', $params))
						{
							$params['target'] = $alias->encode($params['target']);
							$value[$mod] = $params;
						}
					}
				}
				
			}
			
			switch($key)
			{
				case 'table':$value = $this->ldr->table($value);;break;
				case 'group':$value = $this->ldr->group($key, $value, 'radio');;break;
				case 'menu':$value = $this->ldr->menu($key, $value);break;
				case 'listbox':$value = $this->ldr->listbox($key, $value);break;
				case 'form':$value = $this->ldr->form($key, $value);break;
			}
			
			$this->ldr->GetModule($key, $value);
		}
		
		if($cfg->getSetting('target'))
		{
			$cfg->setSetting
				('target', $alias->encode
					($cfg->getSetting('target')));
		}
		
		$this->ldr->setConfig($cfg);
		$this->ldr->GetContent($this->page->name);
		$this->ldr->LoadContent();
	}
}
?>