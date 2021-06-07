<?php
namespace framework;

class Alias
{
	public $cfg;
	public $db;
	
	function __construct($cfg, $db)
	{
		$this->cfg = $cfg;
		$this->db = $db;
	}
	
	function encode($data)
	{
		switch($this->cfg->getSetting('alias')['storage'])
		{
			case 'file': return $this->fileEncode($data);break;
			case 'table': return $this->tableEncode($data);break;
		}
	}
	
	function decode($data)
	{
		switch($this->cfg->getSetting('alias')['storage'])
		{
			case 'file': return $this->fileDecode($data);break;
			case 'table': return $this->tableDecode($data);break;
		}
	}
	
	function fileEncode($data)
	{
		$path = (__DIR__).'\\..\\..\\aliases\\'.$this->cfg->getSetting('alias')['source'].'.php';
		$file = fopen($path, 'r');
		$aliasesDB = fread($file, filesize($path));
		$aliases = split(';', $aliasesDB);
		
		foreach($data as $key => $value)
		{
			for($i=0;$i<count($aliases);$i++)
			{
				if(strpos($aliases[$i], $value))
				{
					$data[$key] = split('=>', $aliases[$i])[1];
				}
			}
		}
		
		return $data;
	}
	
	function tableEncode($data)
	{
		$alias = $this->db->select($this->cfg->getSetting('alias')['source'], ['name' => 'name'])->where(['page' => $data], '')->value();
			
		if($alias)
		{
			return $alias;
		}
		
		return $data;
	}
	
	function fileDecode($data)
	{
		$path = (__DIR__).'\\..\\..\\aliases\\'.$this->cfg->getSetting('alias')['source'].'.php';
		$file = fopen($path, 'r');
		$aliasesDB = fread($file, filesize($path));
		$aliases = split(';', $aliasesDB);
		$data = array();
		
		for($i=0;$i<count($aliases);$i++)
		{
			if(strpos($aliases[$i], $value))
			{
					$data[$key] = split('=>', $aliases[$i])[0];
			}
		}
		
		return (!empty($data))?$data:false;
	}
	
	function tableDecode($data)
	{
		$alias = $this->db->select($this->cfg->getSetting('alias')['source'], ['page' => 'page'])->where(['name' => $data], '')->value();
			
		if($alias)
		{
			return $alias;
		}
		
		return false;
	}
}
?>