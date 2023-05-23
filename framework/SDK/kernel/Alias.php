<?php
namespace framework\kernel;

use framework\QueryBuilder;

class Alias
{
	private $cfg;
	private $builder;
	private $path;
	
	function __construct()
	{
		$this->cfg = Config::getInstance();
		$this->builder = new QueryBuilder();
		$this->path = (__DIR__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR
			.'..'.DIRECTORY_SEPARATOR.'aliases'.DIRECTORY_SEPARATOR
			.$this->cfg->getSetting('alias')['source'].'.php';
	}
	
	function encode($data)
	{
		switch($this->cfg->getSetting('alias')['storage']){
			case 'file': return $this->fileEncode($data);break;
			case 'table': return $this->tableEncode($data);break;
		}
	}
	
	function decode($data)
	{
		switch($this->cfg->getSetting('alias')['storage']){
			case 'file': return $this->fileDecode($data);break;
			case 'table': return $this->tableDecode($data);break;
		}
	}
	
	function fileEncode($data)
	{
		$aliasesDB = file_get_contents($this->path);
		$aliases = split(';', $aliasesDB);
		
		foreach($data as $key => $value)
			for($i=0;$i<count($aliases);$i++)
				if(strpos($aliases[$i], $value))
					$data[$key] = split('=>', $aliases[$i])[1];
		
		return $data;
	}
	
	function tableEncode($data)
	{
		$alias = $this->builder->select(
			$this->cfg->getSetting('alias')['source'], 
			['name' => 'name']
		)->where(
			['page' => $data],
		)->value();
		
		if ($alias) return $alias;
		
		return $data;
	}
	
	function fileDecode($data)
	{
		$aliasesDB = file_get_contents($this->path);
		$aliases = split(';', $aliasesDB);
		$data = array();
		
		for($i=0;$i<count($aliases);$i++)
			if(strpos($aliases[$i], $value))
					$data[$key] = split('=>', $aliases[$i])[0];
		
		return (!empty($data))?$data:false;
	}
	
	function tableDecode($data)
	{
		if($data == '') return 'index.php?page=main';
			
		$alias = $this->builder->select(
			$this->cfg->getSetting('alias')['source'], 
			['page' => 'page']
		)->where(['name' => $data])->value();
			
		if($alias) return $alias;
		
		return false;
	}
}
?>