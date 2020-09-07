<?php
include_once "config\\settings.php";

$tmpls = array('default','admin');
$arr1 = scandir("templates\\default\\kernel\\cfg");
$arr2 = scandir("templates\\admin\\kernel\\cfg");
$files = [array($arr1, $arr2), scandir("controllers")];

function str_rand()
{
	$str = '';
	$chars = 'abcdefghijklmnoprsqtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
	$len = strlen($chars);
	
	for($i=0;$i<10;$i++)
	{
		$str .= substr($chars, rand(1, $len)-1, 1);
	}
	
	return $str;
}

function fileStorage($source, $files)
{
	$aliases = fopen("aliases\\$source".".php","r");
	
	$data = array();
	
	for($i=0;$i<count($files[0]);$i++)
	{
		if(!is_dir($files[0][$i]))
		{
			include_once "views\\page\\cfg\\".$files[0][$i];
			
			if(isset($target))
			{
				array_push($data, $target);
			}
			
			foreach($modules as $value)
			{
				if(key_exists('target', $value))
				{
					array_push($data, $value['target']);
				}
			}
		}
	}
	
	for($i=0;$i<count($files[1]);$i++)
	{
		if(!is_dir($files[1][$i]))
		{
			$file = fopen("controllers\\".$files[1][$i],"r");
			while(!feof($file))
			{
				$str = fgets($file);
				if(strpos($str, 'header'))
				{
					$alias = str_replace("');", '', split(':', $str)[1]);
					array_push($data, $alias);
				}
			}
			
			fclose($file);
		}
	}
	
	array_unique($data);
	
	foreach($data as $value)
	{
		fwrite($aliases, "$value=>index.php?alias=".str_rand().";");
	}
	
	fclose($aliases);
}

function tableStorage($source, $files, $ConData, $tmpls)
{
	include_once "framework\\SDK\\DB.php";
	
	$db = new framework\DB($ConData);
	
	for($i=0;$i<count($files[0]);$i++)
	{
		if(is_array($files[0][$i]))
		{
			for($j=0;$j<count($files[0][$i]);$j++)
			{
				if(!is_dir($files[0][$i][$j]))
				{
					include_once 'templates\\'.$tmpls[$i].'\\kernel\\cfg\\'.$files[0][$i][$j];
					
					if(isset($target))
					{
						$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"$target\"");
							
						if($res == null)
						{
							$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand()."\",\"$target\")");
						}
					}
					
					foreach($modules as $value)
					{
						if(key_exists('target', $value))
						{
							$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"".$value['target']."\"");
							
							if($res == null)
							{
								$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand()."\",\"".$value['target']."\")");
							}
						}
					}
				}
			}
		}
		elseif(!is_dir($files[0][$i]))
		{
			include_once "templates\\default\\kernel\\cfg".$files[0][$i];
			
			if(isset($target))
			{
				$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"$target\"");
					
				if($res == null)
				{
					$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand()."\",\"$target\")");
				}
			}
			
			foreach($modules as $value)
			{
				if(key_exists('target', $value))
				{
					$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"".$value['target']."\"");
					
					if($res == null)
					{
						$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand()."\",\"".$value['target']."\")");
					}
				}
			}
		}
	}
	
	for($i=0;$i<count($files[1]);$i++)
	{
		if(!is_dir($files[1][$i]))
		{
			$file = fopen("controllers\\".$files[1][$i],"r");
			while(!feof($file))
			{
				$str = fgets($file);
				
				if(strpos($str, '$this->toPage'))
				{
					
					$alias = trim(str_ireplace("('", "", str_ireplace("');", "", explode('toPage', $str)[1])));
					
					if(strpos($alias, 'page')) $alias = explode('=', $alias)[1];
					
					$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"index.php?page=$alias\"");
					
					if($res == null)
					{
						$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand()."\",\"index.php?page=$alias\")");
					}
				}
			}
			
			fclose($file);
		}
	}
	echo 'finish';
}

switch($alias['storage'])
{
	case 'file': fileStorage($alias['source'], $files);break;
	case 'table': tableStorage($alias['source'], $files, $database, $tmpls);break;
}
?>