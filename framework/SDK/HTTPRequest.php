<?php
namespace framework;

class HTTPRequest
{
	var $ch;
	
	function __construct($url)
	{
		$this->ch = curl_init($url);
	}
	
	function setOption($name, $value)
	{
		return curl_setopt($this->ch, $name, $value);
	}
	
	function setOptions($options)
	{
		return curl_setopt_array($this->ch, $options);
	}
	
	function setFile($filename)
	{
		$str = '';
		$chars = 'abcdefghijklmnoprsqtuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
		$len = strlen($chars);
		
		for($i=0;$i<10;$i++)
		{
			$str .= substr($chars, rand(1, $len)-1, 1);
		}
		
		$tmp = $str.'.'.explode('.', $flename)[1];
		return curl_file_create($tmp, $filename);
	}
	
	function getString()
	{
		return curl_exec($this->ch);
	}
	
	function getJson()
	{
		return json_decode(curl_exec($this->ch), true);
	}
	
	function close()
	{
		curl_close($this->ch);
	}
}
?>