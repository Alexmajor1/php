<?php
include_once "config\\settings.php";

$tmpls = array('default','admin');
$files = array();

foreach($tmpls as $tmpl)
{
	$dir = scandir("templates\\$tmpl\\kernel\\cfg");
	
	foreach($dir as $file)
		$files[] = "templates\\$tmpl\\kernel\\cfg\\$file";
}

function str_rand()
{
	$str = '';
	$chars = 'abcdefghijklmnoprsqtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
	$len = strlen($chars);
	
	for($i=0;$i<10;$i++)
		$str .= substr($chars, rand(1, $len)-1, 1);
	
	return $str;
}

function fileStorage($source, $files)
{
	$data = array();
	
	foreach($files as $file)
		if(!is_dir($file))
		{
			include_once $file;
			
			foreach($modules as $module)
				if(key_exists('target', $module))
					array_push($data, $module['target']);
		}
	
	array_unique($data);
	
	$aliases = fopen("aliases\\$source".".php","a+");
	
	foreach($data as $value)
		fwrite($aliases, "$value=>index.php?alias=".str_rand().";");
	
	fclose($aliases);
}

function tableStorage($source, $files, $ConData, $tmpls)
{
	include_once "framework\\SDK\\DB.php";
	
	$db = new framework\DB($ConData);
	
	foreach($files as $file)
		if(!is_dir($file))
		{
			echo $file.'<br>';
			
			include_once $file;
			
			foreach($modules as $name => $module)
				if(key_exists('target', $module))
				{
					echo $module['target'].'<br>';
					
					$res = $db->ValueQuery("SELECT id FROM $source WHERE page=\"".$module['target'].'"');
					
					if($res == null)
					{
						echo "ADD $name<br>";
						
						$res = $db->ChangeQuery("INSERT INTO $source(name, page) VALUES(\"".str_rand().'","'.$module['target'].'")');
					}
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